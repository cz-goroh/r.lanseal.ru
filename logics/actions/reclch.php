<?php
//print_r($_POST);
if(isset($_POST['settings'])){
    $ist=$post['ist'];
    $bol=$post['bol'];
    $sersett= Dbq::AtomSel('sett', 'rekl', 'id', $id);
    $set= unserialize($sersett);
    $set['ist']=$ist;
    $set['bol']=$bol;
    $sersett= serialize($set);
    $upsq="UPDATE rekl SET `sett`='$sersett' WHERE `id`=$id";
    Dbq::InsDb($upsq);
    header('Location: /cabinet/clientrcab/7');
}

if(isset($_POST['zaj_stek'])){
    unset($post['zaj_stek']);
    $rad_stack_arr=$post;
    $_SESSION['rad_stack_arr']=$rad_stack_arr;
    header('Location: /cabinet/clientrcab/planstack');
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

if(isset($_POST['plat'])){
    $id_sh=$post['plat'];
    $d_way=ROOT.'/doc/plat_'.$id_sh.'.pdf';
    $tmp_nm='plat_'.$id_sh;
  
    move_uploaded_file($_FILES["$tmp_nm"]['tmp_name'], $d_way);
//    var_dump($mv);
//    print_r($_FILES);
    header('Location: /cabinet/clientrcab/1');
}

if(isset($_POST['count'])){
    print_r($post);
    exit();
}
if(isset($_POST['pay_upl'])){
    $id_bid=$post['paydoc'];
    $d_way=ROOT.'/doc/pay_'.$id_bid.'.pdf';
    move_uploaded_file($_FILES['pay_file']['tmp_name'], $d_way);
    header('Location: /cabinet/clientrcab/1');
}
if(isset($_POST['itxt'])){
    $id_txt=$post['itxt'];
    $txt=$post['n_txt'];
    $txq="UPDATE rolik SET `txt`='$txt' WHERE `id`=$id_txt";
    Dbq::InsDb($txq);
    exit();
}

if(isset($_POST['del_bid'])){
    $bid_id=$post['del_bid'];
    $delq="UPDATE bid SET `status`='del' WHERE `id`=$bid_id";
    Dbq::InsDb($delq);
    echo 'Отменена';
    exit();
}

if(isset($_POST['accept_bid'])){
    $bid_id=$post['accept_bid'];
    $id_rol= Dbq::AtomSel('rolik_id', 'bid', 'id', $bid_id);
    $rol_sts= Dbq::AtomSel('status', 'rolik', 'id', $id_rol);
    $id_radio= Dbq::AtomSel('radio_id', 'bid','id', $bid_id);
    $rol_st= unserialize($rol_sts);
    
    if(array_key_exists('app',$rol_st)&& in_array($id_radio, $rol_st['app'])){
        $n_st='man_ap';
        
    } else {
        $n_st='cl_app';
        
    }
    $delq="UPDATE bid SET `status`='$n_st' WHERE `id`=$bid_id";
    Dbq::InsDb($delq);
    echo 'Принята';
    exit();
}

if(isset($_POST['del_rol'])){
    $rol_id=$post['del_rol'];
    $delq="DELETE FROM rolik WHERE `id`=$rol_id";
    Dbq::InsDb($delq);
    if(file_exists(ROOT.'/audio/rolik_'.$rol_id.'.mp3')){
    unlink(ROOT.'/audio/rolik_'.$rol_id.'.mp3');
    }
    header('Location: /cabinet/clientrcab/2');
}
if(isset($_POST['rolik_upl'])){
    $name=$post['rolik_nm'];
    $t= time();
    $size=$_FILES['rolik']['size'];
    $txt=$post['ntxt'];
    $stat_arr=['upl'=>1];
    $stat_ser= serialize($stat_arr);
    $descar=array();
    $descr= serialize($descar);
    $rolq="INSERT INTO rolik "
            . "(`name`,`t_ins`,`size`,`rekl_id`,`status`,`descr`,`txt`) "
            . "VALUES ('$name',$t,$size,$id,'$stat_ser','$descr','$txt')";
    Dbq::InsDb($rolq);
    $lastq="SELECT HIGH_PRIORITY max(id) FROM `rolik`";
    $rolik_id= Dbq::SelDb($lastq)[0]["max(id)"];// id текущей позиции
    $way=ROOT.'/audio/rolik'.'_'.$rolik_id.'.mp3';
    $m=move_uploaded_file($_FILES['rolik']['tmp_name'], $way);
    error_reporting (E_ERROR);
    $info = getMP3data($way);
        ini_set('display_errors',1);
        error_reporting(E_ALL);
    $dlit=$info['diration'];
    $updlq="UPDATE rolik SET `dlit`=$dlit WHERE `id`=$rolik_id";
    Dbq::InsDb($updlq);
//    echo $rolq;
//    print_r($post);
////    var_dump($_FILES);
//    print_r($_FILES);
    header('Location: /cabinet/clientrcab/2');
}
if(isset($_POST['rolik_upd'])){//обновление ролика
    $upl= explode('_', $post['rolik_upd']);
    $rolik_id=$upl[0];
    $for_radio=$upl[1];
    $chk_stat= Dbq::AtomSel('status', 'rolik', 'id', $rolik_id);
    $stat_arr= unserialize($chk_stat);
    error_reporting (E_ERROR);
    $info = getMP3data($_FILES['rolik']['tmp_name']);
        ini_set('display_errors',1);
        error_reporting(E_ALL);
    $dlit=$info['diration'];
    
 if(!array_key_exists('app', $stat_arr)){//если ролик не одобрен ещё ни одной станцией
        $stat_arr=['red'=>$for_radio];
        $stat_ser= serialize($stat_arr);
//        print_r($_FILES);
        $upq="UPDATE rolik SET `status`='$stat_ser',`dlit`='$dlit' WHERE `id`=$rolik_id";
        Dbq::InsDb($upq);
        $way=ROOT.'/audio/rolik'.'_'.$rolik_id.'.mp3';
        unlink($way);
        move_uploaded_file($_FILES['rolik']['tmp_name'], $way);
        
} elseif(array_key_exists('app', $stat_arr)) {//если какие-то станции уже одобрили ролик
        $stat_arr=['red'=>$for_radio];
        $oldstatser= Dbq::AtomSel('status', 'rolik', 'id', $rolik_id);
        $oldstat= unserialize($oldstatser);
        
        $rejk=array_keys($oldstat['rej'], $id)[0];
        unset($oldstat['rej'][$rejk]);
        $oldstatser= serialize($oldstat);
        
        $upq="UPDATE rolik SET `status`='$oldstatser' WHERE `id`=$rolik_id";
        Dbq::InsDb($upq);
        $name= Dbq::AtomSel('name', 'rolik', 'id', $rolik_id);
        $t= time();
        $size=$_FILES['rolik']['size'];
        $stat_ser= serialize($stat_arr);
        $txt=$post['redtxt'];
        $rolq="INSERT INTO rolik "
            . "(`name`,`t_ins`,`size`,`rekl_id`,`status`,`txt`,`dlit`) "
            . "VALUES ('$name',$t,$size,$id,'$stat_ser','$txt','$dlit')";
        Dbq::InsDb($rolq);
        
        $lastq="SELECT HIGH_PRIORITY max(id) FROM `rolik`";
        $nrolik_id= Dbq::SelDb($lastq)[0]["max(id)"];// id текущей позиции
        $way=ROOT.'/audio/rolik'.'_'.$nrolik_id.'.mp3';
        $m=move_uploaded_file($_FILES['rolik']['tmp_name'], $way);
        
        $updrolbidq="UPDATE bid SET `rolik_id`=$nrolik_id "
        . "WHERE `rolik_id`=$rolik_id AND `rekl_id`=$id AND "
        . "(`status`='rec' OR `status`='red' OR `status`='cl_app')";
        Dbq::InsDb($updrolbidq);
}
    
    
    header('Location: /cabinet/clientrcab/2');
}

if(isset($_POST['bid'])){
//    print_r($post);
    $header_w=$post['bid'];
    unset($post['bid']);
    $t= time();
    foreach ($post as $ts_k=>$price){
        $tsarr= explode('_', $ts_k);
        if($tsarr[0]==='ts'){
            $ts=$tsarr[1];//timestamp
            $rolik_key='rol_'.$ts;//ключ элемента с роликом
            $bid_k_i=$post["$ts_k"];
            $bid_k_e= explode('_', $bid_k_i);
            $bid_k=$tsarr[2];
            $radio_id= $tsarr[3];
            $rolik_id=$post["$rolik_key"]; 
            $dlit= Dbq::AtomSel('dlit', 'rolik', 'id', $rolik_id);
//            $pr= Dbq::AtomSel('price', 'struct', 'id', $bid_k);
            $price=($price/30)*$dlit;
            $price= round($price,2);
            $_SESSION['snt']='Ваша заявка успешно отправлена менеджеру радиостанции, '
                    . 'для отслеживания статуса откройте соответствующий медиаплан';
        $bidaq="INSERT INTO bid ("
    ."`radio_id`,`rekl_id`,`struct_id`,`ins_time`,`b_time`,`status`,`rolik_id`,"
                . "`sum`) VALUES ('$radio_id','$id','$bid_k',$t,$ts,'rec',"
                . "$rolik_id,$price)";
        Dbq::InsDb($bidaq);
        }
    }
    if($header_w==='planstack'){
        array_shift($_SESSION['rad_stack_arr']);
        header('Location: /cabinet/clientrcab/planstack');
    }else{
//        echo $bidaq;
        header('Location: /cabinet/clientrcab/3');
    }
}
if(isset($_POST['profile_ch'])&&($_POST['profile_ch']===$id)){
    $name=$post['name'];
    $tel=$post['tel'];
    
    $usq="UPDATE users SET `name`='$name',`tel`='$tel'"
            . "WHERE `id`='$usid'";
    Dbq::InsDb($usq);
    $position=  $post['position'];
    $region=    $post['region'];
    $city=      $post['city'];
    $adrs=      $post['adrs'];
    $fio=       $post['fio'];
    if(!empty($post['nds'])){
        $nds=       $post['nds'];
    } else {
    $nds=    'no';
    }
    $rmq="UPDATE rekl SET `position`='$position',`region`='$region',"
            . "`city`='$city',`adrs`='$adrs',`nds`='$nds',`fio`='$fio'"
            . " WHERE `id`='$id'";
//    echo $rmq;
    Dbq::InsDb($rmq);
    header('Location: /cabinet/clientrcab/4');
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
    $rekq="UPDATE rekl SET `rekv`='$reks' WHERE `id`='$id'";
    Dbq::InsDb($rekq);
    header('Location: /cabinet/clientrcab/5');
}
//`rekv`='$reks',
//header('Location: /cabinet/clientrcab');
