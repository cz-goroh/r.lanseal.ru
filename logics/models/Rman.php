<?php
class Rman{
    
    public static function BlSchet(
            $rekl_ser,
            $rman_ser,
            $price,
            $dogovor,
            $serv_name,
            $doljn,
            $fio_dir,
            $sh_n,
            $date_sh,
            $nds
            ){
        $rekl = unserialize($rekl_ser);
        $rman = unserialize($rman_ser);
        $prc=$price/100;
        if($nds>0){ $nds=$prc*18; }
        $fw=ROOT."/views/blanc/shcet.php";
        ob_start();
        include $fw;
        $html= ob_get_contents();
        ob_end_clean();
        error_reporting (E_ERROR);
        $mpdf = new mPDF('utf-8', 'A4', 8, '', 10, 10, 7, 7, 10, 10); /*задаем формат, отступы и.т.д.*/
        //$mpdf->charset_in = 'cp1251'; /*не забываем про русский*/
        $stylesheet = file_get_contents(ROOT.'/style.css'); /*подключаем css*/
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->list_indent_first_level = 0; 
        $mpdf->WriteHTML($html, 2); /*формируем pdf*/
        $vy='shcet.pdf';
        $mpdf->Output($vy, 'I');
        
    }

        public static function morph($n, $f1, $f2, $f5) {
	$n = abs(intval($n)) % 100;
	if ($n>10 && $n<20) return $f5;
	$n = $n % 10;
	if ($n>1 && $n<5) return $f2;
	if ($n==1) return $f1;
	return $f5;
}
    public static function num2str($num) {
	$nul='ноль';
	$ten=array(
		array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
		array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
	);
	$a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
	$tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
	$hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
	$unit=array( // Units
		array('копейка' ,'копейки' ,'копеек',	 1),
		array('рубль'   ,'рубля'   ,'рублей'    ,0),
		array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
		array('миллион' ,'миллиона','миллионов' ,0),
		array('миллиард','милиарда','миллиардов',0),
	);
	//
	list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
	$out = array();
	if (intval($rub)>0) {
		foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
			if (!intval($v)) continue;
			$uk = sizeof($unit)-$uk-1; // unit key
			$gender = $unit[$uk][3];
			list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
			// mega-logic
			$out[] = $hundred[$i1]; # 1xx-9xx
			if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
			else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
			// units without rub & kop
			if ($uk>1) $out[]= Rman::morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
		} //foreach
	}
	else $out[] = $nul;
	$out[] = Rman::morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
	$out[] = $kop.' '.Rman::morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
	return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

        public static function NRTab($id) {//новая таблица пиков и прайс с автозаполнением
        //принимает id радиостанции
        $d_arr= include ROOT.'/config/t_arr.php';
        $w_arr=[1,2,3,4,5,6,7];
        foreach ($w_arr as $w_d){
            foreach ($d_arr as $time_p=>$time_int){
            $price= rand(500, 1500);
            $aud_reach=rand(40,90);
            $t= time();
            $inq="INSERT INTO struct (`week_d`,`time_p`,`price`,`aud_reach`,"
            . "`id_radio`,`pr_status`,`t_ins`,`t_begin`,`pos_fil`) VALUES "
            . "('$w_d','$time_p','$price','$aud_reach','$id','cur','$t','$t',600)";
            Dbq::InsDb($inq);
            }
        }
    }
    public static function MarkSort($r_str){
        //========================сортировка для маркировки=============================
foreach ($r_str as $s_k=>$sinf){                                              //
                                                                              //
    $k=$sinf['week_d'].'%'.$sinf['time_p'];//ключ из id позиции               //
    if($sinf['week_d']==='1'){                                                //
        $nsarr[1]["$k"]=$sinf['aud_reach'];                                   //
    }                                                                         //
    if($sinf['week_d']==='2'){                                                //
        $nsarr[2]["$k"]=$sinf['aud_reach'];                                   //
    }                                                                         //
    if($sinf['week_d']==='3'){                                                //
        $nsarr[3]["$k"]=$sinf['aud_reach'];                                   //
    }                                                                         //
    if($sinf['week_d']==='4'){                                                //
        $nsarr[4]["$k"]=$sinf['aud_reach'];                                   //
    }                                                                         //
    if($sinf['week_d']==='5'){                                                //
        $nsarr[5]["$k"]=$sinf['aud_reach'];                                   //
    }                                                                         //
    if($sinf['week_d']==='6'){                                                //  
        $nsarr[6]["$k"]=$sinf['aud_reach'];                                   //
    }                                                                         //
    if($sinf['week_d']==='7'){                                                //
        $nsarr[7]["$k"]=$sinf['aud_reach'];                                   //
    }                                                                         //
                                                                              //
}                                                                             //
 arsort($nsarr[1]);                                                           //
 arsort($nsarr[2]);                                                           //
 arsort($nsarr[3]);                                                           //
 arsort($nsarr[4]);                                                           //
 arsort($nsarr[5]);                                                           //
 arsort($nsarr[6]);                                                           //
 arsort($nsarr[7]);                                                           //
 $sl[1]['1']=array_slice($nsarr[1], 0, 2, TRUE);                              //
 $sl[2]['1']=array_slice($nsarr[1], 2, 3, TRUE);                              //
                                                                              //
 $sl[1]['2']=array_slice($nsarr[2], 0, 2, TRUE);                              //
 $sl[2]['2']=array_slice($nsarr[2], 2, 3, TRUE);                              //
                                                                              //
 $sl[1]['3']=array_slice($nsarr[3], 0, 2, TRUE);                              //
 $sl[2]['3']=array_slice($nsarr[3], 2, 3, TRUE);                              //
                                                                              //
 $sl[1]['4']=array_slice($nsarr[4], 0, 2, TRUE);                              //
 $sl[2]['4']=array_slice($nsarr[4], 2, 3, TRUE);                              //
                                                                              //
 $sl[1]['5']=array_slice($nsarr[5], 0, 2, TRUE);                              //
 $sl[2]['5']=array_slice($nsarr[5], 2, 3, TRUE);                              //
                                                                              //
 $sl[1]['6']=array_slice($nsarr[6], 0, 2, TRUE);                              //
 $sl[2]['6']=array_slice($nsarr[6], 2, 3, TRUE);                              //
                                                                              //
 $sl[1]['7']=array_slice($nsarr[7], 0, 2, TRUE);                              //
 $sl[2]['7']=array_slice($nsarr[7], 2, 3, TRUE);                              //
 
 return $sl;
//==============================================================================
    }
}














































