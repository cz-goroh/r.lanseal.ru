<?php
//$post= Secure::PostText($_POST);
$st_id=$id;
if(isset($_POST['acp'])){//функция юриста одобрить
    $id_rol= Secure::PostText($_POST)['acp'];
    $statser= Dbq::AtomSel('status', 'rolik', 'id', $id_rol);
    $statarr= unserialize($statser);
    $statarr['app'][]=$st_id;
    if(!empty($statarr['rej'])){
    $rejkey= array_keys($statarr['rej'], $st_id)[0];
    unset($statarr['rej'][$rejkey]);
    }
    if(!empty($statarr['upl'])){
    unset($statarr['upl']);}
    if(!empty($statarr['red'])){
    unset($statarr['red']);}
    $statser= serialize($statarr);
    $acq="UPDATE rolik SET `status`='$statser' WHERE `id`=$id_rol";
    Dbq::InsDb($acq);
    $apq="UPDATE bid SET `status`='man_ap' WHERE `rolik_id`=$id_rol AND "
            . "`status`='cl_app'";
    Dbq::InsDb($apq);
    echo 'Одобрен';
    exit();
}
if(isset($_POST['rj']))://функция юриста отклонить
//    $post= Secure::PostText($_POST);
    $rj=$post['rj'];
    $statser= Dbq::AtomSel('status', 'rolik', 'id', $rj);
    $statarr= unserialize($statser);
    $statarr['rej'][]=$st_id;
    if(!empty($statarr['upl'])){
    unset($statarr['upl']);}
    if(!empty($statarr['red'])){
    unset($statarr['red']);}
    $statser= serialize($statarr);
    $descser= Dbq::AtomSel('descr', 'rolik', 'id', $rj);
    $descrar= unserialize($descser);
    $descrar[$st_id]=$post['des'];
    $descser= serialize($descrar);
    $rjq="UPDATE rolik SET `status`='$statser',`descr`='$descser' WHERE `id`=$rj";
    Dbq::InsDb($rjq);
    echo 'отправлено';
    exit();
endif;
if(isset($_POST['upd_loy'])){
    if(!empty($post['loypass'])){
        $phash=password_hash($post['loypass'],PASSWORD_BCRYPT);
        $loypass=",`pass`='$phash'";
    } else {
        $loypass='';
    }
    $nm= $post['loynm'];
    $sn= $post['loysn'];
    $login= $post['loylogin'];
    $tel=$post['loytel'];
    $lus_id= $post['upd_loy'];
    $ulpdlq="UPDATE users SET `login`='$login',`name`='$nm',`surname`='$sn',"
            . "`tel`='$tel'$loypass WHERE `id`=$lus_id";
    //    echo $ulpdlq;    
    Dbq::InsDb($ulpdlq);
    
    header('Location: /cabinet/r_mancab/2');
}
if(isset($_POST['change_pass'])){
    $hashpass= Dbq::AtomSel('pass', 'users', 'id', $usid);
    if($post['new_pass']===$post['new_reppass']){
        if(password_verify($post['curr_pass'], $hashpass)){
            $new_pass=password_hash($post['new_pass'],PASSWORD_BCRYPT);
            $npq="UPDATE users SET `pass`='$new_pass' WHERE `id`=$usid";
            Dbq::InsDb($npq);
            echo 'Пароль обновлён';
        } else { echo 'Неверный текущий пароль'; }
    } else { echo 'Новые пароли не совпадают'; }
    exit();
    }
if(isset($_POST['pay_sh'])){
    $sh_id=$post['pay_sh'];
    $pq="UPDATE shcet SET `status`='payd' WHERE `id`=$sh_id";
    Dbq::InsDb($pq);
        $cbq="UPDATE bid SET `status`='payd' WHERE `sh_num`=$sh_id";
        Dbq::InsDb($cbq);
    echo 'Оплачен';
    exit();
}

