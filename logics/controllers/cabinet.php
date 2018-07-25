<?php
if(!empty($_SESSION['ush'])){
    $ush=Dbq::AtomSel('us_hash', 'users', 'id' , $_SESSION['usid']);
    //echo $ush;
    $usid=$_SESSION['usid'];//id из users
    $id=$_SESSION['id'];//id 
    //echo $id;
    //echo $usid;
    if($_SESSION['ush']===$ush){
        $user_infq="SELECT * FROM users WHERE `id`='$usid'";
        $user_inf= Dbq::SelDb($user_infq);
        $t_week1=
[
    1=>strtotime('monday this week')       ,
    2=>strtotime('monday this week')+86400 ,
    3=>strtotime('monday this week')+172800,
    4=>strtotime('monday this week')+259200,
    5=>strtotime('monday this week')+345600,
    6=>strtotime('monday this week')+432000,
    7=>strtotime('monday this week')+518400
];
$t_week2=
[
    1=>strtotime('monday this week')+604800 ,
    2=>strtotime('monday this week')+691200 ,
    3=>strtotime('monday this week')+777600 ,
    4=>strtotime('monday this week')+864000 ,
    5=>strtotime('monday this week')+950400 ,
    6=>strtotime('monday this week')+1036800,
    7=>strtotime('monday this week')+1123200
];
$rus_week=[1=>'Пн',2=>'Вт',3=>'Ср',4=>'Чт',5=>'Пт',6=>'Сб',7=>'Вс'];
$ths_mond=strtotime('monday this week');
$t_month=
[
//    1=>$ths_mond       ,
//    2=>$ths_mond+86400 ,
//    3=>$ths_mond+172800,
//    4=>$ths_mond+259200,
//    5=>$ths_mond+345600,
//    6=>$ths_mond+432000,
//    7=>$ths_mond+518400,
    1=>$ths_mond+604800,
    2=>$ths_mond+691200,
    3=>$ths_mond+777600,
    4=>$ths_mond+864000,
    5=>$ths_mond+950400,
    6=>$ths_mond+1036800,
    7=>$ths_mond+1123200,
    8=>$ths_mond+1209600,
    9=>$ths_mond+1296000,
    10=>$ths_mond+1382400,
    11=>$ths_mond+1468800,
    12=>$ths_mond+1555200,
    13=>$ths_mond+1641600,
    14=>$ths_mond+1728000,
    15=>$ths_mond+1814400,
    16=>$ths_mond+1900800,
    17=>$ths_mond+1987200,
    18=>$ths_mond+2073600,
    19=>$ths_mond+2160000,
    20=>$ths_mond+2246400,
    21=>$ths_mond+2332800,
    22=>$ths_mond+2419200,
    23=>$ths_mond+2505600,
    24=>$ths_mond+2592000,
    25=>$ths_mond+2678400,
    26=>$ths_mond+2764800,
    27=>$ths_mond+2851200,
    28=>$ths_mond+2937600,
    29=>$ths_mond+3024000,
    30=>$ths_mond+3110400,
    31=>$ths_mond+3196800
];
$t_hours=[1 =>21600,2 =>25200,3 =>28800,4 =>32400,5 =>36000,6 =>39600,7 =>43200,
8 =>46800,9 =>50400,10=>54000,11=>57600,12=>61200,13=>64800,14=>48400,15=>72000,
16=>75600,17=>79200,18=>82800,19=>0,20=>3600,21=>7200,22=>10800,23=>14400,
    24=>18000    ];
$t= time();
//print_r($_POST);
$post= Secure::PostText($_POST);
//require ROOT.'/components/class.mp3.php';
include(ROOT.'/components/getMP3info.php');
//Array ( [filename] => /var/www/html/audio/rolik_26.mp3 [id3v1] => Array ( [tag] => TAG [name] => Arabika [artists] => ������ [album] => zv.fm [year] => 2002 [comment] => zv.fm [track] => 1 [genreno] => -1 ) [id3v2] => Array ( [version] => 3.0 [size] => 51459 ) [id] => MPEG-1 [layer] => 3 [bitrate] => 320 [frequency] => 44100 [padding] => 0 [mode] => Joint stereo [Intensity stereo] => 1 [MS stereo] => 0 [Copyrighted] => 0 [Original] => 1 [Emphasis] => None [bitrate_mode] => CBR [duration_str] => 05:35 [duration_str_hour] => 00:05:35 [diration] => 335 );
//===========================администратор======================================
if($_SESSION['rol']==='adm'){
        
    $r_strq="SELECT * FROM struct WHERE `pr_status`='cur'";
        $r_str= Dbq::SelDb($r_strq);              // массив из таблицы структуры
        foreach ($r_str as $r){
            $wday=$r['week_d'];
            $tm_per=$r['time_p'];
            $timekey=$wday.'%'.$tm_per;
            $ar_str["$timekey"]=$r;
        }
    $bidq="SELECT * FROM bid ";
        $bidar= Dbq::SelDb($bidq);//заявки
        
        $allbidq="SELECT * FROM bid WHERE `status`!='compl' AND `status`!='cans'";
        $allbid=Dbq::SelDb($allbidq);
        
        $d_arr= include ROOT.'/config/t_arr.php';//временные позиции
        $w_arr=[1,2,3,4,5,6,7];                  //дни недели
        
        $loyq="SELECT * FROM loy ";
        $loyar= Dbq::SelDb($loyq);
        
        $shq="SELECT * FROM shcet ";
        $shcarr= Dbq::SelDb($shq);
        
        $satusq="SELECT * FROM users";
        $suar= Dbq::SelDb($satusq);
        
        $alrolq="SELECT * FROM rolik";
        $alrol= Dbq::SelDb($alrolq);
        foreach ($alrol as $rolk=>$alrolinf){
            $iddlit=$alrolinf['id'];
            $rol_dlit[$iddlit]=$alrolinf['dlit'];//       idролика=>длительность
        }
        
        $r_maninfq="SELECT * FROM sation";
        $r_maninf= Dbq::SelDb($r_maninfq);// массив станций
        
        
        foreach ($r_maninf as $sationinf){
            $sation_id=$sationinf['id'];
            $sat_inf[$sation_id]=$sationinf;
        }
        $reklq="SELECT * FROM rekl ";
        $rekl_inf= Dbq::SelDb($reklq);//
        
        $rolikq="SELECT * FROM rolik ";
        $rolar= Dbq::SelDb($rolikq);//массив роликов
        foreach ($rolar as $rol_key=>$rol_inf){
            $rolid=$rol_inf['id'];
            $rolsort[$rolid]=$rol_inf['dlit'];
        }
        if(isset($_POST['admsearch'])){
            foreach ($r_maninf as $serch_r){
                $ser_r_rek=$serch_r['rekv'];
                $r_rek= unserialize($ser_r_rek);
                if($r_rek['inn']===$post['inns']){
                    $search_r[]=$serch_r;
                }
            }
            foreach ($rekl_inf as $serch_c){
                $ser_c_rek=$serch_c['rekv'];
                $c_rek= unserialize($ser_c_rek);
                if($c_rek['inn']===$post['inns']){
                    $search_c[]=$serch_c;
                }
            }
        }
}    
//======================менеджер радио==========================================
if($_SESSION['rol']==='r_man'){
            
        $r_maninfq="SELECT * FROM sation WHERE `id`='$id'";
        $r_maninf= Dbq::SelDb($r_maninfq);
                
        $r_strq="SELECT * FROM struct WHERE "
                . "`id_radio`='$id' AND `pr_status`='cur'";
        $r_str= Dbq::SelDb($r_strq);              // массив из таблицы структуры
        foreach ($r_str as $r){
            $wday=$r['week_d'];
            $tm_per=$r['time_p'];
            $timekey=$wday.'%'.$tm_per;
            $ar_str["$timekey"]=$r;
        }
//        print_r($ar_str);
        
        $bidq="SELECT * FROM bid WHERE `radio_id`=$id";
        $bidar= Dbq::SelDb($bidq);//заявки
        
        $allbidq="SELECT * FROM bid WHERE `status`!='compl' AND `status`!='cans'";
        $allbid=Dbq::SelDb($allbidq);
        
        $d_arr= include ROOT.'/config/t_arr.php';//временные позиции
        $w_arr=[1,2,3,4,5,6,7];                  //дни недели
        
        $loyq="SELECT * FROM loy WHERE `radio_id`=$id";
        $loyar= Dbq::SelDb($loyq);
        
        $shq="SELECT * FROM shcet WHERE `radio_id`=$id";
        $shcarr= Dbq::SelDb($shq);
        $tw= time()-518400;
        $bidatq="SELECT * FROM bid WHERE `radio_id`=$id AND `status`='rec' "
                . "AND `ins_time` > $tw";
        $bidatar= Dbq::SelDb($bidq);//заявки
        
        $reklq="SELECT * FROM rekl";
        $rekl_inf= Dbq::SelDb($reklq);//
        
        $rolq="SELECT * FROM rolik";
            $rolar= Dbq::SelDb($rolq);
            //print_r($rolar);
            $rid_arr=array();
            foreach ($bidar as $bk=>$binfl){
                $bid_id=$binfl['rolik_id'];
                $rid_arr[$bid_id]=$binfl['rolik_id'];//массив номеров роликов
            }
            foreach ($rolar as $rk=>$rinf){
                if(in_array($rinf['id'], $rid_arr)){
                    $rol_id=$rinf['id'];
                    $rarr[$rol_id]=$rinf;//массив с информацией о роликах
                }
            }
    }
    
//======================рекламодатель===========================================
        //echo $id;
    if($_SESSION['rol']==='client'){
        if(!empty($_POST['plan_sl'])){
            $plan_sl=$post['plan_sl'];
            $plan_per=$post['plan_per'];
            $begin_per=$post['begin_per'];
            $end_per=$post['end_per'];
            unset($post['plan_sl']);
            unset($post['plan_per']);
            unset($_POST['plan_sl']);
            unset($_POST['plan_per']);
        }
        if(!empty($post['snd_per'])){
            $snd_per=$post['snd_per'];
            $begin_per=$post['begin_per']-1;
            $end_per=$post['end_per']-1;
            unset($_POST['snd_per']);
            unset($_POST['begin_per']);
            unset($_POST['end_per']);
            unset($post['snd_per']);
            unset($post['begin_per']);
            unset($post['end_per']);
        }
        $satusq="SELECT * FROM users WHERE `rol`='r_man'";
        $suar= Dbq::SelDb($satusq);
        foreach ($suar as $satusar){
            $satus_id=$satusar['id'];
            $satuser[$satus_id]=$satusar;
        }
        $shq="SELECT * FROM shcet WHERE `rekl_id`=$id";
        $sh_ar= Dbq::SelDb($shq);
        
        $alrolq="SELECT `id`,`dlit` FROM rolik";
        $alrol= Dbq::SelDb($alrolq);
        foreach ($alrol as $rolk=>$alrolinf){
            $iddlit=$alrolinf['id'];
            $rol_dlit[$iddlit]=$alrolinf['dlit'];//       idролика=>длительность
        }
        
        $reklq="SELECT * FROM rekl WHERE `id`='$id'";
        $rekl_inf= Dbq::SelDb($reklq);//
        if(!empty($rekl_inf[0]['sett'])){//настройки
            $setser=$rekl_inf[0]['sett'];
            $settings= unserialize($setser);
            if($settings['ist']!='yes'){
                $t_month= array_slice($t_month, 7);
            }
        }
        if($_SERVER['HTTP_HOST']==='r.lanseal.ru'){
        
        if(isset($_POST['tags'])){                              //поиск по тегам
            $p= Secure::PostText($_POST)['tag'];
            $r_maninfq="SELECT * FROM sation WHERE `aud_desc` LIKE '%$p%' "
                    . "OR `zone` LIKE '%$p%' OR `region` LIKE '%$p%' "
                    . "OR `city` LIKE '%$p%'";
            $r_maninf= Dbq::SelDb($r_maninfq);
        }else{
        $r_maninfq="SELECT * FROM sation";
        $r_maninf= Dbq::SelDb($r_maninfq);// массив станций
        }
        } else {
            if(isset($_POST['tags'])){                              //поиск по тегам
            $p= Secure::PostText($_POST)['tag'];
            $r_maninfq="SELECT * FROM sation WHERE (`aud_desc` LIKE '%$p%' "
                    . "OR `zone` LIKE '%$p%' OR `region` LIKE '%$p%' "
                    . "OR `city` LIKE '%$p%') AND (`status`!='test' AND `status`!='del')";
            $r_maninf= Dbq::SelDb($r_maninfq);
        }else{
        $r_maninfq="SELECT * FROM sation WHERE `status`!='test' AND `status`!='del'";
        $r_maninf= Dbq::SelDb($r_maninfq);// массив станций
        }
//            `status`!='test' AND `status`!='del'
        }
        foreach ($r_maninf as $sationinf){
            if($arg!='plan'){
            $sation_id=$sationinf['id'];
            $sat_inf[$sation_id]=$sationinf;
        }
//        elseif ($arg==='plan'&& !empty ($_POST['zaj_stek'])) {  //первый вариант планирования нескольких станций
//            unset($post['zaj_stek']);
//            
//                    if(in_array($sationinf['id'], $post)){
//                        $sation_id=$sationinf['id'];
//                        $sat_inf[$sation_id]=$sationinf;
//                    }
//        }
        }
        
        $rolikq="SELECT * FROM rolik WHERE `rekl_id`=$id";
        $rolar= Dbq::SelDb($rolikq);//массив роликов
        foreach ($rolar as $rol_key=>$rol_inf){
            $rolid=$rol_inf['id'];
            $rolsort[$rolid]=$rol_inf['dlit'];
        }
        
        $bidq="SELECT * FROM bid WHERE `rekl_id`=$id";
        $bidar= Dbq::SelDb($bidq);//заявки
        $attent_bid=array();
        foreach ($bidar as $sortbidinf){
            $sortb_id=$sortbidinf['id'];
            $sbid_ts=$sortbidinf['b_time'];
            $sbidar[$sbid_ts][$sortb_id]=$sortbidinf;
            $mb_key=$sortbidinf['radio_id'];
            $my_bidarr[$mb_key][$sortb_id]=$sortbidinf;
//            
            if($sortbidinf['status']==='red' || $sortbidinf['status']==='cans'){
                $attent_bid[$mb_key]=$sortbidinf['id'];
            }
            if($sortbidinf['status']==='man_ap' && empty($sortbidinf['sh_num'])){
                $shind_reklid=$sortbidinf['rekl_id'];
                $sh_ind[$shind_reklid][$mb_key]=1;
            }
        }
//        print_r($attent_bid);
        
        $allbidq="SELECT * FROM bid WHERE `status`!='compl' "
                . "AND `status`!='cans' AND `b_time`>$t";
        $allbid=Dbq::SelDb($allbidq);
        foreach ($allbid as $allbid_k=>$allbinf){
            $allb_idrol=$allbinf['rolik_id'];
            $allb_id=$allbinf['id'];
            $allb_radioid=$allbinf['radio_id'];//id радио текущей заявки
            $bidts=$allbinf['b_time'];// структурная поз. текущей заявки
            $dlitarr[$allb_radioid][$bidts][$allb_id]=$rol_dlit[$allb_idrol];
            //$dlit_ab[]=$allbinf;
            
        }
        
        $shq="SELECT * FROM shcet WHERE `rekl_id`=$id";
        $shcarr= Dbq::SelDb($shq);
        
        foreach ($r_maninf as $rmk=>$rmi){
            if(array_key_exists($rmi['id'], $sat_inf)){
            $ids=$rmi['id'];
            $r_strq="SELECT * FROM struct WHERE"
                    . " `id_radio`='$ids' AND `pr_status`='cur'";
            $r_str["$ids"]= Dbq::SelDb($r_strq);  // массив из таблицы структуры
            }
        }
        
        $d_arr= include ROOT.'/config/t_arr.php';//временные позиции
        $w_arr=[1,2,3,4,5,6,7];                  //дни недели
    }
//============================ЮРИСТ=============================================
        
        if($_SESSION['rol']==='loy'){
            
            $usselq="SELECT * FROM users WHERE `id`='$usid'";
            $us_inf= Dbq::SelDb($usselq)[0];
            
            $loyq="SELECT * FROM loy WHERE `id`=$id";
            $loyar= Dbq::SelDb($loyq)[0];
            
            $st_id=$loyar['radio_id'];
            $t= time();
            $bidq="SELECT * FROM bid WHERE `radio_id`=$st_id ";//AND `b_time`>$t";
            $bidar= Dbq::SelDb($bidq);
            //print_r($bidar);
            $rolq="SELECT * FROM rolik";
            $rolar= Dbq::SelDb($rolq);
            //print_r($rolar);
            $rid_arr=array();
            foreach ($bidar as $bk=>$binf){
                $bid_id=$binf['rolik_id'];
                $rid_arr[$bid_id]=$binf['rolik_id'];//массив номеров роликов
            }
            foreach ($rolar as $rk=>$rinf){
                if(in_array($rinf['id'], $rid_arr)){
                    $rol_id=$rinf['id'];
                    $rarr[$rol_id]=$rinf;//массив с информацией о роликах
                }
            }
           //print_r($rarr);
        }
    } else {
//        $uri=trim($_SERVER['REQUEST_URI'],'/');
//        $uri= str_replace('/', '_', $uri);
//        echo $uri;
//        header('Location: /signup/inplan/'.$uri);
        header('Location: /');
    }
} else {
//    $uri=trim($_SERVER['REQUEST_URI'],'/');
//    $uri= str_replace('/', '_', $uri);
//    echo $uri;
//    header('Location: /signup/inplan/'.$uri);
    header('Location: /');
}