<!DOCTYPE HTML >
<html> 
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title></title>
	<meta name="generator" content="LibreOffice 4.2.8.2 (Linux)">
	<meta name="created" content="20091016;111200000000000">  
	<meta name="changed" content="20091016;113500000000000">
	<style type="text/css">
	<!--
		@page { margin-right: 1.5cm; margin-top: 2cm; margin-bottom: 2cm }
		p { margin-bottom: 0.25cm; direction: ltr; color: #000000; line-height: 120%; widows: 2; orphans: 2 }
		p.western { font-family: "Times New Roman", serif; font-size: 12pt; so-language: ru-RU }
		p.cjk { font-family: "Times New Roman", serif; font-size: 12pt }
		p.ctl { font-family: "Times New Roman", serif; font-size: 12pt; so-language: ar-SA }
	-->
	</style>
</head>
<body lang="ru-RU" text="#000000" dir="ltr">
<?php //print_r($_SESSION); ?>
<p class="western"><font face="Arial, sans-serif">
    Поставщик: <b><?php echo $rman['fname']; ?></b></font></p>

<p class="western">
</p>

<p class="western"><font face="Arial, sans-serif">
    Юр. адрес: <?php echo  $rman['jradr']; ?></font></p>

<p class="western">
</p>
		

<p class="western" style="margin-bottom: 0cm; line-height: 100%"><br>
</p>

<table width="693" cellpadding="7" cellspacing="0">
<col width="157">
<col width="159">
<col width="43">
<col width="274">
<tr>
<td width="157" valign="top" style="border-top: 1.50pt solid #000000; border-bottom: 1.50pt solid #000000; border-left: 1.50pt solid #000000; border-right: none; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.19cm; padding-right: 0cm">
        <p class="western"><font face="Arial, sans-serif">ИНН <?php echo  $rman['inn']; ?></font>
        </p>
</td>
<td width="159" valign="top" style="border-top: 1.50pt solid #000000; border-bottom: 1.50pt solid #000000; border-left: 1.50pt solid #000000; border-right: none; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.19cm; padding-right: 0cm">
        <p class="western"><font face="Arial, sans-serif">КПП <?php echo  $rman['kpp']; ?></font>
        </p>
</td>
<td rowspan="2" width="43" valign="bottom" 
    style="border-top: 1.50pt solid #000000; border-bottom: 1.50pt solid #000000; border-left: 1.50pt solid #000000; border-right: none; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.19cm; padding-right: 0cm">
        <font face="Arial, sans-serif">Сч.№</font>
</td>
<td rowspan="2" width="274" valign="top" style="border: 1.50pt solid #000000; padding: 0cm 0.19cm">
   <br>	<br><br><?php echo  $rman['rs']; ?> <!-- номер счёта РС -->
</td>
</tr>
<tr valign="top">
<td colspan="2" width="330" style="border-top: 1.50pt solid #000000; border-bottom: 1.50pt solid #000000; border-left: 1.50pt solid #000000; border-right: none; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.19cm; padding-right: 0cm">
<p class="western" style="margin-bottom: 0cm">
<font face="Arial, sans-serif">Получатель: <?php echo  $rman['fname']; ?><!-- наименование поставщика --></font></p>
</td>
</tr>
<tr>
<td rowspan="2" colspan="2" width="330" height="12" valign="top" style="border-top: 1.50pt solid #000000; border-bottom: 1.50pt solid #000000; border-left: 1.50pt solid #000000; border-right: none; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.19cm; padding-right: 0cm">
<p class="western" style="margin-bottom: 0cm">
    <font face="Arial, sans-serif">Банк	получателя</font></p>
    <font face="Arial, sans-serif"><?php echo  $rman['bank']; ?><!-- банк получателя --></font>
</td>
<td width="43" style="border-top: 1.50pt solid #000000; border-bottom: 1.50pt solid #000000; border-left: 1.50pt solid #000000; border-right: none; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.19cm; padding-right: 0cm">
<p class="western" align="center">
<font face="Arial, sans-serif">БИК</font></p>
</td>
<td rowspan="2" width="274" valign="top" style="border: 1.50pt solid #000000; padding: 0cm 0.19cm">
<?php echo  $rman['bik'] ; ?><!-- БИК поставщика услуг -->
<br><br><?php echo  $rman['ks'] ; ?><!-- номер счёта КС -->

</td>
</tr>
<tr>
<td width="43" style="border-top: 1.50pt solid #000000; border-bottom: 1.50pt solid #000000; border-left: 1.50pt solid #000000; border-right: none; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.19cm; padding-right: 0cm">
<p class="western" align="center">
<font face="Arial, sans-serif">Сч.№</font></p>
</td>
</tr>
</table>

<p class="western" style="margin-bottom: 0cm; line-height: 100%"><br>
</p>
<p class="western" align="center" style="margin-bottom: 0cm; line-height: 100%">
<font face="Arial, sans-serif"><font size="4" style="font-size: 16pt">
<b>СЧЕТ  №  <?php echo $sh_n; ?> от <?php echo $date_sh?> г.</b></font></font></p>
<p class="western" style="margin-bottom: 0cm; line-height: 100%">
    <font face="Arial, sans-serif">Плательщик:
    <!--информация о плательщике-->
    <?php echo  $rekl['fname']; ?>
    <?php if(!empty($rekl['kpp'])){ echo 'КПП:   '. $rekl['kpp'];} ?>
    ИНН:   <?php echo  $rekl['inn']; ?>
    ОГРН:  <?php echo  $rekl['ogrn']; ?>
    Адрес: <?php echo  $rekl['jradr']; ?>
    </font></p>
<p class="western" style="margin-bottom: 0cm; line-height: 100%">
    <font face="Arial, sans-serif">Получатель услуги:
    <?php echo  $rekl['fname']; ?>
    <?php if(!empty($rekl['kpp'])){ echo'КПП: '.  $rekl['kpp'];} ?>
    ИНН:   <?php echo  $rekl['inn']; ?>
    ОГРН:  <?php echo  $rekl['ogrn']; ?>
    Адрес: <?php echo  $rekl['jradr']; ?>
    </font></p>
<p class="western" style="margin-bottom: 0cm; line-height: 100%">
    <font face="Arial, sans-serif">Основание: <?php echo $dogovor; ?></font><br>
</p>
<table width="693" cellpadding="7" cellspacing="0">
<col width="17">
<col width="322">
<col width="70">
<col width="58">
<col width="70">
<col width="70">
<tr>
<td width="17" style="border-top: 1.50pt solid #000000; border-bottom: 1.50pt solid #000000; border-left: 1.50pt solid #000000; border-right: none; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.19cm; padding-right: 0cm">
<p class="western" align="center">№</p>
</td>
<td width="322" style="border-top: 1.50pt solid #000000; border-bottom: 1.50pt solid #000000; border-left: 1.50pt solid #000000; border-right: none; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.19cm; padding-right: 0cm">
<p class="western" align="center">
<font face="Arial, sans-serif"><b>Наименование услуги</b></font></p>
</td>
<td width="70" style="border-top: 1.50pt solid #000000; border-bottom: 1.50pt solid #000000; border-left: 1.50pt solid #000000; border-right: none; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.19cm; padding-right: 0cm">
<p class="western" align="center">
<font face="Arial, sans-serif"><b>Единица</b></font></p>
</td>
<td width="58" style="border-top: 1.50pt solid #000000; border-bottom: 1.50pt solid #000000; border-left: 1.50pt solid #000000; border-right: none; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.19cm; padding-right: 0cm">
<p class="western" align="center"><font face="Arial, sans-serif">
<b>Коли-чество</b></font></p>
</td>
<td width="70" style="border-top: 1.50pt solid #000000; border-bottom: 1.50pt solid #000000; border-left: 1.50pt solid #000000; border-right: none; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.19cm; padding-right: 0cm">
<p class="western" align="center"><font face="Arial, sans-serif">
<b>Цена</b></font></p>
</td>
<td width="70" style="border: 1.50pt solid #000000; padding: 0cm 0.19cm">
<p class="western" align="center">
<font face="Arial, sans-serif"><b>Сумма</b></font></p>
</td>
</tr>
<tr valign="top"><!-- основная услуга -->
<td width="17" style="border-top: 1.50pt solid #000000; border-bottom: 1.50pt solid #000000; border-left: 1.50pt solid #000000; border-right: none; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.19cm; padding-right: 0cm">
        <p class="western">№<font face="Arial, sans-serif"><b>1</b></font></p><!-- номер строки -->
</td>
<td width="322" style="border-top: 1.50pt solid #000000; border-bottom: 1.50pt solid #000000; border-left: 1.50pt solid #000000; border-right: none; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.19cm; padding-right: 0cm">
<p class="western"><font face="Arial, sans-serif">
    <!--наименование услуги--><?php echo $serv_name; ?>
            </font></p>
</td>
<td width="70" style="border-top: 1.50pt solid #000000; border-bottom: 1.50pt solid #000000; border-left: 1.50pt solid #000000; border-right: none; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.19cm; padding-right: 0cm">
        <p class="western"><font face="Arial, sans-serif">шт.</font></p>
</td>
<td width="58" style="border-top: 1.50pt solid #000000; border-bottom: 1.50pt solid #000000; border-left: 1.50pt solid #000000; border-right: none; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.19cm; padding-right: 0cm">
        <p class="western"><font face="Arial, sans-serif">1</font></p><!-- количество в строке -->
</td>
<td width="70" style="border-top: 1.50pt solid #000000; border-bottom: 1.50pt solid #000000; border-left: 1.50pt solid #000000; border-right: none; padding-top: 0cm; padding-bottom: 0cm; padding-left: 0.19cm; padding-right: 0cm">
<p class="western"><font face="Arial, sans-serif">
    <?php echo $price; ?> руб.</font></p><!-- цена одной услуги -->
</td>
<td width="70" style="border: 1.50pt solid #000000; padding: 0cm 0.19cm">
<p class="western"><font face="Arial, sans-serif">
    <?php echo $price ; ?> руб.</font></p><!-- стоимость строки -->
</td>
</tr>
<tr valign="top">
<td rowspan="3" colspan="5" width="593" style="border-top: 1.50pt solid #000000; border-bottom: none; border-left: none; border-right: none; padding: 0cm">
<p class="western" align="right" style="margin-bottom: 0cm">
    <font face="Arial, sans-serif"><b>Итого:</b></font></p>
<p class="western" align="right" style="margin-bottom: 0cm">
    <font face="Arial, sans-serif"><b>
        <?php if($nds>0): ?>
        В том числе НДС (18%):
        <?php endif; ?>
    </b></font></p>
<p class="western" align="right"><font face="Arial, sans-serif"><b>
        Всегок оплате:</b></font></p>
</td>
<td width="70" style="border: 1pt solid #000000; padding: 0cm 0.19cm">
<p class="western"><font face="Arial, sans-serif">
<?php echo $price ; ?> руб.</font></p><!-- общая стоимость -->
</td>
</tr>
<tr valign="top">
<td width="70" style="border: 1pt solid #000000; padding: 0cm 0.19cm">
<p class="western"><font face="Arial, sans-serif">
<?php if($nds>0): echo $nds; endif;?> руб.</font></p>                              <!-- НДС -->
</td>
</tr>
<tr valign="top">
<td width="70" style="border: 1.50pt solid #000000; padding: 0cm 0.19cm">
<p class="western"><font face="Arial, sans-serif">
    <?php echo $price ; ?> руб.</font></p><!-- общая стоимость -->
</td>
</tr>
</table>

<p class="western" style="margin-bottom: 0cm; line-height: 100%">
<font face="Arial, sans-serif">Всего наименований  1
<?php //echo $_SESSION['calc1']['col'] ?>, на сумму   <!-- количество строк -->
<?php echo $price; ?> руб.</font></p><!-- общая стоимость -->
<p class="western" style="margin-bottom: 0cm; line-height: 100%">
<font face="Arial, sans-serif">сумма прописью:
<?php echo Rman::num2str($price); ?></font></p>        <!-- стоимость буквами -->
<p class="western" style="margin-bottom: 0cm; line-height: 100%"><br>
</p>
<p class="western" style="margin-bottom: 0cm; line-height: 100%">
    <font face="Arial, sans-serif"><?php echo $doljn; ?> </font>   <!-- должность -->    
<!--<img src="podp-e.jpg" width="97" height="76" alt="podp-e"/>      подпись -->
(<?php echo $fio_dir ?>)                                       <!-- ФИО -->
<!--<img src="pechbezfona-e.jpg" height="40mm" alt="podp-e"/>         печать -->
</p>

<p class="western" style="margin-bottom: 0cm; line-height: 100%"> 
</p>
<!-- <p class="western" style="margin-bottom: 0cm; line-height: 100%"><font face="Arial, sans-serif">Главный
бухгалтер                     glavbuh              
(____________________)</font></p> -->

<p class="western" style="margin-bottom: 0cm; line-height: 100%"><br>
</p>
<p class="western" style="margin-left: 2.54cm; margin-bottom: 0cm; line-height: 100%">
<br>
</p>
</body>
</html>

