<?php include_once ROOT.'/views/header.php';
 
?>
<div class="layout">
    <div class="sidebar">
        <!--id="hidden_panel" -->
        
            <a href="/" 
               style="font-size: 2em;  text-decoration: none;
               color: #FB3943; background-color:  #17222E">
                NRS-MEDIA</a>
        
        <span style="text-decoration: none; color: #FCFCFC; background-color:  #17222E">
            <?php echo $_SESSION['login']; ?></span>
        
        
        <p class="a_style"  id="a3"> Ролики</p>
        <p class="a_style"  id="a1"> Профиль</p>
        <p class="a_style"  id="a3">
            <a style="color: inherit;" class="" href="/signup/logout">Выйти</a></p>
    </div>
    <div id="main-div" class="content" ></div>
</div>
<div id="content">
<div id="d-1" class="dc">
<h4>Профиль</h4>
<h4 class="h-div">Смена пароля</h4>
<form method="post" action="/cabinet/loych/">
    Введите текущий пароль
    <input    name="curr_pass" id="curr_pass" type="password" class="left-30 inp"/>
    <br>Введите новый пароль
    <input  name="new_pass" id="new_pass" type="password" class="left-30 inp"/>
    <br>Повторите новый пароль
    <input   name="new_reppass" id="new_reppass" type="password" class="left-30 inp"/>
    <br><button class="green-but" name="change_pass" value="1" type="submit" id="change_pass">
        Отправить</button><span id="res_pass" ></span>
</form>
    <script type="text/javascript">
//    $(document).ready(function(){
//        $('#change_pass').click(function(){
//            var curr_pass=  $('#curr_pass').val();
//            var new_pass=   $('#new_pass').val();
//            var new_reppass=$('#new_reppass').val();
//                $.ajax({
//                type: "POST",
//                url: "/cabinet/loycab/",
//                data: { 
//                    curr_pass:   curr_pass ,
//                    new_pass:    new_pass,
//                    new_reppass: new_reppass,
//                    change_pass: 1
//                },
//                beforeSend: function() { 
////            $('#change_pass').attr('disabled',true);
//            $('#change_pass').html('Отправляем');
//        },
//                success: function(html){           
//                    var inr=html;
//                    $('#res_pass').html(inr);
////                    ('#change_pass').attr('disabled',false);
//                } }); return false;    }); });</script><br>
    ____________________________________________________________________________
<form method="post" action="/cabinet/loych/">
    <div class="prof_nam">Имя</div>
    <input  class="npas left-30"  name="nm" type="text" placeholder="Имя"
    value="<?php if(!empty($us_inf['name'])): echo $us_inf['name'];endif; ?>"/>
    <div class="prof_nam">Фамилия</div>
    <input class="npas left-30"  name="sn" type="text" placeholder="Фамилия"
    value="<?php if(!empty($us_inf['name'])): echo $us_inf['surname'];endif; ?>" />
    <div class="prof_nam">E-mail</div>
    <input class="npas left-30"  name="login" type="email" placeholder="Email"
    value="<?php if(!empty($us_inf['name'])): echo $us_inf['login'];endif; ?>" />
    <div class="prof_nam">Телефон</div>
    <input class="npas left-30"  name="tel" type="tel" placeholder="Телефон" 
    value="<?php if(!empty($us_inf['name'])): echo $us_inf['tel'];endif; ?>" 
    class="phone" />
    <button class="green-but" name="new_loy" value="l" type="submit" >Обновить</button>
</form> 
</div>
<div id="d-3" class="dc">
    <h4>Ролики</h4>
