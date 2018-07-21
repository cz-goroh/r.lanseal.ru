<p><a href="/cabinet/admincab/">Обратно в кабинет</a></p>
<?php
//print_r($_SESSION);
if(empty($r_str)){
Rman::NRTab($id);
header('Location: /cabinet/r_mancab');
}
$rkar=unserialize($r_maninf[0]['rekv']);
include_once ROOT.'/views/header.php'; 
?>

<div class="layout"  > 
        
        <div class="sidebar">
        <p class="a_style">
            <h4>Радиостанция: <?php  echo $rkar['fname'];?></h4>
<?php if(file_exists(ROOT.'/logo/logo'.$id.'.jpeg')): ?>
<img src="/logo/logo<?php echo $id; ?>.jpeg" width="50px" />
 <?php else: ?><p><?php  echo 'Логотип не загружен'; ?> </p><?php  endif;?>
        </p>
        <p class="a_style"  id="a7"><br>Профиль радиостанции</p>
        <p class="a_style"  id="a4"><br>Реквизиты</p>
        <p class="a_style"  id="a1"><br>Счета</p>
        <p class="a_style"  id="a2"><br>Юристы</p>
        <p class="a_style"  id="a5"><br>Пики слушания</p>
        <p class="a_style"  id="a6"><br>Цены</p>
        <p class="a_style"  id="a3"><br>Медиаплан</p>
    </div>

    <div id="main-div" class="content"></div>
</div>
<div id="content" >
    <div  id="d-1" class="hide-div">
    <h4>Счета</h4>
      <?php foreach ($shcarr as $shc): 
            $sh_arr= unserialize($shc['sh_ser']);
            $rekv_sh= unserialize($sh_arr['rekl_ser']);
            ?>
        <br> <mark><?php echo $shc['id']; ?>
            <span id="stat<?php echo $shc['id']; ?>">
        <?php if($shc['status']==='bill'): echo ' Выставлен'; endif; ?>
        <?php if($shc['status']==='payd'): echo ' Оплачен'; endif; ?></span></mark>
        от
        <?php echo $sh_arr['date_sh']; ?>
        <?php   echo $rekv_sh['fname']; ?>
        <a href="/cabinet/dnld/arhsh_<?php echo $shc['id']; ?>" 
           target="_blank"a>Скачать</a>
        <?php $file_way=ROOT.'/doc/plat_'.$shc['id'].'.pdf';
        if(file_exists($file_way)):  ?>
        <a href="/cabinet/dnld/plat_<?php echo $shc['id']; ?>" 
           target="_blank"a>Скачать платёжку</a>
        <?php endif; ?><?php endforeach; ?>
        </div>

<div id="d-2" class="hide-div">
    <h1>Юристы</h1>
    <?php foreach ($loyar as $lk=>$linf): 
        $loy_usid=$linf['us_id'];
        $sellq="SELECT * FROM users WHERE `id`='$loy_usid'";
        $lus= Dbq::SelDb($sellq)[0];
//        print_r($lus);
        ?>
    <mark ><?php echo $linf['id'];  ?></mark>
    <form method="post" action="/cabinet/rmanch">
    <input name="loynm" type="text" value="<?php echo $lus['name']; ?>" />
           <input name="loysn" type="text" value="<?php echo $lus['surname']; ?>"/>
           <input name="loylogin" type="text" value="<?php echo $lus['login']; ?>"/>
           <input name="loytel" type="text" class="phone" value="<?php echo $lus['tel']; ?>"/>
           <input name="loypass" type="password" placeholder="новый пароль" />
           <button type="submit" name="upd_loy" value="<?php echo  $loy_usid ;?>">
               Обновить <?php echo $loy_usid; ?> </button>
    </form>
    <?php endforeach; ?>
    <h1>Новый юрист</h1>
    <form method="post" action="/cabinet/rmanch/">
        <input name="nm" type="text" placeholder="Имя" />
        <input name="sn" type="text" placeholder="Фамилия" />
        <input name="login" type="email" placeholder="Email" />
        <input name="tel" type="tel" placeholder="Телефон" class="phone" />
        <br><input name="pass" type="text" placeholder="Придумайте пароль" id="pass" />
        Повторите пароль:<input name="reppass" type="password" id="reppass" />
        <button name="new_loy" value="l" type="submit" >Создать</button>
    </form> 
</div>
    
<div id="d-7" class="hide-div" >
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
                    rad_change_pass: <?php echo $id; ?>
                },
                beforeSend: function() { 
            $('#change_pass').attr('disabled',true);
            $('#change_pass').html('Отправляем');
        },
                success: function(html){           
                    var inr=html;
                    $('#res_pass').html(inr);
                    ('#change_pass').attr('disabled',false);
                } }); return false;    }); });</script><br>
    ____________________________________________________________________________
<br><br>
    <form method="post" action="/cabinet/adminch/" enctype="multipart/form-data">
        <h4>Профиль радиостанции</h4>
