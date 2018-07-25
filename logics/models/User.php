<?php


class User{  
    
   // public $mni;
   public static function restPass($mail){                     //восстановление пароля
      $check_login= Dbq::AtomSel('pass', 'users', 'login', $mail);
      if(!empty($check_login)){
          $new_pass=uniqid();
          $mes='Ваш новый пароль от сайта NRS-MEDIA.ru '.$new_pass ;
          $htmlBody='<p>Ваш новый пароль от сайта lanseal.ru:</p>'
                  .'<p>'.$new_pass.'</p>';
          $name= Dbq::AtomSel('name', 'users', 'login', $mail);
          $subj= 'Новый пароль';
          $new_pass_hash=password_hash($new_pass,PASSWORD_BCRYPT);
          $npq="UPDATE users SET `pass`='$new_pass_hash' WHERE `login`='$mail'";
          Dbq::InsDb($npq);          
          Secure::mailYand($mail, $mes, $htmlBody, $name, $subj);
      }
   }
   public static function sendRegMail($mails){   //подтверждение почты
       $reg_hash= uniqid();
       $_SESSION['reg_hash']=$reg_hash;  
       $htmlBody='<h1>Регистрация на NRS-MEDIA.ru</h1>'
               . '<p>Вы получили это сообщение для подтверждения регистрации на '
               . 'сайте lanseal.ru, введите этот код в соответствующее поле:<br>'
               .$reg_hash.'</p>'
               . '<p> Если Вы не запрашивали его, просто не реагируйте </p>' ;
       $mes=    'Регистрация на NRS-MEDIA.ruВы получили это сообщение для '
               .'подтверждения регистрации на '
               .'сайте NRS-MEDIA.ru, введите этот код в соответствующее поле: '
               .$reg_hash
               . ' Если Вы не запрашивали его, просто не реагируйте';
       $subj =   'Регистрация на NRS-MEDIA.ru';
       Secure::mailYand($mails, $mes, $htmlBody, '', $subj);  
       
   }
    public static function registration
            ($mail,$name,$surname,$pass,$reppass,$tel,$adress){
        //создание соединения
    $dbo=new Dbcon();
    $dbc=$dbo->dbc();
    $dbc->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING ); //задаём обработку ошибок
   
