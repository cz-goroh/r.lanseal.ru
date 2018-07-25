<?php
include_once  ROOT.'/views/header.php';
?>
<div class="layout">
    <div class="sidebar">
        <!--id="hidden_panel" -->
        <p class="a_style">
        <form method="post" action="/cabinet/admincab/search" >
            <input type="search" name="inns" placeholder="ИНН" />
            <button name="admsearch" type="submit" value="1" >&#128270</button>
        </form>
        </p>
        <p class="a_style"  id="a4"><br> Станции</p>
        <p class="a_style"  id="a1"><br> Счета</p>
        <p class="a_style"  id="a2"><br> Ролики</p>
        <p class="a_style"  id="a3"><br> Рекламодатели</p>
        <p class="a_style"  id="a5"><br> Настройки</p>
        <p class="a_style"  id="a6"><a style="color: inherit;" class="" href="/signup/logout">Выйти</a></p>
        
        
    </div>
    <div id="main-div" class="content" ></div>
</div>
<div id="content">
    <div id="d-5">
        
        <h4>Смена пароля</h4>
    Введите текущий пароль
    <input name="curr_pass" id="curr_pass" type="password" class="left-30"/>
    <br>Введите новый пароль
    <input name="new_pass" id="new_pass" type="password" class="left-30"/>
    <br>Повторите новый пароль
    <input name="new_reppass" id="new_reppass" type="password" class="left-30"/>
    <br><button name="change_pass" value="1" type="button" id="change_pass">
        Отправить</button><span id="res_pass" ></span>
    <script type="text/javascript">
    $(document).ready(function(){
        $('#change_pass').click(function(){
            var curr_pass=$('#curr_pass').val();
            var new_pass=$('#new_pass').val();
            var new_reppass=$('#new_reppass').val();
                $.ajax({
                type: "POST",
                url: "/cabinet/adminch",
                data: { 
                    curr_pass:   curr_pass ,
                    new_pass:    new_pass,
                    new_reppass: new_reppass,
                    change_pass: 1
                },
                beforeSend: function() { 
            $('#change_pass').attr('disabled',true);
            $('#change_pass').html('Отправляем');
        },
                success: function(html){           
                    var inr=html;
                    $('#res_pass').html(inr);
                    ('#change_pass').attr('disabled',false);
                } }); return false;    }); });</script>
    </div>
    <div id="d-1"><h1>Счета</h1>
    <?php
    if(!empty($shcarr)):
    foreach ($shcarr as $shc): 
        $sh_arr= unserialize($shc['sh_ser']);
        $rekv_sh= unserialize($sh_arr['rman_ser']);
        $file_way=ROOT.'/doc/plat_'.$shc['id'].'.pdf'; ?>
        <br> <mark><?php echo $shc['id']; ?>  от <?php echo $sh_arr['date_sh']; ?>
            <?php   echo $rekv_sh['fname']; ?>
        <a href="/cabinet/dnld/arhsh_<?php echo $shc['id']; ?>" 
           target="_blank"a>Скачать</a>
        <?php if($shc['status']==='bill'): ?>
            <?php if(!file_exists($file_way)): 
        else: echo 'платёжка отправлена';
        endif;
        
        endif;?>
        <?php if($shc['status']==='payd'): echo ' Оплачен'; endif; ?></mark>
    <?php endforeach;
    else:
        echo 'У Вас нет счетов';
    endif; ?>
    </div>
    
    <div id="d-2">
        <h1>Ролики</h1>
    <form method="post" action="/cabinet/adminch/">
<?php
foreach ($rolar as $rolkey=>$rolinf):
    if($rolinf['status']==='upl'):$rol_color='yellow';$rolst='Новый';         endif;
    if($rolinf['status']==='app'):$rol_color='green'; $rolst='Одобрен';       endif;
    if($rolinf['status']==='rej'):$rol_color='red';   $rolst='Отклонён';      endif;
    if($rolinf['status']==='red'):$rol_color='blue';  $rolst='Отредактирован';endif;
    ?>
    <div style="background-color:<?php echo $rol_color; ?>;">
    <?php echo $rolinf['id']; ?> 
    <?php echo $rolinf['name']; ?>
    Длительность <?php echo $rolinf['dlit']; ?> сек
    <audio controls style="background: blueviolet;">
        <source src="/audio/rolik_<?php echo $rolinf['id']; ?>.mp3" type="audio/mpeg">
        Прослушивание не поддерживается вашим браузером. 
        <a href="/audio/rolik_<?php echo $rolinf['id']; ?>.mp3">Скачайте музыку</a>
    </audio>
