<?php
$rand=array();
foreach ($rolar as $rolr):
    $rand[]=$rolr['id'];
endforeach;
//print_r($rand);
//ob_start();
 
//    $rolik_options=ob_get_contents();//записываем в переменную оптионы
    // для селекта с роликами
//ob_end_clean();
?>
    <div>
        <a style="float: left;"
            href="/cabinet/clientrcab/3">
            <img src="/views/img/blue_st.png" />
            <!--К списку радиостанций-->
        </a>
        
    <?php $st_nm= Dbq::AtomSel('st_nm', 'sation', 'id', $mediakey); ?>
    <h1 style=" font-size: 20px; text-align: center;margin-top: 10px;"
        >План- заявка на радиостанцию <?php echo $st_nm; ?></h1>
    </div>
    <!--<div style="margin-bottom: 10px;">-->
    <form style="display: inline-block;"
            action="#" method="post">
            Период планирования
            <select class="inp" name="plan_per" id="plan_per">
                <option value="38"
                <?php if(isset($plan_sl)&&!empty($plan_sl)&&
                        $plan_per==='38'): echo 'selected';
                endif; ?> >Месяц</option>
                
                <option value="14"
                <?php if(isset($plan_sl)&&!empty($plan_sl)&&
                        $plan_per==='14'): echo 'selected';
                endif; ?> >Неделя</option>
                
                <option value="21"
                <?php if(isset($plan_sl)&&!empty($plan_sl)&&
                        $plan_per==='21'): echo 'selected';
                endif; ?> >2 недели</option>
                
                <option value="28"
                <?php if(isset($plan_sl)&&!empty($plan_sl)&&
                        $plan_per==='28'): echo 'selected';
                endif; ?> >3 недели</option>
            </select>
            <?php echo date('d m',$t_month[15]); ?>
            <input  type="hidden" name="zaj_stek" value="1" />
            <?php foreach ($sat_inf as $sskey=> $sstek): 
                if(in_array($sskey, $post)):
                ?>
            <input type="hidden" name="zaj_<?php echo $sskey; ?>" 
                   value="<?php echo $sskey; ?>" />
            <?php endif; endforeach; ?>
            <button class="green-but" name="plan_sl" value="1" type="submit" >
            Применить</button>
        </form>
    <!--</div>-->
    <form style="display: inline;" id="forma"
        action="/cabinet/reclch/" method="post" >
            <a class="a-media" href="/cabinet/dnld/reklmedia_<?php echo $mediakey; ?>_<?php 
            if(!empty($plan_per)): echo $plan_per ; else: echo '38'; endif;
            ?>" 
           target="_blank" id="rekl_media<?php echo $mediakey; ?>">
            Скачать Медиаплан</a>
            <span >
        <?php if(!empty($expl_arg[0])&& $expl_arg[0]==='planstack') : ?>
              Ориентировочная Сумма заявки <span id="sum_span"></span> руб. 
                <button class="green-but" type="submit" name="bid"  value="planstack" >
            Отправить заявку и перейти к следующей станции! </button>
        <?php else: ?>
               Ориентировочная Сумма заявки <span id="sum_span"></span> руб. 
            <button class="green-but" type="submit" name="bid" 
                    value="single" >
            Отправить заявку ! </button>
        <?php endif; ?>
                <button  class="green-but"
        name="no_ch<?php echo $mediakey; ?>" id="no_ch<?php echo $mediakey; ?>"
                type="button" value="1">Очистить план-заявку</button>
        <script>
            $(document).ready(function(){
                $('#plan_per').change(function(){
                    var per=$('#plan_per :selected').val();
                    var uri='/cabinet/dnld/reklmedia_<?php echo $mediakey; ?>_' + per;
                    var vl=$('#plan_per :selected').html();
                    var html='Скачать медиаплан за ' + vl;
                    $("#rekl_media<?php echo $mediakey; ?>").html(html);
                    $("#rekl_media<?php echo $mediakey; ?>").attr("href", uri);
                });
                $('#no_ch<?php echo $mediakey; ?>').click(function(){
                    $(".ch<?php echo $mediakey; ?>").removeAttr('checked');
                });
            });
        </script>
            </span></div>
    <?php
