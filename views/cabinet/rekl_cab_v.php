
<div class="layout">
    <div class="sidebar">
        <!--id="hidden_panel" -->
        
            <a href="/" 
               style="font-size: 2em;  text-decoration: none;
               color: #FB3943; background-color:  #17222E">
                NRS-MEDIA</a>
        
        <span style="text-decoration: none;
               color: #FCFCFC; background-color:  #17222E"><?php echo $_SESSION['login']; ?></span>
        
        <p class="a_style"  id="a4"> Профиль</p>
        <p class="a_style"  id="a5"> Реквизиты</p>
        <p class="a_style"  id="a1"> Счета
        <?php if(!empty($sh_ind)): ?>
            <img 
                src="/views/img/voskl_znak.png" title="У Вас есть новые счета" />
            <?php endif; ?></p>
        <p class="a_style"  id="a2"> Ролики</p>
        <p class="a_style"  id="a3"> Радиостанции</p>
        <p class="a_style"  id="a6"> Мои заявки
        <?php if(!empty($attent_bid)): ?>
            <img src="/views/img/voskl_znak.png" title="Есть несогласованные заявки" />
            <?php endif; ?></p>
        <p class="a_style"  id="a7"> Настройки</p>
        <p class="a_style" >
            <a style="color: inherit;" class="" href="/signup/logout">Выйти</a></p>
    </div>
    <div id="main-div" class="content" ></div>
</div>
<div id="content">
    <div id="d-7" class="dc">
    <h1>Настройки</h1>
    <form method="post" action="/cabinet/reclch">
    <p><span class="prof_nam">Показывать недельную историю в медиаплане</span>
        <input name="ist" type="checkbox"
 <?php if(!empty($settings['ist'])&&$settings['ist']==='yes'){ echo 'checked';} ?> 
               value="yes" /> </p>
    
    <p><span class="prof_nam">Показывать всплывающие подсказки в медиаплане</span>
        <input name="bol" type="checkbox"
             <?php if(!empty($settings['bol'])&&$settings['bol']==='yes'){ echo 'checked';} ?>
               value="yes" /> </p>
    <button name="settings" type="submit" value="1">Обновить</button>
    </form>
</div>
<div id="d-6" class="dc"> 

    <h1 class="div-h">Мои заявки</h1>
    
<?php foreach ($sat_inf as $s_i=>$s_inf):  
     //print_r($s_inf);     echo '<br>';
    if(!empty($my_bidarr[$s_i])): ?>
    <div class="st-list">
       <?php echo $s_inf['st_nm']; ?>
    
    <a href="/cabinet/clientrcab/media_<?php echo $s_i; ?>" class="a-media" >Открыть Медиаплан</a>
       
       <a href="/cabinet/dnld/reklmedia_<?php echo $s_i; ?>" class="a-media"
          target="_blank" id="rekl_media<?php echo $s_i; ?>">Скачать медиаплан</a>
          <?php if(!empty($attent_bid[$s_i])): ?>
            <img src="/views/img/voskl_znak.png" title="Есть несогласованные заявки" />
            <?php endif; ?>
          
    </div>
<?php endif; endforeach; ?>

</div>
    
    <div  id="d-1" class="dc">
    <!--<div class="spoiler-head"></div>-->
    <h4>Счета</h4>
    <?php 
    if(!empty($sh_ind[$id])): ?>