    $login=(string)filter_var($mail,FILTER_VALIDATE_EMAIL);
    try {
        $cheklog=$dbc->query("SELECT `login` FROM users WHERE login= '$login';");
        $fislog=$cheklog->fetch();
        $islog=$fislog['login'];      
    } catch (PDOException $e){
      //echo " Извините. Но операция не может быть выполнена.";  
      file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);     
    }
    if($islog===$login){                
         User::wiyn();
         //include_once ROOT.'/views/header.php';
         $err['repeat']= "Пользователь с таким логином уже существует</br>";
         //include_once '/var/www/html/views/signup/regview.php';
         return 'repeat';
    }elseif((empty($login))&&(empty($name))&&(empty($mail))){
         //если данные невалидны
        $err['nodat']= "Введите необходимые данные";
        return 'novalid';
    }else{
        $err['oklog']= 'ok_log';
    $name=(string)filter_var($name,FILTER_SANITIZE_STRING);
    //if(isset($surname)){$surname=(string)filter_var($_POST['surname'],FILTER_SANITIZE_STRING);}
    $tel=(string)filter_var($tel,FILTER_SANITIZE_NUMBER_INT);
    $pattern="#[^0-9a-zA-Zа-яА-ЯёЁ_.,-]+#";
    $adress=preg_replace($pattern,"",$adress);
    //$pass=$_POST['password'];
    //$reppass=$_POST['rep_password'];
    //echo $name."</br>";
    //echo $pass."</br>";
    //echo $reppass."</br>";
    //echo $name."</br>";
    //echo $login."</br>";
    
    $hpass= password_hash($pass,PASSWORD_BCRYPT);
    
    $err['ok']= 'ok_pass';
    try{

        $dbp = $dbc->prepare(
        "INSERT INTO users (`login`,`name`,`surname`,`tel`,`adress`,`pass`) "
         . "VALUES (:login,:name,:surname,:tel,:adress,:pass);");
        $dbp->bindParam(':login',$login, PDO::PARAM_STR);
        $dbp->bindParam(':name',$name, PDO::PARAM_STR);
        $dbp->bindParam(':surname',$surname, PDO::PARAM_STR);
        $dbp->bindParam(':tel',$tel, PDO::PARAM_STR);
        $dbp->bindParam(':adress',$adress, PDO::PARAM_STR);
        $dbp->bindParam(':pass', $hpass);
        $dbp->execute();
       }
    catch (PDOException $e){
       
      file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND); 
    
    }
    //если регистрация прошла успешно
    $_SESSION['login']=$login;
    $_SESSION['usid']=$nm= Dbq::AtomSel('id', 'users', 'login', $login);
    //User::wiyn();   
    return 'norepeat';
    }   
    }
    
   public static function wiyn(){// абревиатура what is you name?
   //проверяет зарегистрирован ли пользователь на сайте return name or guest
   //echo 'wiwn';
    $dbo=new Dbcon();
    $dbc=$dbo->dbc();
    $dbc->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING ); //задаём обработку ошибок
    //получить из сессии логин проверить его наличие
    if(!empty($_SESSION['login'])){
        //echo 'login '.$_SESSION['login'];
         
             $login=$_SESSION['login'];
             $nm= Dbq::AtomSel('login', 'users', 'login', $login);
             //$_SESSION['usid']= Dbq::AtomSel('id', 'users', 'login', $login);
             //echo $nm;
             //print_r($nm);
            if(!empty($nm)){
                $mni=$nm;
             }//$mname=$nm['name'];}
             if($_SESSION['rol']==='r_man'){        //менеджер радио
                $namarr['namestr']= 
                '<a style=" color: #FCFCFC;" href=/signup/logout>Выйти</a>';//$cheknm->fetch()['login'];
             }elseif ($_SESSION['rol']==='client') {//рекламодатель
                $namarr['namestr']=
                '<a style=" color: #FCFCFC;" href=/signup/logout>Выйти</a>';
             }elseif ($_SESSION['rol']==='adm') {   //администратор
                $namarr['namestr']= 
                '<a style=" color: #FCFCFC;" href=/signup/logout>Выйти</a>';
             }elseif ($_SESSION['rol']==='loy') {   //юрист-куратор
                $namarr['namestr']= 
                '<a style=" color: #FCFCFC;" href=/signup/logout>Выйти</a>';
                }
             $namarr['mni']="$login";
             //$namarr['name']="$mname";
             if(isset($mni)){
                $chekrul=$dbc->query("SELECT `rules`FROM users WHERE login='$mni';");
                $prava=$chekrul->fetch()['rules'];
             }//echo $prava;
             if(isset($prava)){
                $_SESSION['prava']=$prava;// выяснить права записать их в сессию
             }
             return $namarr;
         
    
    } else {
        $inform=
        '<form method="post" action="/signup/registration/" id="incomform">
            <input type="email" name="login" id="login" placeholder="Логин"
            class="width-20"/><br>
            <input type="password" name="password" id="password" 
            placeholder="Пароль" class="width-20"/><br>
            <button name="income" type="button" value="1" id="income" 
            class="pink-but width-20" >Войти</button>
            <div style="color: red;" id="wrong_pass"></div>
        </form>';
        $namarr['namestr']=$inform;
        return $namarr;
        //echo 'guest';
    }       
    }
    