if(!empty($r_str)):
foreach ($r_str as $rmk=>$rinf)://перебираем станци, где ключ- id станцииб, а элементы-
    //массивы с позициями структуры
$sl= Rman::MarkSort($rinf);
$mediakey=$rinf["$rmk"]['id_radio'];
$st_nm= $sat_inf[$mediakey]['st_nm'];
foreach ($rinf as $rinfar):
    $key_for_tab=$rinfar['week_d'].'%'.$rinfar['time_p'];
    $str_for_tab["$key_for_tab"]=$rinfar;//массив структуры с кдлючем дня недели и вр.пром
endforeach;
//$st_cart=$sat_inf[$id_r]; ?>
    <div > 
<!--        <a onclick="$('#one<?php // echo $id_r; ?>').slideToggle('slow');"
           href="javascript://">-->
            
    <!--</a>-->
        <?php if(!empty($sh_ind[$id][$mediakey])): ?>
        <a href="/cabinet/dnld/shcet_<?php echo $mediakey.'_'.$id; ?>" 
           target="_blank" id="sh_dnld<?php echo $mediakey; ?>">
            Скачать счёт</a>
        <script>
            $(document).ready(function(){
                $('sh_dnld<?php echo $mediakey; ?>').click(function(){
                    $('sh_dnld<?php echo $mediakey; ?>').hide(); }); });
        </script>  <?php endif; ?>
    </div>
    <!--<div id="one<?php //echo $id_r; ?>"  >-->
      <!--  <div style="width: 100%; height: 600px; overflow-y: auto;
             overflow-x: auto;">  -->      
    
      <table  border-collapsing="collapse" id="t1" >
    <thead >
    <tr>
        <th><div class="in_tab">Время</div></th>
<?php 
if(isset($plan_sl)&&!empty($plan_sl)):
    $t_month= array_slice($t_month, 0, $plan_per, TRUE);
endif;
foreach ($t_month as $mon_k=>$mon_t): ?>
        <th><div class="in_tab">
            <?php echo $rus_week[date('N', $mon_t)].'<br>'.date('d m',$mon_t); ?>
            </div></th>
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
    if(!empty($dlitarr[$mediakey][$timestamp])):
    $all_fil= array_sum($dlitarr[$mediakey][$timestamp]);endif;
    
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
            <div class="quest" id="qst<?php echo $timestamp.'_'.$mediakey; ?>">?</div>
            <?php endif; ?>
            <div class="price_str"> <?php echo $strinf['price']; ?>р</div>
            <?php if(!empty($settings['bol'])&&$settings['bol']==='yes'):?>
            <div class="boolit" id="bl<?php echo $timestamp.'_'.$mediakey; ?>">
                а вот и булит, только пока неясно, <br>какую инфу туда запихнуть- можно для каждой ячейки<br> свою, да и свойства менять пожалуйста
            </div>
            <script type="text/javascript">
                $(document).ready(function(){
                    $('#bl<?php echo $timestamp.'_'.$mediakey; ?>').hide();
                    $('#qst<?php echo $timestamp.'_'.$mediakey; ?>').mouseover(function(){
//                        $('#bl<?php// echo $timestamp.'_'.$id_r; ?>').css({
//                            "top" : event.pageY,
//                            "left" : event.pageX
//                        });
                        $('#bl<?php echo $timestamp.'_'.$mediakey; ?>').show(); });
                    $('#qst<?php echo $timestamp.'_'.$mediakey; ?>').mouseout(function(){
                        $('#bl<?php echo $timestamp.'_'.$mediakey; ?>').hide(); }); }); </script>
            <?php endif; ?>
        <?php
        $time_fil=0;          //время заявок текущего рекламодателя в промежутке
        
        
        if(isset($sbidar[$timestamp])&&!empty($sbidar[$timestamp])):
        foreach ($sbidar[$timestamp] as $bidk=>$bid)://выясняем есть ли заявка на это время  (56448ит)
           
            $r_id =(int)$bid['radio_id']   ;// 
            $mediakey =(int)$strinf['id_radio'];
            $t_st =(int)$timestamp         ;
            $b_tim=(int)$bid['b_time']     ;
        if($t_st===$b_tim && $r_id===$mediakey )://выясняем есть ли  
                                                           //заявка на это время
            if($bid['status']!='cans' && $bid['status']!='del'):
            $nt=Dbq::AtomSel('dlit', 'rolik', 'id', $bid['rolik_id']);
            $time_fil=$time_fil+$nt;//сумма длительности роликов текущего рекла
            endif;
            
