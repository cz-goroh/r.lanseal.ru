<?php

$post= Secure::PostText($_POST);
//if(isset($_POST['jsn'])){
//    $ar=['t1'=>'t1','t2'=>'t2','t3'=>'t3','t4'=>'t4'];
////    header('Content-Type: application/json; charset=utf-8');
//    echo json_encode($ar);
//}

if(isset($_POST['radio_inn_chk'])){
    $inn=$post['radio_inn_chk'];
    if(empty(Geo::CheckOrg($inn))){
        echo 'emp'; 
    } else { 
        echo 'ok';
    } exit();
}
if(isset($_POST['income'])){
    User::welcomen($post['login'], $post['password']);
}

if(isset($_POST['rs_mail'])){
    $chk_mail= Dbq::AtomSel('login', 'users', 'login', $post['rs_mail']);
    if(empty($chk_mail)){
        User::sendRegMail($post['rs_mail']);
//        $_SESSION['rs_mail']=$post['rs_mail'];
        //die();
        echo 'ok';
    } else {
        echo 'rep';
    }exit();
}
if(isset($_POST['confs_code'])){
    //echo 'ok';
    if($_SESSION['reg_hash']===$post['confs_code']){
        echo 'ok';
        exit();
    } 
}

if($arg==='form'){
if(isset($_POST['send_radioinf'])){
    $mail=$post['r_mail_r'];
    $pass=$post['new_pass'];
    $reppass=$post['new_reppass'];
    $rol='r_man';
    $name=$post['radio_name'];
    $surname=$post['radio_surname'];
    $tel=$post['radio_phone'];
    $adress=$post['radio_adr'];
//    print_r($post);    exit();
    $reg_r=User::registration($mail, $name, $surname, $pass, $reppass, $tel, $adress);
    if($reg_r==='norepeat'){
        $rolq="UPDATE users SET `rol`='r_man' WHERE `login`='$mail'";
        Dbq::InsDb($rolq);
        $fio=$surname.' '.$name.' '.$post['radio_otch'];
        $pos=$post['radio_position'];
        $rekv_arr= Geo::CheckOrg($post['radio_inn']);
        $rekv= serialize($rekv_arr);
        $geoar= Geo::AdressCoord($post['radio_adr']);
        $reg=$geoar['region']                ;
        $city=$geoar['city'];
        $adrs=$post['radio_adr'];
        
        $nm=$post['radio_nm'];
        $aud_desc='рыбалка, туризм, автомобили';
        $us_id= Dbq::AtomSel('id', 'users', 'login', $mail);
        $insq="INSERT INTO sation "//ошибка в названии таблицы
. "(`us_id`,`position`,`rekv`,`region`,`city`,`adrs`,`tel`,`st_nm`,`fio`,`aud_desc`) VALUES ("
. "'$us_id','$pos','$rekv','$reg','$city','$adrs','$tel','$nm','$fio','$aud_desc')";

        Dbq::InsDb($insq);
        $_SESSION['login']=$mail;
        $ushash= md5(md5(uniqid()));
        $_SESSION['ush']=$ushash;
        $_SESSION['rol']='r_man';
        $_SESSION['ush']=$ushash;
        $_SESSION['usid']= Dbq::AtomSel('id', 'users', 'login', $mail);
        $_SESSION['id']= Dbq::AtomSel('id', 'sation', 'us_id', $_SESSION['usid']);
        $qreg="UPDATE users SET `us_hash`='$ushash' WHERE `login`='$mail'";
        Dbq::InsDb($qreg);
        $mes='Ваши регистрационные данные на сайте NRS-MEDIA.ru: Логин '.$mail.','
        . 'Пароль '.$pass;
        $htmlBody='Ваши регистрационные данные на сайте NRS-MEDIA.ru:<br> Логин '.$mail.','
        . '<br>Пароль '.$pass;
        $subj='Регистрация на NRS-MEDIA.ru';
        Secure::mailYand($mail, $mes, $htmlBody, $name, $subj);
        Rman::NRTab($_SESSION['id']);//создаём записи структуры
    }
    header('Location: /signup/registration/result');
}
if(isset($_POST['send_reklinf'])){
    $mail=$post['r_mail_c'];
    $pass=$post['new_pass'];
    $reppass=$post['new_reppass'];
    $rol='rekl';
    $name=$post['rekl_name'];
    $surname=$post['rekl_surname'];
    $tel=$post['rekl_phone'];
    $adress=$post['rekl_adr'];
    $_SESSION['rol']='client';
//    print_r($post);    exit();
    $reg_r=User::registration($mail, $name, $surname, $pass, $reppass, $tel, $adress);
    
    if($reg_r==='norepeat'){
        $rolq="UPDATE users SET `rol`='client' WHERE `login`='$mail'";
        Dbq::InsDb($rolq);
        $fio=$surname.' '.$name.' '.$post['rekl_otch'];
        $pos=$post['rekl_position'];
        if(!empty($post['rekl_inn'])){
            $rekv_arr= Geo::CheckOrg($post['rekl_inn']);
        } else { $rekv_arr=[]; }
        $rekv= serialize($rekv_arr);
        $geoar= Geo::AdressCoord($adress);
        $reg=$geoar['region'];
        $city=$geoar['city'];
        $adrs=$post['rekl_adr'];
        
  //  $nm=$post['rekl_nm'];
        $us_id= Dbq::AtomSel('id', 'users', 'login', $mail);
        $insq="INSERT INTO rekl "
        . "(`us_id`,`position`,`rekv`,`region`,`city`,`adrs`,`fio`,`tel`) VALUES ("
        . "'$us_id','$pos','$rekv','$reg','$city','$adrs','$fio','$tel')";
        Dbq::InsDb($insq);
        $_SESSION['login']=$mail;
        $ushash= md5(md5(uniqid()));
        $_SESSION['ush']=$ushash;
        $_SESSION['rol']='client';
        $_SESSION['ush']=$ushash;
        $_SESSION['usid']= Dbq::AtomSel('id', 'users', 'login', $mail);
        $_SESSION['id']= Dbq::AtomSel('id', 'rekl', 'us_id', $_SESSION['usid']);
        $qreg="UPDATE users SET `us_hash`='$ushash' WHERE `login`='$mail'";
            Dbq::InsDb($qreg);
            $mes='Ваши регистрационные данные на сайте NRS-MEDIA.ru: Логин '.$mail.','
        . 'Пароль '.$pass;
        $htmlBody='Ваши регистрационные данные на сайте NRS-MEDIA.ru:<br> Логин '.$mail.','
        . '<br>Пароль '.$pass;
        $subj='Регистрация на NRS-MEDIA.ru';
        Secure::mailYand($mail, $mes, $htmlBody, $name, $subj);
    }
    header('Location: /signup/registration/result');
}
}            
if($arg==='result'){
    include_once ROOT.'/views/base/reg_result.php';
}
