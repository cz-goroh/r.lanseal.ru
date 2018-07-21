
<table border="1" cellpadding="2" style="width: 290mm">
    <thead>
    <tr>
    <th>Время</th>
    <th>Пн<?php echo date('d m', strtotime('monday this week')+604800  ); ?></th>
    <th>Вт<?php echo date('d m', strtotime('monday this week')+691200  ); ?></th>
    <th>Ср<?php echo date('d m', strtotime('monday this week')+777600  ); ?></th>
    <th>Чт<?php echo date('d m', strtotime('monday this week')+864000  ); ?></th>
    <th>Пт<?php echo date('d m', strtotime('monday this week')+950400  ); ?></th>
    <th>Сб<?php echo date('d m', strtotime('monday this week')+1036800 ); ?></th>
    <th>Вс<?php echo date('d m', strtotime('monday this week')+1123200 ); ?></th>
    <th>Кол-во</th>
    <th>Общая стоимость</th>
    </tr>
    </thead>
    <tbody>
   <?php
   $sl=Rman::MarkSort($r_str);
   $prom_dlit[$t_per]=array();
   $prom_sum[$t_per]=array();
 foreach ($d_arr as $t_per=>$tinf):        //перебираем временные промежутки ?>
        <tr>
    <td><?php echo $tinf;   //вывод названия промежутка в первом столбце ?></td>        
<?php foreach ($w_arr as $wd):                           //перебираем дни недели 
    $int_k=$wd.'%'.$t_per;
    if(array_key_exists($int_k, $sl[1]["$wd"])){
        $color='yellow';
    }elseif(array_key_exists($int_k, $sl[2]["$wd"])){
        $color='green';        
    }else{
        $color='inherit';
    }
    $timestamp=$t_week2["$wd"]+$t_hours["$t_per"];
    $nm_rol= date('h-d-m', $timestamp).'.mp3';
?>   <!-- цветовые маркеры  -->
    <td style=" background-color: <?php echo $color; ?>;">
<?php 
foreach ($r_str as $str_k=>$strinf):              //перебираем позиции структуры 
//    print_r($strinf);
//    echo '<br>';
if($strinf['week_d']==="$wd" && $strinf['time_p']==="$t_per"):
    ?>
<!-- ========================= содержимое ячейки =========================== -->
    <?php
    $fil_time=0;$fil_sum=0;
    
    foreach ($barr as $bidkey=>$bid): //перебираем заявки текущего 
        if((int)$bid['b_time']===(int)$timestamp)://если заявка на это время  
            //echo $bid['status'];
            if($bid['status']==='payd'):
                    
            $cur_dlit=(int)Dbq::AtomSel('dlit', 'rolik', 'id', $bid['rolik_id']);
            $fil_time=$fil_time + $cur_dlit;
            $cur_price=((int)$strinf['price']/30)*$cur_dlit;
            $fil_sum=$fil_sum+$cur_price;
            ?>Заявка <mark style="background-color: red;"><?php echo $bid['id'];
            ?></mark><br><?php
        endif;  endif; endforeach;
 if(!empty($fil_time)):
            $prom_dlit2[$t_per][$wd]=$fil_time;
            $prom_sum2[$t_per][$wd]=$fil_sum;
            echo 'принято: '.$fil_time.'сек,<br>на'.$fil_sum.'руб.<br>';
     endif;
//<!-- ========================= содержимое ячейки ========================= -->
 endif;
endforeach;
?></td>
<?php endforeach; ?>
    <td id="kol<?php if(!empty($prom_dlit2[$t_per])){ echo array_sum($prom_dlit2[$t_per]);} ?>" >
        <?php if(!empty($prom_dlit2[$t_per])){ echo array_sum($prom_dlit2[$t_per]);} ?></td>
    <td id="pr<?php if(!empty($prom_dlit2[$t_per])){ echo array_sum($prom_sum2[$t_per]);} ?>" >
    <?php if(!empty($prom_dlit2[$t_per])){ echo array_sum($prom_sum2[$t_per]);} ?></td>
</tr>
<?php endforeach; ?>
        
    </tbody>
</table>
        