if($bid['status']==='cans'): ?>
            <br><div class="stat-mark" style="background-color: red;" >
                <?php echo $bid['id']; ?>откл</div>
            <span id="recsp<?php echo $bid['id']; ?>">
                <button type="submit" name="del_bid" 
                        value="<?php echo $bid['id']; ?>"
                        id="rec<?php echo $bid['id']; ?>" class="status-button"
                >Отменить</button></span>
                <script type="text/javascript">
                $(document).ready(function(){
                    $('#rec<?php echo $bid['id']; ?>').click(function(){
                        var del_bid=$('#rec<?php echo $bid['id']; ?>').val();
                            $.ajax({
                            type: "POST",
                            url: "/cabinet/reclch",
                            data: { del_bid: del_bid },
                            success: function(html){           
                                var inr=html;
                                $('#recsp<?php echo $bid['id']; ?>').html(inr);
                            } }); return false;    }); });</script>    
           <?php endif;
if($bid['status']==='rec'): ?>
                <div class="stat-mark" style="background-color: #4C94DD;" >
                <?php echo $bid['id']; ?>Подана</div>
                <span id="recsp<?php echo $bid['id']; ?>">
                <button type="submit" name="del_bid" 
                        value="<?php echo $bid['id']; ?>"
                        id="rec<?php echo $bid['id']; ?>" class="status-button"
                >Отменить</button></span>
                <script type="text/javascript">
                $(document).ready(function(){
                    $('#rec<?php echo $bid['id']; ?>').click(function(){
                        var del_bid=$('#rec<?php echo $bid['id']; ?>').val();
                            $.ajax({
                            type: "POST",
                            url: "/cabinet/reclch",
                            data: { del_bid: del_bid },
                            success: function(html){           
                                var inr=html;
                                $('#recsp<?php echo $bid['id']; ?>').html(inr);
                            } }); return false;    }); });</script>    
           <?php endif;
if($bid['status']==='cl_app'): ?>
                <div class="stat-mark" style="background-color: #F59D31;" >
                <?php echo $bid['id']; ?>На соглас.</div>
                <span id="cl_appsp<?php echo $bid['id']; ?>">
                <button type="submit" name="del_bid" class="status-button"
                        value="<?php echo $bid['id']; ?>"
                        id="cl_app<?php echo $bid['id']; ?>" 
                >Отменить</button></span>
                <script type="text/javascript">
                $(document).ready(function(){
                    $('#cl_app<?php echo $bid['id']; ?>').click(function(){
                        var del_bid=$('#cl_app<?php echo $bid['id']; ?>').val();
                            $.ajax({
                            type: "POST",
                            url: "/cabinet/reclch",
                            data: { del_bid: del_bid },
                            success: function(html){           
                                var inr=html;
                                $('#cl_appsp<?php echo $bid['id']; ?>').html(inr);
                            } }); return false;    }); });</script>  
<?php endif;
if($bid['status']==='man_ap'):  ?>
                <div class="stat-mark" style="background-color: #697B7D;" >
                <?php echo $bid['id']; ?> Одобрено</div>
           <?php endif;