if(isset($_POST['snd_plan'])){
    $sh_num=$post['snd_plan'];
    $bq="SELECT * FROM bid WHERE `radio_id`=$id AND `status`='payd' "
            . "AND `sh_num`=$sh_num ORDER BY `b_time`";
    $barr= Dbq::SelDb($bq);
    $mails= Dbq::AtomSel('trafik_mail', 'sation', 'id', $id);
    $mes='Медиаплан во вложении';
    $name='Трафик-менеджеру';
    $subj='Медиаплан';
    
    ob_start();
    include ROOT.'/views/blanc/snd_spis.php';
    $htmlBody= ob_get_contents();
    ob_end_clean();
    //Secure::mailYand($mails, $mes, $htmlBody, $name, $subj);

    ob_start();
    include ROOT.'/views/blanc/snd_plan1.php';
    $html1=ob_get_contents();
    ob_end_clean();
    
//    ob_start();
//    include ROOT.'/views/blanc/snd_plan2.php';
//    $html2=ob_get_contents();
//    ob_end_clean();
    
    error_reporting (E_ERROR);
        $mpdf = new mPDF('utf-8', 'A4-L', 8, '', 10, 10, 7, 7, 10, 10); /*задаем формат, отступы и.т.д.*/
        //$mpdf->charset_in = 'cp1251'; /*не забываем про русский*/
        $stylesheet = file_get_contents(ROOT.'/style.css'); /*подключаем css*/
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->list_indent_first_level = 0; 
        $mpdf->WriteHTML($html1, 2); /*формируем pdf*/
        $vy[1]=ROOT.'/doc/plan1.pdf';
        $mpdf->Output($vy[1], 'F');
        
        ini_set('display_errors',1);
        error_reporting(E_ALL);
        $fn[1]='plan1.pdf';
        
    Secure::mailYand($mails, $mes, $htmlBody, $name, $subj,$vy,$fn);
    
    unlink($vy[1]);
    echo 'Отправлено';
    exit();
}

if(isset($_POST['new_loy'])){
    $log=$post['login'];
    $rep= User::registration($post['login'], $post['nm'], $post['sn'],
            $post['pass'], $post['reppass'], $post['tel'], '');
    if($rep==='norepeat'){
        $_SESSION['login']= Dbq::AtomSel('login', 'users', 'us_hash', $_SESSION['ush']);
        $_SESSION['usid']=Dbq::AtomSel('id', 'users', 'us_hash', $_SESSION['ush']);
        $rq="UPDATE users SET `rol`='loy' WHERE `login`='$log'";
        Dbq::InsDb($rq);
        $us_id= Dbq::AtomSel('id', 'users', 'login', $log);
        $iq="INSERT INTO loy (`radio_id`,`us_id`) VALUES ($id,$us_id)";
        Dbq::InsDb($iq);
        $mes='Вы зарегистрированы на сайте NRS-MEDIA.ru в качестве юриста,'
                . 'ваш логин '.$post['login'].',  пароль '.$post['pass'];
        $htmlBody='Вы зарегистрированы на сайте NRS-MEDIA.ru в качестве юриста,'
                . 'ваш логин '.$post['login'].',  пароль '.$post['pass'];
        $subj='Регистрация на lanseal.ru';
        Secure::mailYand($post['login'], $mes, $htmlBody, $post['nm'], $subj);
    }
    header('Location: /cabinet/r_mancab/2');
}

if(isset($_POST['pay'])){//подтверждение оплаты
    $bid=$post['pay'];
    $pq="UPDATE bid SET `status`='payd' WHERE `id`=$bid";
    Dbq::InsDb($pq);
    echo 'Оплата подтверждена';
    exit();
}

if(isset($_POST['compl'])){//выход заявки в эфир
    $bid=$post['compl'];
    $pq="UPDATE bid SET `status`='compl' WHERE `id`=$bid";
    Dbq::InsDb($pq);
    echo 'вышла в эфир';
    exit();
}
if(isset($_POST['retime'])){//перенос заявки в другой промежуток
    $bid_id=$post['fr_bid'];
    $to_timest=$post['to_day']+$post['to_time'];
    $rid=Dbq::AtomSel('rekl_id', 'bid', 'id', $bid_id);
    $us_id= Dbq::AtomSel('us_id', 'rekl', 'id', $rid);
    $mails=Dbq::AtomSel('login', 'users', 'id', $usid);
    $fr_t= Dbq::AtomSel('b_time', 'bid', 'id', $bid_id);
    $mes="Ваша заявка перемещена с ". date('Hч d.m',$fr_t). 'на '. 
            date('H ч, d.m',$to_timest).', для согласования перейдите в личный '
            . 'кабинет на сайте ';
    $htmlBody="<p>Ваша заявка №$bid_id перемещена с ". date('Hч d.m',$fr_t). 'на '. 
            date('H ч, d.m',$to_timest).', '
            . '<a href="http://NRS-MEDIA.ru/signup/inplan/plan_'.$id.'">'
            . 'для согласования перейдите в личный </a>'
            . 'кабинет на сайте </p>';
    $name= Dbq::AtomSel('fio', 'rekl', 'id', $rid);
    $subj='Заявка на сайте';
    Secure::mailYand($mails, $mes, $htmlBody, $name, $subj);
    $retq="UPDATE bid SET `b_time`='$to_timest',`status`='red' WHERE `id`=$bid_id";
    Dbq::InsDb($retq);
    header('Location: /cabinet/r_mancab/3');
}