<button name="del_rol" value="<?php echo $rolinf['id']; ?>" type="submit">Удалить
</button>
    <textarea name="txt" id="txt<?php echo $rolinf['id']; ?>" ><?php 
        if(!empty($rolinf['txt'])): echo $rolinf['txt'];endif;
    ?></textarea>
    <button type="button" name="upd_txt<?php echo $rolinf['id']; ?>" 
            id="upd_txt<?php echo $rolinf['id']; ?>" >Обновить текст</button>
    <script type="text/javascript">
    $(document).ready(function(){
        $('#upd_txt<?php echo $rolinf['id']; ?>').click(function(){
            var n_txt=$('#txt<?php echo $rolinf['id']; ?>').val();
            $.ajax({
                type: "POST",
                url: "/cabinet/reclch",
                data: { 
                    n_txt: n_txt ,
                    txt: <?php echo $rolinf['id']; ?>
                }, 
                beforeSend: function() { 
                    $('#upd_txt<?php echo $rolinf['id']; ?>').attr('disabled',true);
                    
                },
                success: function(html){           
                    var inr=html;
                    $('#txt<?php echo $rolinf['id']; ?>').html(inr);
                    $('#upd_txt<?php echo $rolinf['id']; ?>').attr('disabled',false);
                    
                } }); return false; }); });
    </script>
<?php if($rolinf['status']==='rej'): ?>
    Требует доработки(<?php echo $rolinf['descr']; ?>)
    <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
    <input type="file" name="rolik" >(не более 30МБ)
    <button name="rolik_upd" type="submit" value="<?php echo $rolinf['id']; ?>"
            >Загрузить</button>
                <?php endif; ?></div><?php endforeach;  ?>
<!--<span id="testt"></span>-->
</form>
    </div>
    <div id="d-3">
        <h1>Рекламодатели</h1>
    <?php foreach ($rekl_inf as $rekk=>$rekl): 
    if(!empty($rekl['rekv'])):
        $rekstr=$rekl['rekv'];
        $rekv= unserialize($rekstr);
    endif;
    ?>
    <p>
    <mark><?php echo $rekl['id']; ?></mark>
    <?php echo $rekv['fname']; ?>
    ИНН <?php echo $rekv['inn']; ?>
    <a href="/cabinet/admincab/rekl_cab_<?php echo $rekl['id']; ?>">Обзор</a>
    </p>
    <?php endforeach; ?>
    </div>
    
    <div id="d-4">
        <h1>Станции</h1>
        <?php foreach ($r_maninf as $rekk=>$radio): 
    if(!empty($radio['rekv'])):
        $rekstr=$radio['rekv'];
        $rekvr= unserialize($rekstr);
    endif;
    ?>
    <p>
    <mark><?php echo $radio['id']; echo $radio['status']; ?></mark>
    <?php echo $rekvr['fname']; ?>
    ИНН <?php echo $rekvr['inn']; ?>
    <a href="/cabinet/admincab/rman_cab_<?php echo $radio['id']; ?>">Обзор</a>
    <form action="/cabinet/adminch/" method="post" style="display: inline;" >
        
    <?php if($radio['status']!=='del'): ?>
        <button name="sation_del" value="<?php echo $radio['id']; ?>" 
                type="submit">Удалить</button> 
    <?php else: ?>
        <button name="sation_ree" value="<?php echo $radio['id']; ?>" 
                type="submit">Восстановить</button> 
    <?php endif; ?>
    </form>
    
    </p>
    <?php endforeach; ?>
    </div>
    
    <div id="d-5">
        <h1>Заявки</h1>
        
        
    </div>
    
</div>