<!--    <h1>Новые счета</h1>-->
    <?php foreach ($sat_inf as $id_rch=> $radio_i):
     if(!empty($sh_ind[$id][$id_rch])): ?>
    <p>Новый счёт от радиостанции <?php echo $radio_i['st_nm']; ?>
        <a href="/cabinet/dnld/shcet_<?php echo $id_rch.'_'.$id; ?>" 
           target="_blank" id="sh_dnld<?php echo $id_rch; ?>">
            Скачать счёт</a></p>
        <script>
            $(document).ready(function(){
                $('sh_dnld<?php echo $id_rch; ?>').click(function(){
                    $('sh_dnld<?php echo $id_rch; ?>').hide(); }); });
        </script>  <?php endif;endforeach;endif;
    if(!empty($shcarr)):
    foreach ($shcarr as $shc): 
        $sh_arr= unserialize($shc['sh_ser']);
        $rekv_sh= unserialize($sh_arr['rman_ser']);
        $file_way=ROOT.'/doc/plat_'.$shc['id'].'.pdf'; ?>
        <div class="st-list"><?php echo $shc['id']; ?>  от <?php echo $sh_arr['date_sh']; ?>
            <?php   echo $rekv_sh['fname']; ?>
            <a href="/cabinet/dnld/arhsh_<?php echo $shc['id']; ?>" class="a-media"
           target="_blank"a>Скачать</a>
        <?php if($shc['status']==='bill'): ?>
            <?php if(!file_exists($file_way)): ?>
        <form method="post" action="/cabinet/reclch/" enctype="multipart/form-data" >
            
            Загрузить платёжный документ(pdf)
            <input type="file" name="plat_<?php echo $shc['id']; ?>"  />
            <button name="plat" value="<?php echo $shc['id']; ?>" type="submit" class="green-but">
            Отправить платёжку                                         </button>
        </form>  <?php
        else: echo 'платёжка отправлена';
        endif;
        
        endif;?>
        <?php if($shc['status']==='payd'): echo ' Оплачен'; endif; ?></div>
    <?php endforeach;
    
    endif;
    if(empty($shcarr)&& empty($sh_ind)): echo 'У Вас нет счетов';    endif;
    ?> 
</div>


<div id="d-2" class="dc">
    <!--<div class="spoiler-head"></div>-->
    <h4 class="div-h">Ролики</h4>
<form method="post" action="/cabinet/reclch/" enctype="multipart/form-data" >
<?php
foreach ($rolar as $rolkey=>$rolinf): 
    error_reporting (E_ERROR);
    $info = getMP3data(ROOT.'/audio/rolik_'.$rolinf['id'].'.mp3');
    ini_set('display_errors',1);
    error_reporting(E_ALL); ?>
    <div class="st-list" >
    <span ><?php echo $rolinf['id']; ?> 
    <?php echo $rolinf['name']; ?>
    <?php echo $rolinf['dlit']; ?> сек </span>
    
    <?php
    $rolstat_arr= unserialize($rolinf['status']);