if(isset($_POST['media'])){//принять / отклонить заявку
    unset($post['media']);
    foreach ($post as $medk=>$media){
        $expl=explode('_', $medk);
        if($expl[0]==='bidstat'){
            $bid_id=$expl[1];
            if($media==='accept'){
                $rolik_id= Dbq::AtomSel('rolik_id', 'bid', 'id', $bid_id);
                $rolik_s= Dbq::AtomSel('status', 'rolik', 'id', $rolik_id);
                $rolstarr= unserialize($rolik_s);
                if(array_key_exists('app', $rolstarr) && in_array($id , $rolstarr['app'])){
                    $stat='man_ap';
                    
                }
                elseif (!array_key_exists('app', $rolstarr) || !in_array($id, $rolstarr['app'])) {
                    $stat='cl_app';
                }
            }
            if($media==='reject'){
                $stat='cans';
                $rekl_id= Dbq::AtomSel('rekl_id', 'bid', 'id', $bid_id);
                $rus_id= Dbq::AtomSel('us_id', 'rekl','id' , $rekl_id);
                $mails= Dbq::AtomSel('login', 'users', 'id', $rus_id);
                $radio_nm= $r_maninf[0]['st_nm'];
                $name=Dbq::AtomSel('fio', 'rekl','id' , $id);
                $mes="Ваша заявка на радио $radio_nm отклонена, для изменения"
                        . "времени заявки "
                        . '<a href="http://NRS-MEDIA.ru/signup/inplan/plan_'.$id.'" >'
                        . "зайдите в личный кабинет</a>"; 
                $htmlBody="<p>Ваша заявка на радио $radio_nm отклонена, для изменения"
                        . " времени заявки зайдите в личный кабинет</p>";
                $subj='Заявка на радио';
                //echo 'mails'.$mails;
                Secure::mailYand($mails, $mes, $htmlBody, $name, $subj);
            }
            $medq="UPDATE bid SET `status`='$stat' WHERE `id`=$bid_id";
            Dbq::InsDb($medq);
        }
    }
    header('Location: /cabinet/r_mancab/3');
}

if(isset($_POST['pic_tab'])){//обновление пиков
    unset($post['pic_tab']);
    foreach ($post as $pk=>$pv){//$pv-aud_rech
        $kar= explode('_', $pk);
        $pos_id=$kar[1];
        foreach ($r_str as $sk=>$sinf){
            if($sinf['id']===$pos_id && $sinf['aud_reach']!=$pv){
                $sq="SELECT `week_d`,`time_p`,`price`,`t_ins` FROM struct "
                        . "WHERE `id`='$pos_id'";
                $sel_arr= Dbq::SelDb($sq)[0];
                $t= time();
                $week_d=$sel_arr['week_d'];
                $time_p=$sel_arr['time_p'];
                $price= $sel_arr['price'];
               // $met_int=$sel_arr['met_int'];
                //$t_ins=$sel_arr['t_ins'];
                
                $uq="UPDATE struct SET `pr_status`='arh',`t_end`='$t' "
                        . "WHERE `id`='$pos_id'";
                    Dbq::InsDb($uq);
                //echo $uq;
                
                $iq="INSERT INTO struct (`week_d`,`time_p`,`price`,`aud_reach`,"
                        . "`id_radio`,`pr_status`,`t_ins`,`t_begin`,`pos_fil`)"
                        . "VALUES ('$week_d','$time_p','$price','$pv','$id',"
                        . "'cur','$t','$t',0)";
                //echo $iq;
                Dbq::InsDb($iq);                    
            }
        }
    }
    header('Location: /cabinet/r_mancab/5');
}

