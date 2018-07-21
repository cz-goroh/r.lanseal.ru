<?php 
//$uri= str_replace('_', '/', $arg);
$exarg= explode('_', $arg);
if($exarg[0]==='plan'):
include_once ROOT.'/views/base/header.php';  
?>
<div class="grey-block" style="max-width: 40%; max-height: 40%;" id="reg_wind">
<div  id="incom">
    <!--<a href="/" style="text-decoration: none;"><img src="/views/img/blue_st.png" /></a>-->
    <h2>Вход</h2>
    <?php echo User::wiyn()['namestr'];  ?>
</div></div>
<script>
    $(document).ready(function(){
    $('#incom').show();
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
                    var url = "/cabinet/clientrcab/media_<?php echo $exarg[1]; ?>";
                    $(location).attr('href',url);
                }
            } }); return false; });});
</script>
<?php endif; ?>