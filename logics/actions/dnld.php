<?php
$exarg=explode('_', $arg);

if($exarg[0]==='reklmedia'){
//    echo 'reklmedia';
    $mediakey=$exarg[1];
    $mediaar=$r_str[$mediakey];
    unset($r_str);
    $r_str[$mediakey]=$mediaar;//оставляем в массиве только один элемент
    $plan_per=$exarg[2];
    
    ob_start();
    include ROOT.'/views/blanc/rekl_media.php';
    $html=ob_get_contents();
    ob_end_clean();
    
//    error_reporting (E_ERROR);
        $mpdf = new mPDF('utf-8', 'A4-L', 8, '', 10, 10, 7, 7, 10, 10); /*задаем формат, отступы и.т.д.*/
        $stylesheet = file_get_contents(ROOT.'/style.css'); /*подключаем css*/
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->list_indent_first_level = 0; 
        $mpdf->WriteHTML($html, 2); /*формируем pdf*/
        $fw='mediaplan_'.$mediakey.'.pdf';
        $mpdf->Output($fw, 'I');
        
        ini_set('display_errors',1);
        error_reporting(E_ALL);
}

if($exarg[0]==='rolik'){
    $rolik_id=$exarg[1];
    $file=ROOT.'/audio/rolik_'.$rolik_id.'.mp3';
    $fname=$exarg[2];
    Secure::dnldFile($file,'rolik'.$fname.'.mp3');
}
if($exarg[0]==='pay'){
    $bid_id=$exarg[1];
    $file=ROOT.'/doc/pay_'.$bid_id.'.pdf';
    $fname=$exarg[2];
    Secure::dnldFile($file,'pay'.$fname.'.pdf');
}