//    print_r($rolstat_arr);
    if(!empty($rolinf['status'])):
        $desc_arr= unserialize($rolinf['descr']);
    endif;
  if(array_key_exists('upl',$rolstat_arr)): $rol_color='yellow';$rolst='Новый'; endif;
  if(array_key_exists('app',$rolstat_arr)): ?>
    Одобрен для
    <?php foreach ($rolstat_arr['app'] as $rolapp_radio):   ?>
    <br> <?php echo Dbq::AtomSel('st_nm', 'sation', 'id', $rolapp_radio); ?>
    <?php endforeach;
        $rol_color='green'; $rolst='Одобрен';       endif;
  if(array_key_exists('rej',$rolstat_arr)):$rol_color='red';
        foreach ($rolstat_arr['rej'] as $rolds): ?>
    <br>Отклонён станцией
    <?php echo Dbq::AtomSel('st_nm', 'sation', 'id', $rolds); ?>
    (<?php echo $desc_arr[$rolds]; ?>)
    загрузить отредактированный ролик для использования на радиостанции 
    <?php echo Dbq::AtomSel('st_nm', 'sation', 'id', $rolds); ?>
    <br><textarea class="inp" name="redtxt" required >Вставьте текст ролика</textarea>
    <!--<input class="inp" type="hidden" name="MAX_FILE_SIZE" value="30000000" />-->
    <input class="inp" type="file" name="rolik" >(не более 30МБ)
    <button class="green-but" name="rolik_upd" type="submit" 
            value="<?php echo $rolinf['id']; ?>_<?php echo $rolds; ?>"
            >Загрузить</button>
    <?php
        endforeach;    
    endif;
  if(array_key_exists('red',$rolstat_arr)):
      $rol_color='blue'; 
    echo 'Отредактирован для станции '.$rolstat_arr['red'];endif;
    ?>
    <br><audio controls style="background: <?php echo $rol_color; ?>;">
        <source src="/audio/rolik_<?php echo $rolinf['id']; ?>.mp3" type="audio/mpeg">
        Прослушивание не поддерживается вашим браузером. 
        <a href="/audio/rolik_<?php echo $rolinf['id']; ?>.mp3">Скачайте музыку</a>
    </audio>
        <button class="green-but" name="del_rol" value="<?php echo $rolinf['id']; ?>" type="submit">Удалить
        </button>
        <textarea class="inp" name="txt<?php echo $rolinf['id']; ?>" 
                  id="txt<?php echo $rolinf['id']; ?>" >
                      <?php 
        if(!empty($rolinf['txt'])): echo $rolinf['txt'];endif; ?></textarea>
        <button class="green-but" type="button" name="upd_txt<?php echo $rolinf['id']; ?>" 
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
                    itxt: <?php echo $rolinf['id']; ?>
                }, 
                beforeSend: function() { 
                    $('#upd_txt<?php echo $rolinf['id']; ?>').attr('disabled',true);
                },
                success: function(html){           
                    var inr=html;
                    $('#txt<?php echo $rolinf['id']; ?>').html(inr);
                    $('#upd_txt<?php echo $rolinf['id']; ?>').attr('disabled',false);
                    
                } }); return false; }); });
    </script></div>
                    <?php 
    
//    print_r($info);
                    endforeach; ?>
<!--<span id="testt"></span>-->
</form>
    <h4 class="div-h">Загрузка рекламного ролика</h4>
<form enctype="multipart/form-data" action="/cabinet/reclch" method="post">
    <br><input class="inp" type="text"  name="rolik_nm" placeholder="введите имя ролика" required />
    <!--<br><input class="inp" name="dlit" type="number" placeholder="введите длительность, сек" required />-->
    
    <br><textarea class="inp" name="ntxt" required >Вставьте текст ролика</textarea>
    <br><input class="inp" type="hidden" name="MAX_FILE_SIZE" value="300000000" required />
    <br> <input  type="file" name="rolik" />(не более 30МБ) 
    <br><button class="green-but" name="rolik_upl" type="submit" value="rolik" >Загрузить</button>
</form></div>
<div id="d-3" class="dc">
    <h1 class="div-h">Радиостанции</h1>
    <?php if(!empty($_SESSION['snt'])): ?>
    <div class="snt_mes" > 
       <?php echo $_SESSION['snt']; unset($_SESSION['snt']); ?>
    </div>
      <?php  endif; ?>
    <form  method="post" action="#" >
        <input type="search" name="tag" placeholder="Аудитория" class="inp" >
        <button name="tags" value="t" type="submit" class="green-but" >Искать</button>
    </form>

    <!--<h1>Отметьте галочкой станции, на которых планируете разместить рекламу</h1>-->
    <div>
    <form method="post" action="/cabinet/reclch">
<?php
//include ROOT.'/views/rekl/rekl_plan.php'; //вставка плана-заявки
if(!empty($sat_inf)): 
     if(isset($_POST['tags'])): echo 'Выборка по запросу '.$post['tag']; endif; ?>
        <h1 class="div-h">Отметьте галочкой станции, на которых планируете разместить рекламу</h1>
<?php
foreach ($sat_inf as $satk=>$satc):
    $satusk=$satc['us_id'];
?>
        <div class="st-list"><input name="zaj_<?php echo $satk; ?>" type="checkbox" value="<?php echo $satk; ?>"/>
