<?php

class Geo{
    
    public static function RegByIp($ip){        
        $fields=['query'=>"$ip","count"=>1];
        $result = false;
        if ($ch = curl_init("https://suggestions.dadata.ru/suggestions/api/4_1/rs/detectAddressByIp?ip=".$ip))
        {
             curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                 'Content-Type: application/json',
                 'Accept: application/json',
                 'Authorization: Token 2ae95ed1cef9323717fbc91c75aa0904c7a4cdeb'
              ));
             //curl_setopt($ch, CURLOPT_POST, 1);
             // json_encode
             //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
             $result = curl_exec($ch);
             $result = json_decode($result, true);
             curl_close($ch);
        }
       // print_r($result);
        $region=$result['location']['data']['region'];
        return $region;        
    }
    //google api AIzaSyBJQHYkTdy4pblGH-lbqAiLo33X7KP1Of8
    
    public static function AdressCoord($adress) {//получение геоданных по адресу
        //echo "adr".$adress;
        $fields=['query'=>"$adress","count"=>1];
        $result = false;
        if ($ch = curl_init("http://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address")){
             curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                 'Content-Type: application/json',
                 'Accept: application/json',
                 'Authorization: Token 2ae95ed1cef9323717fbc91c75aa0904c7a4cdeb'
              ));
             curl_setopt($ch, CURLOPT_POST, 1);
             // json_encode
             curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
             $result = curl_exec($ch);
             $result = json_decode($result, true);
             curl_close($ch);
        }
//        echo '<br> adrcoord ';
//        print_r($result);
        $coord['region']= $result['suggestions'][0]['data']['region'];
        $coord['city']= $result['suggestions'][0]['data']['city'];
        $coord['city_district']= $result['suggestions'][0]['data']['city_district'];
        $geo_lat= $result['suggestions'][0]['data']['geo_lat'];
        $geo_lon= $result['suggestions'][0]['data']['geo_lon'];
        $coord['coord']=$geo_lat."+".$geo_lon;
        $coord['geo_lat']=$geo_lat;
        $coord['geo_lon']=$geo_lon;
        return $coord;
    }
    public static function CheckOrg($inn){ //получение реквезитов по инн        
        $fields=['query'=>"$inn","count"=>2];
        $result = false;
        if ($ch = curl_init("http://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/party")){
             curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                 'Content-Type: application/json',
                 'Accept: application/json',
                 'Authorization: Token 2ae95ed1cef9323717fbc91c75aa0904c7a4cdeb'
              ));
             curl_setopt($ch, CURLOPT_POST, 1);
             // json_encode
             curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
             $result = curl_exec($ch);
             $result = json_decode($result, true);
             curl_close($ch);
        }
        if(!empty($result['suggestions']['0'])){
        if(!empty($res['kpp'])){
        $res['kpp']= $result['suggestions']['0']['data']['kpp']; }
        $res['fname']= $result['suggestions']['0']['data']['name']['full_with_opf'];
        $res['ogrn']= $result['suggestions']['0']['data']['ogrn'];
        $res['jradr']= $result['suggestions']['0']['data']['address']['unrestricted_value'];
        $res['inn']=$inn;
        //print_r($result);
        } else {
            $res=[];
        }
        return $res;
        
    }
    
}
//Array ( [destination_addresses] => Array ( [0] => Мостовая ул., 31, Шахты, Ростовская обл., Россия, 346510 ) [origin_addresses] => Array ( [0] => Украинский пер., 20, Таганрог, Ростовская обл., Россия, 347922 ) [rows] => Array ( [0] => Array ( [elements] => Array ( [0] => Array ( [distance] => Array ( [text] => 156 км [value] => 155553 ) [duration] => Array ( [text] => 2 ч. 38 мин. [value] => 9480 ) [status] => OK ) ) ) ) [status] => OK )