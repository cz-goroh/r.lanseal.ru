<?php
if(isset($_POST['change_pass'])){
    $hashpass= Dbq::AtomSel('pass', 'users', 'id', $usid);
    if($post['new_pass']===$post['new_reppass']){
        if(password_verify($post['curr_pass'], $hashpass)){
            $new_pass=password_hash($post['new_pass'],PASSWORD_BCRYPT);
            $npq="UPDATE users SET `pass`='$new_pass' WHERE `id`=$usid";
            Dbq::InsDb($npq);
//            echo 'Пароль обновлён';
        } else { 
//            echo 'Неверный текущий пароль'; 
        }
    } else { 
//        echo 'Новые пароли не совпадают';
        }
//    exit();
    header('Location: /cabinet/loycab/1');
}
if(isset($_POST['acp'])): 
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
endif;
if(isset($_POST['rj'])):
//    $post= Secure::PostText($_POST);
    $rj=$post['rj'];
    $statser= Dbq::AtomSel('status', 'rolik', 'id', $rj);
    $statarr= unserialize($statser);
    $statarr['rej'][]=$st_id;
    unset($statarr['upl']);
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
if(isset($post['new_loy']) && !empty($post['new_loy'])):
    $name=$post['nm'];
    $sur=$post['sn'];
    $login=$post['login'];
    $tel=$post['tel'];
    $nlq="UPDATE users SET `name`='$name',`surname`='$sur',`login`='$login',`tel`='$tel' "
            . "WHERE `id`=$usid";
    Dbq::InsDb($nlq);
//    echo $nlq;
    header('Location: /cabinet/loycab/1');
endif;
