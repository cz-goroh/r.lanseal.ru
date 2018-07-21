$(document).ready(function(){
    $('#incom').hide();
    $('#reg').hide();
    $('#code_res').hide();
    $('#radio_inf').hide();
    $('#rol_block').hide();
    $('#rekl_inf').hide();
    $('#send_radioinf').attr('disabled',true);
    
//    $('.snd_reg').click(function(){
//        $('body').html('<img src="/views/img/krutilka." />');
//    });
    
    $('#new_pass_c').blur(function(){ 
        var pass=$('#new_pass_c').val();
        var count=pass.length;
        $('#lntp_c').html(count);
                if(count<8){
                    $('#lntp_c').html('слишком короткий пароль');
                    $('#new_pass_c').css('border-color', 'red');
                    $('#send_reklinf').attr('disabled',true);  }
                if(count>=8){
                    $('#send_reklinf').attr('disabled',false);
                    $('#lntp_c').html('');
                    $('#new_pass_c').css('border-color', 'inherit'); } });
    $('#new_pass_r').blur(function(){ 
        var pass=$('#new_pass_r').val();
        var count=pass.length;
        $('#lntp_r').html(count);
                if(count<8){
                    $('#lntp_r').html('слишком короткий пароль(не менее 8 символов)');
                    $('#new_pass_r').css('border-color', 'red');
                    $('#send_radioinf').attr('disabled',true);  }
                if(count>=8){
                    $('#send_radioinf').attr('disabled',false);
                    $('#lntp_r').html('');
                    $('#new_pass_r').css('border-color', 'inherit'); } });
            
    $('#new_reppass_c').blur(function(){ 
        var pass1=$('#new_reppass_c').val();
        var pass2=$('#new_pass_c').val();
                if(pass1!==pass2){
                    $('#rpass_c').html('Пароли не совпадают');
                    $('#new_reppass_c').css('border-color', 'red');
                    $('#new_pass_c').css('border-color', 'red');
                    $('#send_reklinf').attr('disabled',true);
                }
                if(pass1===pass2){
                    $('#send_reklinf').attr('disabled',false);
                    $('#rpass_c').html('');
                    $('#new_reppass_c').css('border-color', 'inherit');
                    $('#new_pass_c').css('border-color', 'inherit');
                }
                  });
    $('#new_reppass_r').blur(function(){ 
        var pass1=$('#new_reppass_r').val();
        var pass2=$('#new_pass_r').val();
                if(pass1!==pass2){
                    $('#rpass_r').html('Пароли не совпадают');
                    $('#new_reppass_r').css('border-color', 'red');
                    $('#new_pass_r').css('border-color', 'red');
                    $('#send_radioinf').attr('disabled',true);
                }
                if(pass1===pass2){
                    $('#send_radioinf').attr('disabled',false);
                    $('#rpass_r').html('');
                    $('#new_reppass_r').css('border-color', 'inherit');
                    $('#new_pass_r').css('border-color', 'inherit');
                }
                  });
    $('#incomform').keypress(function(e) {
    if(e.which === 13) {
        var login=$('#login').val();
        var password=$('#password').val();
        $.ajax({
            type: "POST",
            url: "/signup/registration/",
            data: { 
                login:    login,
                password: password,
                income:   1
            },
            beforeSend: function() { 
                $('#income').html('Авторизация'); 
                $('#income').attr('disabled',true);
            },
            success: function(html){           
                var inr=html;
//                $('#wrong_pass').html(inr);
//                $('chk_code_res').html(inr);
                if(inr==='wrong'){
                    $('#login').css('border-color', 'red');
                    $('#password').css('border-color', 'red');
                    $('#wrong_pass').html('Неверное сочетание логин-пароль');
                    $('#income').attr('disabled',false);
                    $('#income').html('Войти'); 
                }
                if(inr!=='wrong'){
                    var url = "/";
                    $(location).attr('href',url);
                }
            } }); return false; };
    });
    
    $('#income').click(function(){                     //проверка кода
        var login=$('#login').val();
        var password=$('#password').val();
        $.ajax({
            type: "POST",
            url: "/signup/registration/",
            data: { 
                login:    login,
                password: password,
                income:   1
            },
            beforeSend: function() { 
                $('#income').html('Авторизация'); 
                $('#income').attr('disabled',true);
            },
            success: function(html){           
                var inr=html;
//                $('#wrong_pass').html(inr);
//                $('chk_code_res').html(inr);
                if(inr==='wrong'){
                    $('#login').css('border-color', 'red');
                    $('#password').css('border-color', 'red');
                    $('#wrong_pass').html('Неверное сочетание логин-пароль');
                    $('#income').attr('disabled',false);
                    $('#income').html('Войти'); 
                }
                if(inr!=='wrong'){
                    var url = "/";
                    $(location).attr('href',url);
                }
            } }); return false; });
    
    $('#let-inc').click(function(){
        $('#incom').show();
        $('#first').hide();
        
    });
    $('#let-reg').click(function(){
        $('#reg').show();
        $('#first').hide();
        
    });
    $('#radio_inn').blur(function(){ 
        var radio_inn=$('#radio_inn').val();
        $.ajax({
            type: "POST",
//            dataType: 'json',
            url: "/signup/registration/",
            data: { radio_inn_chk:  radio_inn },
            success: function(html){           
                var inr=html;
                if(inr==='emp'){
                    $('#radio_inn_res').html('Некорректный ИНН');
                    $('#radio_inn').css('border-color', 'red');
                    $('#send_radioinf').attr('disabled',true);
                }
                if(inr==='ok'){
                    $('#send_radioinf').attr('disabled',false);
                    $('#radio_inn_res').html('');
                    $('#radio_inn').css('border-color', 'inherit');
                }
                } }); return false; });
        
    $('#rekl_inn').blur(function(){ 
        var radio_inn=$('#rekl_inn').val();
        $.ajax({
            type: "POST",
//            dataType: 'json',
            url: "/signup/registration/",
            data: { radio_inn_chk:  radio_inn },
            success: function(html){           
                var inr=html;
                if(inr==='emp'){
                    $('#rekl_inn_res').html('Некорректный ИНН');
                    $('#rekl_inn').css('border-color', 'red');
                    $('#send_reklinf').attr('disabled',true);
                }
                if(inr==='ok'){
                    $('#send_reklinf').attr('disabled',false);
                    $('#rekl_inn_res').html('');
                    $('#rekl_inn').css('border-color', 'inherit');
                }
                } }); return false; });
        
    $('#chk_code').click(function(){                     //проверка кода
        var conf_code=$('#conf_code').val();
        $.ajax({
            type: "POST",
            url: "/signup/registration/",
            data: { conf_code:  conf_code },
            success: function(html){           
                var inr=html;
                $('chk_code_res').html(inr);
                if(inr==='ok'){
                    $('#rol_block').show();
                    $('#rekl_inf').show();
                            } } }); return false; });
    
    $('input:radio[name=rol]').on('change', function () {
        var rol= $('input[name=rol]:checked').val();
        if(rol==='radio_man'){
            $('#radio_inf').show();
            $('#rekl_inf').hide();
        }
        if(rol==='rekl'){
            $('#rekl_inf').show();
            $('#radio_inf').hide();
        }
    });

$('#chk_code').click(function(){                     //проверка кода
    var conf_code=$('#conf_code').val();   

    $.ajax({
        type: "POST",
        url: "/signup/registration/",
        data: { confs_code:  conf_code },
        success: function(html){           
            var inr=html;
            $('chk_code_res').html(inr);
            if(inr==='ok'){
                $('#rol_block').show();
                $('#rekl_inf').show(); } } }); return false; });

$('#snd_code').click(function(){            //отправка кода на почту
    var r_mail=$('#r_mail').val();  
    $('#r_mail_r').val(r_mail);
    $('#r_mail_c').val(r_mail);
    $('.grey-block').css('max-width','600px');
    $.ajax({
        type: "POST",
        url: "/signup/registration/",
        data: { rs_mail:  r_mail },
        beforeSend: function() {
            $('#snd_code').attr('disabled',true);
            $('#span_snd_code').html('Отправляем');
            $('#span_snd_code').css('background-color','#DB4C4C');
                $('#span_snd_code').css('padding','4px');
                $('#span_snd_code').css('margin','4px');
        },
        success: function(html){
            var inr=html;
            if(inr==='ok'){
                $('#code_res').show(); 
                $('#rep_email').hide();
                $('#em_mes').hide();
                $('#span_snd_code').html('Проверьте почту');
                
            }
            if(inr==='rep'){
                $('#rep_email').html('Такой Email уже существует, войдите в свою учётную запись');
                $('#em_mes').hide();
                $('#code_res').hide(); 
                $('#snd_code').attr('disabled',false);
                $('#snd_code').html('Отправить');
            }
            }});return false; }); 
});
            
jQuery(function($){   
    $(".phone").mask("+7(999) 999-9999");   
});