if($exarg[0]==='shcet'){
    $idrad=$exarg[1];
   $idrekl=$exarg[2]; 
   $rekl_ser= Dbq::AtomSel('rekv', 'rekl', 'id', $idrekl);//реквизиты рекламодателя
   $rman_ser= Dbq::AtomSel('rekv', 'sation', 'id', $idrad);//реквизиты радио
   $doljn=    Dbq::AtomSel('position', 'sation', 'id', $idrad);//должность радио
   $fio_dir=  Dbq::AtomSel('fio', 'sation', 'id', $idrad);//фио для счёта
   $st_nm=    Dbq::AtomSel('st_nm', 'sation', 'id', $idrad);//название станции
   $dogovor=  Dbq::AtomSel('dog_nm', 'sation', 'id', $idrad);//наименование договора
   $nds=      Dbq::AtomSel('nds', 'sation', 'id', $idrad);//плательщик/неплательщик ндс
   if($nds!='yes'){$nds=0;}elseif($nds==='yes'){$nds=18;}
   $selbidq="SELECT * FROM bid WHERE `radio_id`=$idrad AND `rekl_id`=$idrekl "
           . "AND `status`='man_ap'";
   $barr= Dbq::SelDb($selbidq);//массив заявок
   if(!empty($barr)){
   foreach ($barr as $bkey=>$b_in){
       if(empty($b_in['sh_num'])){
           $idb=$b_in['id'];
           $bc_arr[$idb]=$b_in['sum'];//содержащиеся в счёте заявки=>цена
           $tm_ar[$idb]= $b_in['b_time'];//заявки=>время начала
       }
   }
   if(!empty($bc_arr)){
   $bid_cont= serialize($bc_arr);
   $t_beg= min($tm_ar);
   $t_end= max($tm_ar);
//   date('d.m.Y')
   $serv_name='Размещение рекламной кампании согласно '.$dogovor .
           ' в эфире радиостанции "'.$st_nm.'" в период с '.date('d.m.Y',$t_beg)
           .' по '.date('d.m.Y',$t_end);
   $bid_ser= serialize($bc_arr);
   $ins="INSERT INTO shcet (`bid_cont`,`radio_id`,`rekl_id`,`status`) "
                 . "VALUES ('$bid_cont',$idrad,$idrekl,'bill')";
   Dbq::InsDb($ins);
   $lastq="SELECT HIGH_PRIORITY max(id) FROM `shcet`";
   $sh_n= Dbq::SelDb($lastq)[0]["max(id)"];
   foreach ($barr as $bkey=>$b_in){
       $bid=$b_in['id'];
       $ups="UPDATE bid SET `sh_num`=$sh_n WHERE `id`=$bid";
       Dbq::InsDb($ups);
   }
   $price= array_sum($bc_arr);
   $date_sh=date('d.m.Y');
   $sh_ser= serialize([
        'rekl_ser'=>$rekl_ser,'rman_ser'=>$rman_ser,'price'=>$price,
        'dogovor'=>$dogovor,'serv_name'=>$serv_name,'doljn'=>$doljn,
        'fio_dir'=>$fio_dir,'sh_n'=>$sh_n,'date_sh'=>$date_sh, 'nds'=>$nds   ]);
   $ushq="UPDATE shcet SET `sh_ser`='$sh_ser' WHERE `id`=$sh_n";
   Dbq::InsDb($ushq);
   Rman::BlSchet($rekl_ser, $rman_ser, $price, $dogovor, $serv_name,
           $doljn, $fio_dir, $sh_n,$date_sh,$nds);
   }else{
       $selq="SELECT HIGH_PRIORITY max(id) FROM `shcet` "
               . "WHERE `radio_id`=$idrad AND `rekl_id`=$idrekl";
//       echo $selq;
       $sh_n= Dbq::SelDb($selq)[0]["max(id)"];
       $sh_infs=Dbq::AtomSel('sh_ser', 'shcet', 'id', $sh_n);
       $sh_inf= unserialize($sh_infs);
       //echo $sh_n;
//       print_r($sh_inf);
       Rman::BlSchet($sh_inf['rekl_ser'], $sh_inf['rman_ser'], $sh_inf['price'],
               $sh_inf['dogovor'], $sh_inf['serv_name'], $sh_inf['doljn'],
               $sh_inf['fio_dir'], $sh_inf['sh_n'],$sh_inf['date_sh']);
   }
   }
}
if($exarg[0]==='oferta'){
   $id_rad=$exarg[1];
   $file=ROOT.'/doc/oferta'.$id_rad.'.pdf';
   $fname='Oferta.pdf';
   Secure::dnldFile($file, $fname);
}
if($exarg[0]==='arhsh'){
    $sh_id=$exarg[1];
    $sh_infs= Dbq::AtomSel('sh_ser', 'shcet', 'id', $sh_id);
    $sh_inf= unserialize($sh_infs);
    Rman::BlSchet($sh_inf['rekl_ser'], $sh_inf['rman_ser'], $sh_inf['price'],
               $sh_inf['dogovor'], $sh_inf['serv_name'], $sh_inf['doljn'],
               $sh_inf['fio_dir'], $sh_inf['sh_n'],$sh_inf['date_sh']);
}
if($exarg[0]==='plat'){
    $sh_id=$exarg[1];
    $file=ROOT.'/doc/plat_'.$sh_id.'.pdf';
    $fname='plat_'.$sh_id.'.pdf';
    Secure::dnldFile($file, $fname);
}
//if($exarg[0]==='shcet'){
//    $bid_id=$exarg[1];
//    $bidq="SELECT * FROM bid WHERE `id`=$bid_id";
//    $bidar= Dbq::SelDb($bidq)[0];
//    $rmanid=$bidar['radio_id'];
//    $rmanq="SELECT * FROM sation WHERE `id`=$rmanid";
//    $rarr= Dbq::SelDb($rmanq)[0];
//    $struct_id= $bidar['struct_id'];
//    $rekl_ser=$rekl_inf[0]['rekv'];
//    $rman_ser= $rarr['rekv'];
//    $price= (Dbq::AtomSel('price', 'struct', 'id', $struct_id)/30)*
//    Dbq::AtomSel('dlit', 'rolik', 'id', $bidar['rolik_id']);
//    $dogovor='Название договора';
//    $serv_name='Наименование услуги';
//    $sh_num=$bid_id;
//    $doljn=$rekl_inf[0]['position'];
//    $fio_dir=$rekl_inf[0]['fio'];
//    Rman::BlSchet($rekl_ser, $rman_ser, $price, $dogovor, $serv_name, $sh_num, 
//            $rarr['position'], $rarr['fio'],$bid_id);
//}