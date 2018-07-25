<!--регистрация пользователей-->
<!--форма входа-->
<!--<a href="#" >Я забыл пароль</a>
    восстановление пароля
    <div id="rest" >
    <input type="email" name="restore_mail" id="restore_mail" placeholder="Введите ваш email" />
    <br><button name="restore_pass" id="restore_pass" value="1" >Сбросить пароль</button>
    <br>На Ваш email будет отправлено сообщение с новым паролем
    </div>-->
<!--<form method="post" action="#">
    <input type="email" name="login" id="login" placeholder="Email"/>
    <input type="password" name="password" id="password" placeholder="password"/>
    <button name="income" type="button" value="1" >Войти</button>
</form>-->
<!--форма регистрации-->
<!--<link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,700|Neucha&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet">-->
<?php if(empty($_SESSION['ush'])): ?>
<!--<div style="font-size: 5em">Работы на сервере</div>--> 
<div id="logo"><img src="/views/img/nrs-logo.png"></div>

<div id="zagolovok"> Национальная Радио Сеть</div>
<div id="descript">Онлайн сервис по планированию и размещению рекламы на любой
    радиостанции России. Прочтите<a id="instr-h" href="/blog/instruction"> иструкцию.</a></div>
<div class="grey-block"   id="reg_wind">
    <div id="first">
        <h2>Войдите или зарегистрируйтесь</h2><br><br><br><br><br>
<button id="let-inc" type="button" class="pink-but width-20">Войти</button><br>
<button id="let-reg" type="button" class="pink-but width-20">Зарегистрироваться</button>
    </div>
    
<div  id="incom">
    <a href="/" style="text-decoration: none;"><img src="/views/img/blue_st.png" /></a>
    <h2>Вход</h2>
    <?php echo User::wiyn()['namestr'];  ?>
</div>

<div id="reg">
    <!--<a href="/" style="text-decoration: none;">&#8656</a>-->
    <a href="/" style="text-decoration: none;"><img src="/views/img/blue_st.png" /></a>
<h2>Регистрация</h2>
<!--<span id="test"></span>-->
    <input name="r_mail" id="r_mail" type="email" placeholder="Ваш Email" required />
    <br><br>
    <span id="span_snd_code">
    <button name="snd_code" value="1" id="snd_code" class="red-but">Отправить</button>
    </span>
    <br>
    <div style="margin-top: 10px;" id="em_mes">На Ваш Email будет отправлен код подтверждения</div>
    <div id="rep_email" style="color: red;"></div>
