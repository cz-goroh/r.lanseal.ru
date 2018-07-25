<?php
if(isset($_POST['sation_del'])){
    $idst=$post['sation_del'];
    $delstq="UPDATE sation SET `status`='del' WHERE `id`=$idst";
    Dbq::InsDb($delstq);
    header('Location: /cabinet/admincab/');
}
if(isset($_POST['sation_ree'])){
    $idst=$post['sation_ree'];
    $delstq="UPDATE sation SET `status`='' WHERE `id`=$idst";
    Dbq::InsDb($delstq);

    header('Location: /cabinet/admincab/');
}
if(isset($_POST['change_pass'])){
    $hashpass= Dbq::AtomSel('pass', 'users', 'id', $usid);
    if($post['new_pass']===$post['new_reppass']){
        if(password_verify($post['curr_pass'], $hashpass)){
            $new_pass=password_hash($post['new_pass'],PASSWORD_BCRYPT);
            $npq="UPDATE users SET `pass`='$new_pass' WHERE `login`='admin@admin.adm'";
            Dbq::InsDb($npq);
            echo 'Пароль обновлён';
        } else { echo 'Неверный текущий пароль'; }
    } else { echo 'Новые пароли не совпадают'; }
    exit();
    }

if(isset($_POST['rad_change_pass'])){
    $id=$post['rad_change_pass'];
    $usid= Dbq::AtomSel('us_id', 'sation', 'id', $id);
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

if(isset($_POST['rad_profile_ch'])){//обновление профиля
    $id=$post['rad_profile_ch'];
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
    $links=$post['links'];
    $zone=$post['zone'];
    $site=$post['site'];
    $aud_desc=$post['aud_desc'];
    $oxv_aud=$post['oxv_aud'];
    $rmq="UPDATE sation SET `position`='$position',`region`='$region',"
            . "`city`='$city',`adrs`='$adrs',`links`='$links',`zone`='$zone',`site`='$site',"
            . "`aud_desc`='$aud_desc',`oxv_aud`='$oxv_aud',`po_version`='$po_version',"
            . "`trafik_mail`='$trafik_mail',`nds`='$nds' WHERE `id`='$id'";
    Dbq::InsDb($rmq);
    header('Location: /cabinet/admincab/rman_cab_'.$id);
}
if(isset($_POST['rad_rekv_ch'])){
    $id=$post['rad_rekv_ch'];
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
    header('Location: /cabinet/admincab/rman_cab_'.$id);
}

if(isset($_POST['rek_change_pass'])){
    
    $id=$post['rek_change_pass'];
    $usid= Dbq::AtomSel('us_id', 'rekl', 'id', $id);
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
if(isset($_POST['rek_profile_ch'])){
    $id=$post['rek_profile_ch'];
    $name=$post['name'];
    $tel=$post['tel'];
    
    $usq="UPDATE users SET `name`='$name',`tel`='$tel'"
            . "WHERE `id`='$usid'";
    Dbq::InsDb($usq);
    $position=  $post['position'];
    $region=    $post['region'];
    $city=      $post['city'];
    $adrs=      $post['adrs'];
    if(!empty($post['nds'])){
        $nds=       $post['nds'];
    } else {
    $nds=    'no';
    }
    $rmq="UPDATE rekl SET `position`='$position',`region`='$region',"
            . "`city`='$city',`adrs`='$adrs',`nds`='$nds'"
            . " WHERE `id`='$id'";
//    echo $rmq;
    Dbq::InsDb($rmq);
    header('Location: /cabinet/admincab/reklcab_'.$id);
    }
if(isset($_POST['rek_rekv_ch'])){
    $id=$post['rek_rekv_ch'];
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
    header('Location: /cabinet/admincab/reklcab_'.$id);
}
if(isset($_POST['del_rol'])){
    $rol_id=$post['del_rol'];
    $delq="DELETE FROM rolik WHERE `id`=$rol_id";
    Dbq::InsDb($delq);
    if(file_exists(ROOT.'/audio/rolik_'.$rol_id.'.mp3'));
    unlink(ROOT.'/audio/rolik_'.$rol_id.'.mp3');
    header('Location: /cabinet/admincab/');
}
if(isset($_POST['rolik_upl'])){
    $name=$post['rolik_nm'];
    $t= time();
    $dlit=$post['dlit'];
    $size=$_FILES['rolik']['size'];
    $txt=$post['ntxt'];
    $rolq="INSERT INTO rolik "
            . "(`name`,`t_ins`,`size`,`rekl_id`,`status`,`dlit`,`txt`) "
            . "VALUES ('$name',$t,$size,$id,'upl',$dlit,'$txt')";
    Dbq::InsDb($rolq);
    $lastq="SELECT HIGH_PRIORITY max(id) FROM `rolik`";
    $rolik_id= Dbq::SelDb($lastq)[0]["max(id)"];// id текущей позиции
    $way=ROOT.'/audio/rolik'.'_'.$rolik_id.'.mp3';
    move_uploaded_file($_FILES['rolik']['tmp_name'], $way);
    header('Location: /cabinet/admincab/');
}
if(isset($_POST['rolik_upd'])){
    $rolik_id=$post['rolik_upl'];
    $upq="UPDATE rolik SET `status`='red' WHERE `id`=$rolik_id";
    Dbq::InsDb($upq);
    $way=ROOT.'/audio/rolik'.'_'.$rolik_id.'.mp3';
    unlink($way);
    move_uploaded_file($_FILES['rolik']['tmp_name'], $way);
    header('Location: /cabinet/admincab/');
}