<a onclick="$('#sat<?php echo $satk; ?>').slideToggle('slow');"
   href="javascript://" class="media-slider">
              <?php echo $satc['st_nm']; ?> </a> 
            <a href="/cabinet/clientrcab/media_<?php echo $satk; ?>" class="a-media"
          >Открыть Медиаплан</a>
       <a href="/cabinet/dnld/reklmedia_<?php echo $satk; ?>" 
           target="_blank" id="rekl_media<?php echo $satk; ?>" class="a-media">
            Скачать Медиаплан</a>
       
       <?php if(!empty($attent_bid[$satk])): ?>
            <img src="/views/img/voskl_znak.png" title="Есть неувязки" />
            <?php endif; ?>
            <div id="sat<?php echo $satk; ?>" style="display: none;" class="st-cont">
        
        <?php // print_r($satuser); ?>
        <br>E-mail                             <?php echo $satuser[$satusk]['login']; ?>
        <br>Телефон                            <?php echo $satuser[$satusk]['tel']; ?>
        <br>Регион                             <?php echo $satc['region']; ?>
        <br>Город                              <?php echo $satc['city']; ?>
        <br>Ссылки на соцсети и онлайн вещание <?php echo $satc['links']; ?>
        <br>Зона охвата                        <?php echo $satc['zone']; ?>
        <br>Интересы целевой  аудитории        <?php echo $satc['aud_desc']; ?>
        <br>Охват аудитории                    <?php echo $satc['oxv_aud']; ?>
        <br>Сайт                               <?php echo $satc['site']; ?>
        
    </div></div>
<?php endforeach; ?>
        <button name="zaj_stek" type="submit" value="1" class="green-but" >Перейти к планированию</button>
    
    </form></div>
    <?php 
    
if(isset($_POST['tags'])): ?>
<a href="/cabinet/clientrcab/"> к полному списку радиостанций</a>
<?php endif; else:    ?>
<div style="text-align: center;"><mark><h2>По Вашему запросу ничего не найдено, 
            <a href="/cabinet/clientrcab/3"> вернуться к списку радиостанций</a></h2></mark>
    <image src="/views/img/kotenok.png" />   
        </div>
    <?php
endif; 
//phpinfo(); ?>

</div>
    
    
<div id="d-4" class="dc">
    <h4>Профиль</h4>
<form method="post" action="/cabinet/reclch/" enctype="multipart/form-data">
    <?php 
    $rkar=unserialize($rekl_inf[0]['rekv']);
    foreach ($user_inf as $usk=>$usinf):
    ?>
    <?php echo $usinf['login']; ?>
    <div class="prof_nam">Имя</div>
    <input name="name" type="text"  class="left-30"
                 value="<?php if(!empty($usinf['name'])): echo $usinf['name'];endif; ?>" />
    <div class="prof_nam">Телефон</div>
    <input name="tel" type="text" class="left-30"
                     value="<?php if(!empty($usinf['tel'])): echo $usinf['tel'];endif; ?>" />
    
    <div class="prof_nam">Регион</div>
    <input name="region" type="text" 
             class="left-30" value="<?php if(!empty($rekl_inf[0]['region'])){
                 echo $rekl_inf[0]['region'];} ?>" />
    
    <div class="prof_nam">Город</div>
    <input name="city" type="text"
             class="left-30" value="<?php if(!empty($rekl_inf[0]['city'])){
                 echo $rekl_inf[0]['city'];} ?>" />
    
    <div class="prof_nam">Адрес</div>
    <input name="adrs" type="text"
             class="left-30" value="<?php if(!empty($rekl_inf[0]['adrs'])){
                 echo $rekl_inf[0]['adrs'];} ?>" />
    
    <div class="prof_nam">Должность</div>
    <input name="position" type="text"
             class="left-30" value="<?php if(!empty($rekl_inf[0]['position'])){
                 echo $rekl_inf[0]['position'];} ?>" /> 
    <div class="prof_nam">ФИО</div>
    <input name="fio" type="text"
             class="left-30" value="<?php if(!empty($rekl_inf[0]['fio'])){
                 echo $rekl_inf[0]['fio'];} ?>" /> 
    <div class="prof_nam">Плательщик НДС
    <input name="nds" type="checkbox"
             <?php if($rekl_inf[0]['nds']==='yes'){ echo 'checked';} ?> value="yes" /> </div>
    <button name="profile_ch" value="<?php echo $id; ?>" type="submit">Обновить</button>
    
