<?php
$full_price=0;
if(!empty($r_str)):
foreach ($r_str as $rmk=>$rinf)://перебираем станци, где ключ- id станцииб, а элементы-
    //массивы с позициями структуры
$sl= Rman::MarkSort($rinf);
$id_r=$rinf["$rmk"]['id_radio'];
$st_nm= $sat_inf[$id_r]['st_nm'];
foreach ($rinf as $rinfar):
    $key_for_tab=$rinfar['week_d'].'%'.$rinfar['time_p'];
    $str_for_tab["$key_for_tab"]=$rinfar;//массив структуры с кдлючем дня недели и вр.пром
endforeach; ?>
            <h1>Медиаплан <?php echo $st_nm; ?></h1>
<table border="1" border-collapsing="collapse"
       cellpadding="2" cellspacing="0"  >
    <thead >
    <tr>
        <th>Время</th>
<?php 
//if(isset($plan_sl)&&!empty($plan_sl)):
    $t_month= array_slice($t_month, 0, $plan_per, TRUE);
//endif;
foreach ($t_month as $mon_k=>$mon_t): ?>
    <th><?php echo $rus_week[date('N', $mon_t)].'<br>'.date('d m',$mon_t); ?></th>
    <?php endforeach; ?>
    </tr>    </thead>
    
    
    <tbody>
   <?php
 foreach ($d_arr as $t_per=>$tinf):     //перебираем временные промежутки(24ит) ?>
        <tr>
    <td><?php echo $tinf;  //вывод названия промежутка в первом столбце ?></td>
<?php foreach ($t_month as $mon_k=>$mon_t)://перебираем дни месяца
    $wd=date('N', $mon_t);
    $timestamp=(int)$mon_t+$t_hours["$t_per"];//начало временного промежутка
    
    $all_fil=0;
    if(!empty($dlitarr[$id_r][$timestamp])):
    $all_fil= array_sum($dlitarr[$id_r][$timestamp]);endif;
    
    $int_k=$wd.'%'.$t_per;//ключ из дня нед и номера врем. промежутка
    if(array_key_exists($int_k, $sl[1]["$wd"]))://определяем цветовой маркер
        $color='#ffff99';
    elseif(array_key_exists($int_k, $sl[2]["$wd"])):
        $color='#99CC66';        
    else:
        $color='inherit';
    endif;?>   <!-- цветовые маркеры  -->
    <td style=" background-color: <?php echo $color; ?>;" ><!-- ячейка -->
        <!--<div class="in_tab">-->
        <?php  $strinf=$str_for_tab["$int_k"]; ?>  
            <div class="aud_reach" >  <!-- циферка с пиком слушания -->
                <?php // echo $strinf['aud_reach']; ?>  
            </div>
            <div class="price_str"> <?php // echo $strinf['price']; ?></div>
            <?php
        $time_fil=0;          //время заявок текущего рекламодателя в промежутке
        
        
        if(isset($sbidar[$timestamp])&&!empty($sbidar[$timestamp])):
        foreach ($sbidar[$timestamp] as $bidk=>$bid)://выясняем есть ли заявка на это время  (56448ит)
            $r_id =(int)$bid['radio_id']   ;// 
            $id_r =(int)$strinf['id_radio'];
            $t_st =(int)$timestamp         ;
            $b_tim=(int)$bid['b_time']     ;
        if($t_st===$b_tim && $r_id===$id_r )://выясняем есть ли 
                                                           //заявка на это время
            if($bid['status']!='cans' && $bid['status']!='del'):
            $nt=Dbq::AtomSel('dlit', 'rolik', 'id', $bid['rolik_id']);
            $time_fil=$time_fil+$nt;//сумма длительности роликов текущего рекла
            endif;           

if($bid['status']==='rec'):  ?>
                <div class="stat-mark" style="background-color: #697B7D;" >
                <?php echo $bid['id']; ?></div>
           <?php
           $full_price=$full_price+$bid['sum'];
           endif; endif; 
            
            endforeach; 
        endif;
            if($time_fil>0):  ?>
                <div class="stat-mark" style="background-color: #845574;" >
                    <!--Total-->
                <?php //echo $time_fil; ?></div> 
            <?php endif;
            ?>
        <!--</div>--> 
    </td><?php endforeach; ?>
    </tr><?php endforeach; ?>        
</tbody></table>
            <h1 style="text-align: right;">
                <?php if(!empty($full_price)): ?>
                <div style="text-align: right;">Общая стоимость поданных заявок
                    <?php echo $full_price; ?> руб</div>
                    <?php endif; ?>
            </h1>
        <?php endforeach;?>
         
    
    <?php  endif;