<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Router
 *
 * @author kolobkov-jw
 */
class Router {
    public  $argum=NULL;
    private $routesarr; // в эту переменную загружаем массив из routes
    private $securiarr=['basecontroller','baseaction']; // массив с проверенными элементами из строки запроса
    public function __construct() {
        $routesway= ROOT.'/config/routes.php';//переменная, содержащая путь к массиву с роутами
        $this->routesarr= include ($routesway);//
        
    }
    private function sequreuri(){
        
        $uri=trim($_SERVER['REQUEST_URI'],'/');//ЗДЕСЬ НЕОБХОДИМО РЕАЛИЗОВАТЬ БЕЗОПАСНОСТЬ!!!
        if(!empty($uri)){              //если строка запроса не пустая,
           $uriarr= explode('/', $uri);//строку запроса преобразовали в массив
            //print_r($uriarr);
           //return $uriarr;
        
        //print_r($uriarr);
        if(array_key_exists($uriarr[0],$this->routesarr)){//если существует запрошенный контроллер
        foreach ($this->routesarr as $keyroutes => $strroutes) {//перебор файла routes
               //$keyroutes-контроллер, $strroutes-строка с роутами
               //echo "$keyroutes<br>$strroutes";
               //если первый эл-т совпадает с одним из контроллеров 
                 if($uriarr[0]==$keyroutes){
                   $this->securiarr[0]=$keyroutes;//присваиваем 0элементу имя контроллера
                   $actarr=explode('/', $this->routesarr[$keyroutes]);// делим строку экшинов соотв контроллеру                 
                   //
                        if(in_array($uriarr[1],$actarr)){//
                            $this->securiarr[1]=$uriarr[1];//
                            
                            if((!empty($uriarr[2]))&&(preg_match('/^[a-zA-Z0-9-_.,@]+$/', $uriarr[2]))){//буквы и цифры в 3 элементе
                                $this->argum=$uriarr[2];
                                return $this->argum;
                            }
                            break;
                        } else {
                            echo 'Убедитесь в правильности набора url';
                            $this->securiarr[1]='baseaction';
                          }  
                       break;
                          }
                }
            } else {
                echo 'Убедитесь в правильности набора url';
                $this->securiarr=['basecontroller','baseaction'];
            }
                } else {
                    //echo 'empty';
            $this->securiarr=['basecontroller','baseaction'];
            return $this->securiarr;
        }
              
            
         
        return $this->securiarr;
    }
    public function getargum(){
        $this->sequreuri();
        return $this->argum;
    }

    public function routeselect(){
        $this->sequreuri();
       $controller= $this->securiarr[0];
       $action= $this->securiarr[1];
       $arg=$this->argum;
         include_once( ROOT . "/logics/controllers/" . "$controller.php") ;     
         include_once( ROOT."/logics/actions/"."$action.php");


                
    }      
//конец класса
}