</form>
    ____________________________________________________________________________
<?php endforeach; 
 foreach ($rekl_inf as $rik=>$rinf):
     $rekv= unserialize($rinf['rekv']);
?>
    <h4>Смена пароля</h4>
    <input name="curr_pass" id="curr_pass" type="password" class="left-30 npas"
               placeholder="Введите текущий пароль"/>
    
        <input name="new_pass" id="new_pass" type="password" class="left-30 npas" 
               placeholder="Введите новый пароль"/>
    
        <input name="new_reppass" id="new_reppass" type="password" class="left-30 npas"
               placeholder="Повторите новый пароль"/>
    <button name="change_pass" value="1" type="button" id="change_pass">
            Отправить</button><span id="res_pass" >
    <script type="text/javascript">
                $(document).ready(function(){
                    $('#change_pass').click(function(){
                        var curr_pass=$('#curr_pass').val();
                        var new_pass=$('#new_pass').val();
                        var new_reppass=$('#new_reppass').val();
                            $.ajax({
                            type: "POST",
                            url: "/cabinet/reclch",
                            data: { 
                                curr_pass:   curr_pass ,
                                new_pass:    new_pass,
                                new_reppass: new_reppass,
                                change_pass: 1
                            },
                            beforeSend: function() { 
                                $('#change_pass').attr('disabled',true);
                    
                            },
                            success: function(html){           
                                var inr=html;
                                $('#res_pass').html(inr);
                            } }); return false;    }); });</script>
</div>
    <div id="d-5" class="dc">
   
<h4>Реквизиты</h4>

<form method="post" action="/cabinet/reclch/" enctype="multipart/form-data">
        <!--=====================================================================-->
    <div class="prof_nam">Название</div>
    <input name="fname" type="text" class="left-30"
           value="<?php if(!empty($rekv['fname'])){ echo $rekv['fname'];} ?>" />
    <div class="prof_nam">ИНН</div>
    <input name="inn" type="text" class="left-30"
           value="<?php if(!empty($rekv['inn'])){ echo $rekv['inn'];} ?>" /> 
    <div class="prof_nam">КПП</div>
        <input name="kpp" type="number" class="left-30"
                 value="<?php if(!empty($rekv['kpp'])){ echo $rekv['kpp'];}  ?>" />
    
    <div class="prof_nam">ОГРН</div>
    <input name="ogrn" type="text" class="left-30"
           value="<?php if(!empty($rekv['ogrn'])){ echo $rekv['ogrn'];} ?>" />
    <div class="prof_nam">Юр.Адрес</div>
    <input name="jradr" type="text" class="left-30"
           value="<?php if(!empty($rekv['jradr'])){ echo $rekv['jradr'];} ?>" />
     
    
    <div class="prof_nam">РС</div>
    <input name="rs" type="text" class="left-30"
           value="<?php if(!empty($rekv['rs'])){ echo $rekv['rs'];} ?>" />
    <div class="prof_nam">КС</div>
    <input name="ks" type="text" class="left-30"
           value="<?php if(!empty($rekv['ks'])){ echo $rekv['ks'];} ?>" />
    <div class="prof_nam">БИК</div>
    <input name="bik" type="text" class="left-30"
           value="<?php if(!empty($rekv['bik'])){ echo $rekv['bik'];} ?>" />
    <div class="prof_nam">Банк</div>
    <input name="bank" type="text" class="left-30"
           value="<?php if(!empty($rekv['bank'])){ echo $rekv['bank'];} ?>" />
<?php endforeach; ?>
    
    <p><button name="rekv_ch" value="<?php echo $id; ?>" type="submit">Обновить</button></p>
</form>
</div>
</div>


</body>
