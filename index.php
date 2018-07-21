<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
session_start();
//$_SESSION['rol']='admin';
date_default_timezone_set('Europe/Moscow');
define('ROOT', '/var/www/html');

require_once(ROOT.'/components/autoload.php');
require_once(ROOT."/components/Router.php");
$new=new Router;

//print_r($new);

$new->routeselect();
//echo $arg;
//include_once (ROOT."/views/footer.php");
?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter49216990 = new Ya.Metrika2({
                    id:49216990,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/tag.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/49216990" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->