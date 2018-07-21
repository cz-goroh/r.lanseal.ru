<?php
//session_start();
    $dbo=new Dbcon();
    $dbc=$dbo->dbc();
    $dbc->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING ); //задаём обработку ошибок
    if(!empty($_SESSION['login'])){
    $sl=$_SESSION['login'];
try{
        $ushup = $dbc->prepare("UPDATE users SET `us_hash`='' WHERE login='$sl';");
        $ushup->execute();
        
        }catch (PDOException $e){
      
      file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND); 
    }}
if(!empty($_SESSION['login'])){unset($_SESSION['login']);}
if(!empty($_SESSION['prava'])){unset($_SESSION['prava']);}
if(!empty($_SESSION['name'])){unset($_SESSION['name']);}
if(!empty($_SESSION['rol'])){unset($_SESSION['rol']);}
if(!empty($_SESSION['id'])){unset($_SESSION['id']);}
if(!empty($_SESSION['ush'])){unset($_SESSION['ush']);}
if(!empty($_SESSION['usid'])){unset($_SESSION['usid']);}
 
header('Location: /');


