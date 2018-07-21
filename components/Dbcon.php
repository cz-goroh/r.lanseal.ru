<?php //


class Dbcon {
    
//    private $host='localhost';
//    private $db_name='webcontainer';//в названии базы данных ошибка- не kolhseRvise, а kolhsEVise
//    private $db_login='root';
//    private $db_pass='764K65OO31kP';
    
    private $host='localhost';
    private $db_name='admin_radio';
    private $db_login='root';
    private $db_pass='Radio26';

    public function dbc(){
        
        $dbco = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->db_login, $this->db_pass);
        $dbco->exec("set names utf8");  
        return $dbco;
    }
   
    //put your code here
}