
    <a href="/cabinet/admincab/rekl_cab_<?php echo $id; ?>">К списку радиостанций</a>
    
    <?php
if(!empty($r_str)):
foreach ($r_str as $rmk=>$rinf)://перебираем станци, где ключ- id станцииб, а элементы-
    //массивы с позициями структуры
$sl= Rman::MarkSort($rinf);
$id_r=$rinf["$rmk"]['id_radio'];
$st_nm= $sat_inf[$id_r]['st_nm'];
foreach ($rinf as $rinfar):
    $key_for_tab=$rinfar['week_d'].'%'.$rinfar['time_p'];
    $str_for_tab["$key_for_tab"]=$rinfar;//массив структуры с кдлючем дня недели и вр.пром
endforeach;
//$st_cart=$sat_inf[$id_r]; ?>
    <div > 
<!--        <a onclick="$('#one<?php // echo $id_r; ?>').slideToggle('slow');"
           href="javascript://">-->
            <h1>План- заявка на радиостанцию <?php echo $st_nm; ?></h1>
    </div>
    <div id="one<?php echo $id_r; ?>"  >
        <div style="width: 100%; height: 600px; overflow-y: auto;
             overflow-x: auto;">        
    
<table border="1" border-collapsing="collapse"
       cellpadding="2" cellspacing="0"  >
    <thead >
    <tr>
        <th>Время</th>
<?php 
if(isset($plan_sl)&&!empty($plan_sl)):
    $t_month= array_slice($t_month, 0, $plan_per, TRUE);
endif;
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
    <td style=" background-color: <?php echo $color; ?>;" width="80" height="80" ><!-- ячейка -->
        <div class="in_tab">
        <?php  $strinf=$str_for_tab["$int_k"]; ?>  
            <div class="aud_reach" >  <!-- циферка с пиком слушания -->
                <?php echo $strinf['aud_reach']; ?>  
            </div>
            <!-- БУЛИТЫЫЫЫЫЫЫЫЫ -->
            <?php if(!empty($settings['bol'])&&$settings['bol']==='yes'):?>
            <div class="quest" id="qst<?php echo $timestamp.'_'.$id_r; ?>">?</div>
            <?php endif; ?>
            <div class="price_str"> <?php echo $strinf['price']; ?>р</div>
            <?php if(!empty($settings['bol'])&&$settings['bol']==='yes'):?>
            <div class="boolit" id="bl<?php echo $timestamp.'_'.$id_r; ?>">
                а вот и булит, только пока неясно, <br>какую инфу туда запихнуть- можно для каждой ячейки<br> свою, да и свойства менять пожалуйста
            </div>
            <script type="text/javascript">
                $(document).ready(function(){
                    $('#bl<?php echo $timestamp.'_'.$id_r; ?>').hide();
                    $('#qst<?php echo $timestamp.'_'.$id_r; ?>').mouseover(function(){
                        $('#bl<?php echo $timestamp.'_'.$id_r; ?>').css({
                            "top" : event.pageY+10,
                            "left" : event.pageX+10
                        });
                        $('#bl<?php echo $timestamp.'_'.$id_r; ?>').show(); });
                    $('#qst<?php echo $timestamp.'_'.$id_r; ?>').mouseout(function(){
                        $('#bl<?php echo $timestamp.'_'.$id_r; ?>').hide(); }); }); </script>
            <?php endif; ?>
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
            
if($bid['status']==='cans'): ?>
            <br><div class="stat-mark" style="background-color: red;" >
                <?php echo $bid['id']; ?>откл</div>
           <?php endif;
if($bid['status']==='rec'): ?>
                <div class="stat-mark" style="background-color: #4C94DD;" >
                <?php echo $bid['id']; ?>Подана</div>
                
           <?php endif;
if($bid['status']==='cl_app'): ?>
                <div class="stat-mark" style="background-color: #F59D31;" >
                <?php echo $bid['id']; ?>На соглас.</div>
                
<?php endif;
if($bid['status']==='man_ap'):  ?>
                <div class="stat-mark" style="background-color: #697B7D;" >
                <?php echo $bid['id']; ?> Одобрено</div>
           <?php endif;
if($bid['status']==='red'): ?>
                <div class="stat-mark" style="background-color: #F59D31;" >
                <?php echo $bid['id']; ?>На соглас.</div>
                
           <?php endif;
if($bid['status']==='payd'): ?>
                <div class="stat-mark" style="background-color: #016648;" >
                <?php echo $bid['id']; ?> опл</div>
            <?php endif;
if($bid['status']==='compl'): ?>
                <div class="stat-mark" style="background-color: #E7262B;"  >
               <?php echo $bid['id']; ?>On air</div>
            <?php endif; endif;
            endforeach;
            
            endif;
            
            if($time_fil>0):  ?>
                <div class="stat-mark" style="background-color: #845574;" >Total
                <?php echo $time_fil; ?></div> 
            <?php endif; ?>
            
        </div> </td><?php endforeach; ?>
        
    </tr><?php endforeach; ?>        
</tbody></table>
        Нажимая "Отправить" Вы соглашаетесь с условиями
        <a href="/cabinet/dnld/oferta_<?php echo $id_r; ?>">договора-оферты</a> радиостанции
        <?php echo $st_nm; ?>

                
</div></div><?php endforeach;?>
         
    
    
    <?php  endif;