if(isset($_POST['pr_tab'])){//обновление цен
    unset($post['pr_tab']);
    foreach ($post as $pk=>$pv){//$pv-price
        $kar= explode('_', $pk);
        $pos_id=$kar[1];
        foreach ($r_str as $sk=>$sinf){
            if($sinf['id']===$pos_id && $sinf['price']!=$pv){
                $sq="SELECT `week_d`,`time_p`,`aud_reach`,`t_ins` FROM struct "
                        . "WHERE `id`='$pos_id'";
                $sel_arr= Dbq::SelDb($sq)[0];
                $t= time();
                $week_d=$sel_arr['week_d'];
                $time_p=$sel_arr['time_p'];
                $aud_reach= $sel_arr['aud_reach'];
               // $met_int=$sel_arr['met_int'];
                //$t_ins=$sel_arr['t_ins'];
                
                $uq="UPDATE struct SET `pr_status`='arh',`t_end`='$t' "
                        . "WHERE `id`='$pos_id'";
                    Dbq::InsDb($uq);
                //echo $uq;
                
                $iq="INSERT INTO struct (`week_d`,`time_p`,`price`,`aud_reach`,"
                        . "`id_radio`,`pr_status`,`t_ins`,`t_begin`,`pos_fil`)"
                        . "VALUES ('$week_d','$time_p','$pv','$aud_reach','$id',"
                        . "'cur','$t','$t',0)";
                //echo $iq;
                Dbq::InsDb($iq);                    
            }
        }
    }
    header('Location: /cabinet/r_mancab/6');
}

if(isset($_POST['profile_ch'])&&($_POST['profile_ch']===$id)){//обновление профиля
    $name=$post['name'];
    $tel=$post['tel'];
   // $adress=$post['adress'];
    $usq="UPDATE users SET `name`='$name',`tel`='$tel' "
            . "WHERE `id`='$usid'";
    Dbq::InsDb($usq);
    
        
    $position=  $post['position'];
    $region=    $post['region'];
    $city=      $post['city'];
    $adrs=      $post['adrs'];
    $po_version=$post['po'].'%'.$post['po_ver'];
    $trafik_mail=$post['trafik_mail'];
    if(!empty($post['nds'])){
        $nds=       $post['nds'];
    } else {
    $nds=    'no';
    }
    
    if(!empty($_FILES['logo']['tmp_name'])){
        move_uploaded_file($_FILES['logo']['tmp_name'], ROOT.'/logo/logo'.$id.'.jpeg');
    }
    if(!empty($_FILES['oferta']['tmp_name'])){
        if(move_uploaded_file($_FILES['oferta']['tmp_name'], ROOT.'/doc/oferta'.$id.'.pdf')){
}}
    $links=$post['links'];
    $zone=$post['zone'];
    $site=$post['site'];
    $aud_desc=$post['aud_desc'];
    $oxv_aud=$post['oxv_aud'];
    $fio= $post['fio'];
    $dog_nm=$post['dog_nm'];
    $rmq="UPDATE sation SET `position`='$position',`region`='$region',"
            . "`city`='$city',`adrs`='$adrs',`links`='$links',`zone`='$zone',`site`='$site',"
            . "`aud_desc`='$aud_desc',`oxv_aud`='$oxv_aud',`po_version`='$po_version',"
            . "`trafik_mail`='$trafik_mail',`nds`='$nds',`fio`='$fio',`dog_nm`='$dog_nm' WHERE `id`='$id'";
    Dbq::InsDb($rmq);
    header('Location: /cabinet/r_mancab/7');
}
if(isset($_POST['rekv_ch'])){
    $rekv['kpp'] = $post['kpp'];
    $rekv['fname']=$post['fname'];
    $rekv['ogrn']= $post['ogrn'];
    $rekv['jradr']=$post['jradr'];
    $rekv['inn']=  $post['inn'];
    $rekv['rs']=   $post['rs'];
    $rekv['ks']=   $post['ks'];
    $rekv['bik']=  $post['bik'];
    $rekv['bank']= $post['bank'];
    $reks= serialize($rekv);
    $rekqq="UPDATE sation SET `rekv`='$reks' WHERE `id`='$id'";
    Dbq::InsDb($rekqq);
    header('Location: /cabinet/r_mancab/4');
}

//if(isset($_POST['ofer'])){
//    $dog_nm=$post['dog_nm'];
//    $dnmq="UPDATE sation SET `dog_nm`='$dog_nm' WHERE `id`=$id";
//    Dbq::InsDb($dnmq);
//    if(!empty($_FILES['oferta']['tmp_name'])){
//        if(move_uploaded_file($_FILES['oferta']['tmp_name'], ROOT.'/doc/oferta'.$id.'.pdf')){
//}}header('Location: /cabinet/r_mancab/7');}
header('Location: /cabinet/r_mancab/3');
