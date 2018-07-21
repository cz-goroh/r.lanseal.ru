<?php

class Secure{
    
    public static function dnldFile($file,$fname){
        if (file_exists($file)) {
    // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
    // если этого не сделать файл будет читаться в память полностью!
    if (ob_get_level()) {
      ob_end_clean();
    }
    // заставляем браузер показать окно сохранения файла
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . $fname);
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    // читаем файл и отправляем его пользователю
    readfile($file);
    exit;
  }
    }

    public static function PostText($post){
        //print_r($_POST);
        if(!empty($post)){
        if(is_array($post)){
        foreach ($post as $pkey=>$pval){
        
            if (ctype_digit($pval)){//если цифры
                $post["$pkey"]=$pval;            
            }elseif (is_string($pval)){
                $post["$pkey"]= strip_tags($pval);//чистим
            }
        }
        } else {
            $post= strip_tags($post);//чистим
        }
        }
        return $post;
    }
    public static function urlValid($url) {
        return filter_var($url, FILTER_VALIDATE_URL);//валидация url
    }
    
    public static function mailYand
            ($mails,$mes,$htmlBody,$name,$subj,$attach_w=false,$fnm=false){
        $mail = new PHPMailer();                              // Passing `true` enables exceptions
        //Server settings
        $mail->setLanguage('ru', 'vendor/phpmailer/phpmailer/language/'); // Перевод на русский язык
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        //$mail->SMTPSecure = 'ssl';                          // secure transfer enabled REQUIRED for Gmail
        //$mail->Port = 465;                                  // TCP port to connect to
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to
        $mail->Host = 'smtp.yandex.ru';                       // Specify main and backup SMTP servers
        $mail->Username = 'r.lanseal.ru@yandex.ru';           // SMTP username
        $mail->Password = 'lanseal2018';                      // SMTP password
        //Recipients
        $mail->setFrom('r.lanseal.ru@yandex.ru', 'lanseal.ru');
        $mail->addAddress($mails,$name);                      // Name is optional
        $mail->addBCC('cz.goroh@gmail.com'); 
        //Content 
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subj;
        $mail->Body    = $htmlBody;
        $mail->AltBody = $mes;
        $mail->CharSet = "UTF-8";
        //$attach_w=ROOT.'/doc/user_guid.pdf';
        // print_r($attach_w);
        if(!empty($attach_w)&&!empty($fnm)){                   // переберём имена файлов 
            foreach ($attach_w as $ak=>$at_w){                 // и пути к ним
            $mail->addAttachment($at_w, $fnm[$ak]);
            }
        }
        $mail->send();            
        //echo 'Mailer Error: ' . $mail->ErrorInfo; 
        $mail->ClearAddresses();
        $mail->ClearAttachments();
    }
}
