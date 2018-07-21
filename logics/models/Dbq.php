<?php
class Dbq{
    
    public static function SelDb($qery){// select qery
         $dbo=new Dbcon();
         $dbc=$dbo->dbc();
         $dbc->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
         
        try{
        $dbqo=$dbc->query($qery);
         $dbqr=$dbqo->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
               echo " Извините. Но операция не может быть выполнена.";  
               file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND); 
               } 
               return $dbqr;
    }
    public static function InsDb($qery){// insert,update qery
        //echo "</br> ins db:\"".$qery."\"";
         $dbo=new Dbcon();
         $dbc=$dbo->dbc();
         $dbc->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
         
        try{
       
           $dbc->exec($qery);
          // $last_id=$dbo->lastInsertId();
        }catch (PDOException $e){
               echo " Извините. Но операция не может быть выполнена.";  
               file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND); 
               }     
              // return $last_id;
        
    }
    public static function AtomSel($qfield,$tab,$wfield,$wparam){
         $dbo=new Dbcon();
         $dbc=$dbo->dbc();
         $dbc->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
         
        try{
            $qery="SELECT `".$qfield."` FROM ".$tab." WHERE ".$wfield."='$wparam'";
        $dbqo=$dbc->query($qery);
         $dbqr=$dbqo->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
               echo " Извините. Но операция не может быть выполнена.";  
               file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND); 
               } 
               return $dbqr["$qfield"];
        
        
    }
    
}





/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