if($bid['status']==='red'): ?>
                <div class="stat-mark" style="background-color: #F59D31;" >
                <?php echo $bid['id']; ?>На соглас.</div>
                <span id="man_apsp<?php echo $bid['id']; ?>">
                    <button type="submit" name="del_bid"  class="status-button"
                        value="<?php echo $bid['id']; ?>"
                        id="man_ap<?php echo $bid['id']; ?>" 
                >Отменить</button></span>
                <script type="text/javascript">
                $(document).ready(function(){
                    $('#man_ap<?php echo $bid['id']; ?>').click(function(){
                        var del_bid=$('#man_ap<?php echo $bid['id']; ?>').val();
                            $.ajax({
                            type: "POST",
                            url: "/cabinet/reclch",
                            data: { del_bid: del_bid },
                            success: function(html){           
                                var inr=html;
                                $('#man_apsp<?php echo $bid['id']; ?>').html(inr);
                            } }); return false;    }); });</script> 
                
                <span id="accsp<?php echo $bid['id']; ?>">
                <button type="submit" name="del_bid"  class="status-button"
                        value="<?php echo $bid['id']; ?>"
                        id="acc<?php echo $bid['id']; ?>"
                >Подтвердить</button></span>
                <script type="text/javascript">
                $(document).ready(function(){
                    $('#acc<?php echo $bid['id']; ?>').click(function(){
                        var accept_bid=$('#acc<?php echo $bid['id']; ?>').val();
                            $.ajax({
                            type: "POST",
                            url: "/cabinet/reclch",
                            data: { accept_bid: accept_bid },
                            success: function(html){           
                                var inr=html;
                                $('#accsp<?php echo $bid['id']; ?>').html(inr);
                            } }); return false;    }); });</script> 
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
            <?php endif;
            if((int)$all_fil<(int)$strinf['pos_fil']||
                    (int)$all_fil===(int)$strinf['pos_fil']):
                $t2= strtotime("+7 day");
                if(!empty($rolar)&&($timestamp>$t2)): //селект  ?>
                    <br> <select name="rol_<?php echo $timestamp; ?>">
                    <?php foreach ($rolar as $rol): //перебираем ролики
    if(file_exists(ROOT.'/audio/rolik_'.$rol['id'].'.mp3')): 
        $rol_rand= array_rand($rand);
        ?>
    <option value="<?php echo $rol['id']; ?>"
 <?php if($rol['id']===$rand[$rol_rand]): echo 'selected'; endif; ?>>
    <?php echo $rol['id']; ?>
    </option>
    <?php  endif; endforeach; ?>
                    </select>
                    <?php // echo $rol_rand; ?>
                    <input type="checkbox" name="ts_<?php echo $timestamp; ?>_<?php echo $strinf['id']; ?>_<?php echo $mediakey; ?>"
                           value="<?php echo $strinf['price']; ?>" 
                           class="chb1_<?php echo $t_per; ?> a ch<?php echo $mediakey; ?> sum"
                           <?php if($color==='#ffff99'): echo 'checked'; endif; ?> />
                    
                     <?php 
                     $charr1[]=$wd.'_'.$t_per;
                endif;
            else:
               // echo '<br>Занято';
            endif;?>        
<?php //endif;endforeach;?>
        </div> </td><?php endforeach; ?>
    <!--<td><span id="td_<?php// echo $t_per;//ключ временного периода ?>"</td>-->
        
    </tr><?php endforeach; ?>        
</tbody></table>
        Нажимая "Отправить" Вы соглашаетесь с условиями
        <a href="/cabinet/dnld/oferta_<?php echo $mediakey; ?>">договора-оферты</a> радиостанции
        <?php echo $st_nm; ?>
        
        <br>

                
<!--</div>-->
    <?php endforeach;?>
         
    </form>
    
    <?php  endif;