<?php foreach ($user_inf as $usk=>$usinf): ?>
    <?php echo $usinf['login']; ?>
    <p><input name="name" type="text" class="left-30"
              value="<?php if(!empty($usinf['name'])){ echo $usinf['name'];} ?>" /></p>
    <p><input name="tel" type="text" class="left-30"
              value="<?php if(!empty($usinf['name'])){ echo $usinf['tel'];} ?>" /></p>
    
       <?php endforeach; ?>
    
    <p>Должность<input name="position" type="text"  class="left-30"
       value="<?php if(!empty($r_maninf[0]['position'])){ echo $r_maninf[0]['position'];} ?>" /> </p>
    
    <p>Регион<input name="region" type="text" class="left-30"
       value="<?php if(!empty($r_maninf[0]['region'])){ echo $r_maninf[0]['region'];} ?>" /></p>
    
    <p>Город<input name="city" type="text" class="left-30"
       value="<?php if(!empty($r_maninf[0]['city'])){ echo $r_maninf[0]['city'];} ?>" /> </p>
    
    <p>Адрес<input name="adrs" type="text" class="left-30"
       value="<?php if(!empty($r_maninf[0]['adrs'])){ echo $r_maninf[0]['adrs'];} ?>" /></p>
    
    <p>Новый файл логотипа<input name="logo" type="file" class="left-30"/></p>
    
    <p>Ссылки на соцсети:
    <textarea name="links"  class="left-30"><?php if(!empty($r_maninf[0]['links'])){ echo $r_maninf[0]['links'];}?></textarea><br><br></p>
    
    <p>Зона покрытия:
    <textarea name="zone"  class="left-30" ><?php if(!empty($r_maninf[0]['zone'])){ echo $r_maninf[0]['zone'];}?></textarea><br><br></p>
    
    <p>Ссылка на онлайн вещание
    <input name="site" type="text" value="<?php if(!empty($r_maninf[0]['site'])){
        echo $r_maninf[0]['site'];} ?>" class="left-30"/></p>
    
    <p>Email трафик менеджера
        <br>(на этот адрес будет отправляться медиаплан)
    <input name="trafik_mail" type="text" value="<?php if(!empty($r_maninf[0]['site'])){
        echo $r_maninf[0]['trafik_mail'];} ?>" class="left-30"/></p>
    
    <p>Интересы целевой аудитории
    <textarea name="aud_desc" class="left-30"><?php if(!empty($r_maninf[0]['aud_desc'])){ echo $r_maninf[0]['aud_desc'];} 
    ?></textarea><br><br></p>
    
    <p>Охват аудитории<input name="oxv_aud" type="text" class="left-30"
       value="<?php if(!empty($r_maninf[0]['oxv_aud'])){ echo $r_maninf[0]['oxv_aud'];} ?>"/></p>
    
    <p>Программное обеспечение эфира
    <?php if(!empty($r_maninf[0]['po_version'])){$poar= explode('%', $r_maninf[0]['po_version']);} ?>
    <select name="po" >
        <option value="Тракт" 
            <?php if(!empty($poar[0])&&$poar[0]==='Тракт'){ echo' selected ';} ?> 
                >Тракт</option>
        <option value="Digiton"
            <?php if(!empty($poar[0])&&$poar[0]==='Digiton'){ echo' selected ';} ?>
                >Digiton</option>
        <option value="Gold Power"
            <?php if(!empty($poar[0])&&$poar[0]==='Gold Power'){ echo' selected ';} ?>
                >Gold Power</option>
        <option value="Empire" 
            <?php if(!empty($poar[0])&&$poar[0]==='Empire'){ echo' selected ' ;}?>
                >Empire</option>
    </select></p>
    <p>
    <br>Версия: <input name="po_ver" type="text" class="left-30"
                   value="<?php if(!empty($poar[1])){ echo $poar[1];} ?>"/></p>
    <!--Тракт, Digiton, Gold Power, Empire-->
       <p><span class="prof_nam">Плательщик НДС</span><input name="nds" type="checkbox"
             <?php if($r_maninf[0]['nds']==='yes'){ echo 'checked';} ?> value="yes" /> </p>
    <br><button name="rad_profile_ch" value="<?php echo $id; ?>" type="submit">Обновить</button>
</form> 
    
    </div>

    
<div id="d-4" class="hide-div">
    <form method="post" action="/cabinet/adminch/" enctype="multipart/form-data">
<?php  
foreach ($r_maninf as $rk=>$rinf):
    $rekv= unserialize($rinf['rekv']);
?>
    <h4>Реквизиты</h4>
    <br>Название
    <input name="fname" type="text" 
           value="<?php if(!empty($rekv['fname'])){ echo $rekv['fname'];} ?>" />
    
    <br>ИНН
    <input name="inn" type="text" 
           value="<?php if(!empty($rekv['inn'])){ echo $rekv['inn'];} ?>" />    
    
    <br>КПП<input name="kpp" type="number" 
           value="<?php if(!empty($rekv['kpp'])){ echo $rekv['kpp'];}  ?>" />
    
    <br>ОГРН
    <input name="ogrn" type="text" 
           value="<?php if(!empty($rekv['ogrn'])){ echo $rekv['ogrn'];} ?>" />
    <br>Юр.Адрес
    <input name="jradr" type="text" 
           value="<?php if(!empty($rekv['jradr'])){ echo $rekv['jradr'];} ?>" />
    
    
    <br>РС
    <input name="rs" type="text" 
           value="<?php if(!empty($rekv['rs'])){ echo $rekv['rs'];} ?>" />
    <br>КС
    <input name="ks" type="text" 
           value="<?php if(!empty($rekv['ks'])){ echo $rekv['ks'];} ?>" />
    <br>БИК
    <input name="bik" type="text" 
           value="<?php if(!empty($rekv['bik'])){ echo $rekv['bik'];} ?>" />
    <br>Банк
    <input name="bank" type="text" 
           value="<?php if(!empty($rekv['bank'])){ echo $rekv['bank'];} ?>" />
    <button name="rad_rekv_ch" value="<?php echo $id; ?>" type="submit">Обновить</button>
    
    <?php endforeach; ?>
</form>

    </div>
    <?php include_once ROOT.'/views/rman/pic_tab.php';  ?>
</div>