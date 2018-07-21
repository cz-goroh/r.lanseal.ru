<?php
if(!empty($_SESSION['rol'])&&!empty($_SESSION['ush'])&&!empty($_SESSION['usid'])){
    $ush=Dbq::AtomSel('us_hash', 'users', 'id' , $_SESSION['usid']);
    if($_SESSION['ush']===$ush){
    if($_SESSION['rol']==='r_man') {  header('Location: /cabinet/r_mancab/7');  }
    if($_SESSION['rol']==='client'){  header('Location: /cabinet/clientrcab/');}
    if($_SESSION['rol']==='loy')   {  header('Location: /cabinet/loycab/');    }
    if($_SESSION['rol']==='adm')   {  header('Location: /cabinet/admincab/');    }
    }else{
        include_once ROOT.'/views/base/header.php';
        include_once ROOT.'/views/base/index.php';
        include_once ROOT.'/views/base/reg_wind.php';
        include_once ROOT.'/views/base/footer.php';
    }
} else {
    include_once ROOT.'/views/base/header.php';
    include_once ROOT.'/views/base/index.php';
    include_once ROOT.'/views/base/reg_wind.php';
    include_once ROOT.'/views/base/footer.php';
//echo $_SERVER['REQUEST_URI'];
//Secure::mailYand('cz.goroh@gmail.com', 'hello!', '<h1>hello!</h1>', 'Andrej', 'hello!');
}