</div>
    <div id="code_res">
        <p>Код отправлен на Ваш Email, проверьте почтовый ящик</p>
        <input name="conf_code" id="conf_code" type="text" placeholder="Код из письма" required />
        <button value="1" name="chk_cod" id="chk_code">Проверить</button>
    
    </div>
        <div id="chk_code_res" ></div>
        <div id="rol_block">
            
            <br>Ваша роль: 
            <input type="radio" name="rol" id="rekl" value="rekl" checked/>Рекламодатель
            <input type="radio" name="rol" id="radio_man" value="radio_man" />Менеджер
            радиостанции
        </div>
    
    <div id="radio_inf">
        <form action="/signup/registration/form" method="post" >
        <!--информация о радиостанции-->
        
        <br>
        <input type="password" name="new_pass" id="new_pass_r"
               placeholder="Придумайте пароль(минимум 8 символов)" required
               class="width-20" >
        <div id="lntp_r"></div>
        <input type="password" name="new_reppass" id="new_reppass_r"
               placeholder="Повторите придуманный Вами пароль" required 
               class="width-20"/>
        <div id="rpass_r"></div>
        <input type="hidden" name="r_mail_r"  id="r_mail_r" 
               class="width-20"/>
        
        <br><input name="radio_surname" id="radio_surname" type="text" 
               placeholder="Фамилия" required class="width-20" />
        <br><input name="radio_name" id="radio_name" type="text"
               placeholder="Имя"  required class="width-20" />
        <br><input name="radio_otch" id="radio_otch" type="text"
                   placeholder="Отчество"  required class="width-20"/>
        <br><input name="radio_position" id="radio_position" type="text" 
                   placeholder="Должность"  required class="width-20"/>
        <br><input name="radio_inn" id="radio_inn" type="text" 
                   placeholder="ИНН" required  class="width-20"/>
        <div id="radio_inn_res" ></div>
        
        
        <br><input name="radio_adr" id="radio_adrs" type="text" 
                   placeholder="Адрес"  class="adrs width-20" required />
        <br><input name="radio_phone" id="radio_phone" type="tel"  
                   placeholder="Телефон"  required class="width-20 phone" />
        <br><input name="radio_nm" id="radio_nm" type="text"
                   placeholder="Название станции"  required class="width-20"/>
        <span id="sndrinf">
            <button type="submit" name="send_radioinf" id="send_radioinf"
                value="send_radioinf" class="width-20 red-but snd_reg" >
                Зарегистрировать радиостанцию</button>
        </span>
        </form>
    </div>
    
    
    <div id="rekl_inf">
        <!-- информация о рекламодателе -->  
        <form action="/signup/registration/form" method="post" >
            
        <br>
        <input type="password" name="new_pass" id="new_pass_c"  required 
               class="width-20"
               placeholder="Придумайте пароль(минимум 8 символов)"/>
        <div id="lntp_c"></div>
        <input type="password" name="new_reppass" id="new_reppass_c" required  
               class="width-20"
               placeholder="Повторите придуманный Вами пароль"/>
        <div id="rpass_c"></div>
        <input type="hidden" name="r_mail_c" id="r_mail_c" />
        
    <br><input name="rekl_surname" id="rekl_surname" type="text" 
               placeholder="Фамилия"  required class="width-20"/>
        <br><input name="rekl_name" id="rekl_name" type="text"
               placeholder="Имя" required class="width-20"/>
        <br><input name="rekl_otch" id="rekl_otch" type="text"
                   placeholder="Отчество"  required class="width-20"/>
        <br><input name="rekl_position" id="rekl_position" type="text" 
                   placeholder="Должность" required class="width-20" />
        <br><input name="rekl_inn" id="rekl_inn" type="text" 
                   placeholder="ИНН" required class="width-20" />
        <div id="rekl_inn_res" ></div>
        
        <br><input name="rekl_adr" id="rekl_adrs" type="text" 
                   placeholder="Адрес"  class="adrs width-20"  required />
        <br><input name="rekl_phone" id="rekl_phone" type="tel"
                   class="phone width-20" placeholder="Телефон" required  />
        <br><button name="send_reklinf" type="submit" id="send_reklinf"
                    value="send_reklinf" class="width-20 red-but snd_reg" >
            Зарегистрировать рекламодателя</button>
        </form>
    </div>
</form>
</div>
<button type="button" id="instruction"  >
    <a href="/blog/instruction" id="instr-a" target="_blank" >
        Инструкция по эксплуатации
</a></button>
<script type="text/javascript">
$(".city").suggestions({
    token: "2ae95ed1cef9323717fbc91c75aa0904c7a4cdeb",
    type: "ADDRESS",
    hint: false,
    bounds: "city",
    constraints: {
        label: "",
        locations: { city_type_full: "город" }
    },
    /* Вызывается, когда пользователь выбирает одну из подсказок */
    onSelect: function(suggestion) {
        console.log(suggestion);
    }
});
$(".region").suggestions({
    token: "2ae95ed1cef9323717fbc91c75aa0904c7a4cdeb",
    type: "ADDRESS",
    hint: false,
    bounds: "region",
    constraints: {
        label: "",
        locations: { city_type_full: "город" }
    },
    /* Вызывается, когда пользователь выбирает одну из подсказок */
    onSelect: function(suggestion) {
        console.log(suggestion);
    }
});
$(".adrs").suggestions({
token: "2ae95ed1cef9323717fbc91c75aa0904c7a4cdeb",
type: "ADDRESS",
count: 5,
/* Вызывается, когда пользователь выбирает одну из подсказок */
onSelect: function(suggestion) {
console.log(suggestion);
}
});
</script>
<?php endif; ?>
<!--<button id="jsn" type="button">jsn</button>-->
<!--<span id="test1"></span>
<span id="test2"></span>
<span id="test3"></span>
<span id="test4"></span>
<div id="t"></div>-->

<?php
//    $('#income').click(function(){                     //проверка кода
//    var login=     $('#login').val();
//    var password=  $('#password').val();
//    
//    $.ajax({
//        type: "POST",
//        url: "/signup/registration/",
//        data: { 
//            login:  login,
//            password: password
//        },
//        success: function(html){           
//            var inr=html;
//           // $('#wrong_pass').html('неверное сочетание логин-пароль');
//            $('#wrong_pass').html(inr);    
//            if(inr !=='wrong'){                
//                $('#wrong_pass').text(inr);  
//            }
//            if(inr ==='wrong'){
//                $('#wrong_pass').html('неверное сочетание логин-пароль');
//            }
//        }
//    });
//    return false;    
//    });