//процедура авторизации
    public static function welcomen($login,$pass){
    $dbo=new Dbcon();
    $dbc=$dbo->dbc();
    $dbc->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING ); //задаём обработку ошибок
    $welpass= Secure::PostText($pass);
    $wellogin=filter_var($login,FILTER_VALIDATE_EMAIL);
    $hashpass= Dbq::AtomSel('pass', 'users', 'login', $wellogin);
      
    //echo $hashpass;
    if(password_verify($welpass, $hashpass)){
        //echo '<br>pass_ok';
        $rses=$dbc->query("SELECT `id`,`login`,`name`,`rules`,`rol` FROM users WHERE login='$wellogin';");
        $rs=$rses->fetch();
        //print_r($rs);
        $_SESSION['login']=$rs['login'];
        $_SESSION['prava']=$rs['rules'];
        $_SESSION['name']=$rs['name'];
        $_SESSION['usid']=$rs['id'];
        $us_id=$rs['id'];
        $rol=$rs['rol'];
        if($rol==='r_man'){
            $_SESSION['id']= Dbq::AtomSel('id', 'sation', 'us_id', $us_id);
        }elseif($rol==='client') {
            $_SESSION['id']= Dbq::AtomSel('id', 'rekl', 'id', $us_id);
        }elseif ($rol==='loy') {
            $_SESSION['id']= Dbq::AtomSel('id', 'loy', 'us_id', $us_id);
        }
//        elseif($rol==='drv'){
//            $_SESSION['id']= Dbq::AtomSel('id_dr', 'users', 'login', $rs['login']);
//        }elseif($rol==='adm'){
//            $_SESSION['id']= Dbq::AtomSel('id', 'users', 'login', $rs['login']);
//        }
        $ushash= md5(md5(uniqid()));
        $_SESSION['ush']=$ushash;
        $_SESSION['rol']=$rol;
        try{
        $ushup = $dbc->prepare("UPDATE users SET us_hash=:ushash WHERE login='$wellogin';");
        $ushup->bindParam(':ushash',$ushash, PDO::PARAM_STR);
        $ushup->execute();
        
        }catch (PDOException $e){
      
      file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND); 
        }
        //echo $rol;
        if($rol==='r_man'){
        $idrman= Dbq::AtomSel('id', 'sation', 'us_id', $_SESSION['usid']);
        $_SESSION['id']=$idrman;
        $_SESSION['rol']='r_man';
        header('Location: /cabinet/r_mancab/');
        User::wiyn();        
        }
        if($rol==='client'){
        $idrman= Dbq::AtomSel('id', 'rekl', 'us_id', $_SESSION['usid']);
        $_SESSION['id']=$idrman;
        $_SESSION['rol']='client';
        header('Location: /cabinet/clientrcab/');
        User::wiyn();        
        }
        if($rol==='loy'){
            $idloy= Dbq::AtomSel('id', 'loy', 'us_id', $_SESSION['usid']);
            $_SESSION['id']=$idloy;
            $_SESSION['rol']='loy';
            header('Location: /cabinet/loycab/');
            User::wiyn();   
        }
        if($rol==='adm'){
            //$idloy= Dbq::AtomSel('id', 'loy', 'us_id', $_SESSION['usid']);
            $_SESSION['id']=0;
            $_SESSION['rol']='adm';
            header('Location: /cabinet/admincab/');
            User::wiyn();   
        }
//               
//        if($rol==='crr'){
//            $idcar= Dbq::AtomSel('id', 'carrier', 'mail', $login);
//           
//            $_SESSION['id']=$idcar;
//            $_SESSION['rol']='crr';
//            header('Location: /cabinet/carriercab');
//            User::wiyn();
//        
//        }
//        if($rol==='adm'){
//            $_SESSION['rol']='adm';
//            $_SESSION['login']='admin@admin.com';
//         header('Location: /cabinet/admincab'); 
//        User::wiyn();
//        
//        }
//        if($rol==='drv'){
//            $_SESSION['rol']='drv';
//            header('Location: /cabinet/drcab'); 
//        
//        User::wiyn();
//        
//        }
        
    }else{
        
        echo "wrong";
        exit();
        //header('Location: /');
    }
    
          }
// после метод управления контентом

}