<?php
//print_r($us_inf);
//include_once ROOT.'/views/header.php';
//echo User::wiyn()['namestr']; ?>
<form action="#" method="post">
<?php
if(!empty($rarr)):
foreach ($rarr as $infrk=>$infr):
    $rolstats=$infr['status'];
    $rolstat_arr= unserialize($rolstats);//массив статусов
    if(array_key_exists('rej',$rolstat_arr)){
        $rejser=$infr['descr'];
        $rejarr= unserialize($rejser);//массив комментариев о доработка
    }
    
    if(array_key_exists('upl',$rolstat_arr)):$rol_color='yellow';$rolst='Новый';
    endif;
    if(array_key_exists('app',$rolstat_arr) && (in_array($st_id, $rolstat_arr['app']))):
        $rol_color='green'; $rolst='Одобрен';       endif;
    if(array_key_exists('rej',$rolstat_arr) && in_array($st_id,$rolstat_arr['rej'])):$rol_color='red';   $rolst='Отклонён';
    endif;
    if(array_key_exists('red',$rolstat_arr) &&($rolstat_arr['red']===$st_id)):
        $rol_color='blue';  $rolst='Отредактирован';endif;
    ?>
    
    <!--===================================ПЛЕЕР=============================-->
    <mark id="color<?php echo $infr['id']; ?>" class="central"
          style="background-color: <?php echo $rol_color; ?>">
              <?php echo $infr['id']; ?> </mark>
    <?php echo $infr['name']; ?>
    Длительность <?php echo $infr['dlit']; ?> сек
    <audio controls style="background-color: <?php echo $rol_color; ?>" class="central">
        <source src="/audio/rolik_<?php echo $infr['id']; ?>.mp3" type="audio/mpeg">
        Прослушивание не поддерживается вашим браузером. 
        <a href="/audio/rolik_<?php echo $infr['id']; ?>.mp3">Скачайте музыку</a>
    </audio>
<!--=========================================================================-->
<span id="res" class="central"></span>
<?php if(!array_key_exists('app',$rolstat_arr) || !in_array($st_id, $rolstat_arr['app'])): ?>
    <button name="accept" value="<?php echo $infr['id']; ?>" type="button"  class="central"
            id="acp<?php echo $infr['id']; ?>" >Одобрить</button>
<?php if(!array_key_exists('rej',$rolstat_arr) || !in_array($st_id,$rolstat_arr['rej'])): ?>  
    <span id="ac<?php echo $infr['id']; ?>" class="central" >
    <button class="central" name="reject" value="<?php echo $infr['id']; ?>" type="button" 
            id="rjc<?php echo $infr['id']; ?>" >Отклонить
    </button></span>
    <div id="rjd<?php echo $infr['id']; ?>">
        <input name="descr" id="dsc<?php echo $infr['id']; ?>" class="central"
               placeholder="Ваш комментарий" /> 
        <button name="rej" value="<?php echo $infr['id']; ?>" type="button" 
            id="rj<?php echo $infr['id']; ?>" class="central" >Отправить</button>

    </div>
<?php 
elseif(array_key_exists('rej',$rolstat_arr) && in_array($st_id, $rolstat_arr['rej'])) : ?>
    На доработке (<?php echo $rejarr[$st_id]; ?>)
<?php endif; ?>
    <?php if(array_key_exists('red',$rolstat_arr) &&($rolstat_arr['red']===$st_id)): ?>
        <mark style="background-color: red;">Ролик доработан</mark><?php endif; ?>
    <?php 
    elseif(array_key_exists('app',$rolstat_arr) || in_array($st_id, $rolstat_arr['app'])):
        echo 'Одобрен';    endif; ?>
    <br><a onclick="$('#sat<?php echo $infr['id']; ?>').slideToggle('slow');"
   href="javascript://" > Текст <?php echo $infr['id']; ?></a>
    <div id="sat<?php echo $infr['id']; ?>"style="display: none;" >
            <?php if(!empty($infr['txt'])):
     echo $infr['txt'];
            endif; ?>
    </div>
    
<script type="text/javascript">
$(document).ready(function(){//
    $('#rjd<?php echo $infr['id']; ?>').hide();
    
    $('#acp<?php echo $infr['id']; ?>').click(function(){
    var acp=$('#acp<?php echo $infr['id']; ?>').val();
    $('color<?php echo $infr['id']; ?>').css('background-color','green');
        $.ajax({
        type: "POST",
        url: "/cabinet/loych",
        data: { acp: acp },
        success: function(html){           
            var inr=html;
            $('#res').html(inr);
        } }); return false; }); 
        
        $('#rjc<?php echo $infr['id']; ?>').click(function(){
            $('#rjd<?php echo $infr['id']; ?>').show(); });
        
        $('#rj<?php echo $infr['id']; ?>').click(function(){
    var rj= $('#rj<?php echo $infr['id']; ?>').val();
    var des=$('#dsc<?php echo $infr['id']; ?>').val();
        $.ajax({
        type: "POST",
        url: "/cabinet/loych/",
        data: { 
            rj:  rj ,
            des: des
        },
        success: function(html){           
            var inr=html;
            $('#ac<?php echo $infr['id']; ?>').html(inr);
        } }); return false; }); 
        });
</script>
    
<br>
<?php endforeach;

endif; ?>
</form>
</div>

</div>

<?php 
