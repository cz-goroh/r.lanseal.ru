<h1>Результаты поиска</h1>

<?php
if(!empty($search_c)):
foreach ($search_c as $serinf): 
    $ssrek=$serinf['rekv'];
    $srekv= unserialize($ssrek);
    ?>
<mark><?php $serinf['id']; ?></mark>
<?php echo $srekv['fname']; ?>
<a href="/cabinet/admincab/rekl_cab_<?php echo $serinf['id']; ?>">Обзор</a>
<?php endforeach; 
elseif(!empty($search_r)): 
    foreach ($search_r as $serinf): 
    $ssrek=$serinf['rekv'];
    $srekv= unserialize($ssrek);
    ?>
<mark><?php $serinf['id']; ?></mark>
<?php echo $srekv['fname']; ?>
<a href="/cabinet/admincab/rman_cab_<?php echo $serinf['id']; ?>">Обзор</a>
<?php endforeach; else: ?>
<p>По Вашему запросу ничего</p>
<?php endif; ?>
<p><a href="/cabinet/admincab/">Обратно в кабинет</a></p>