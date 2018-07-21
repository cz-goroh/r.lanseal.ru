<?php
if(empty($arg)){
    include_once ROOT.'/views/cabinet/admcabv.php';
} else {
    $exarg= explode('_', $arg);
    
//    if($exarg[0]){}
    
    if($exarg[0]==='rekl'){
        $id=$exarg[2];
//        echo $id_rekl;
        if(!empty($_POST['plan_sl'])){
            $plan_sl=$post['plan_sl'];
            $plan_per=$post['plan_per'];
            unset($post['plan_sl']);
            unset($post['plan_per']);
            unset($_POST['plan_sl']);
            unset($_POST['plan_per']);
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
        foreach ($bidar as $sortbidinf){
            $sortb_id=$sortbidinf['id'];
            $sbid_ts=$sortbidinf['b_time'];
            $sbidar[$sbid_ts][$sortb_id]=$sortbidinf;
            $mb_key=$sortbidinf['radio_id'];
            $my_bidarr[$mb_key][$sortb_id]=$sortbidinf;
        }
        
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
            if($allbinf['status']==='man_ap' && empty($allbinf['sh_num'])){
                $shind_reklid=$allbinf['rekl_id'];
                $sh_ind[$shind_reklid][$allb_radioid]=1;
            }
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
        if($exarg[1]==='cab'){
            include_once  ROOT.'/views/header.php';
            include ROOT.'/views/cabinet/reklobzor.php';
        }
        if($exarg[1]==='plan'){
            $mediakey=$exarg[3];
    $mediaar=$r_str[$mediakey];
    unset($r_str);
    $r_str[$mediakey]=$mediaar;//оставляем в массиве только один элемент
    include_once  ROOT.'/views/header.php';
    include ROOT.'/views/cabinet/adm_reklplan.php';
        }
    }
    if($exarg[0]==='rman'){
        $id=$exarg[2];
        
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
                . "AND `ins_time`<$tw";
        $bidatar= Dbq::SelDb($bidq);//заявки
        
        $reklq="SELECT * FROM rekl";
        $rekl_inf= Dbq::SelDb($reklq);//
        
        if($exarg[1]==='cab'){
            include_once  ROOT.'/views/header.php';
            include ROOT.'/views/cabinet/radioobzor.php';
        }
    }if($exarg[0]==='search'){
        include_once  ROOT.'/views/header.php';
        include ROOT.'/views/cabinet/adminsearch.php';
    }
}