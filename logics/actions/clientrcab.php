<?php 
$expl_arg= explode('_', $arg);
//echo $expl_arg;

if(is_numeric($arg) || empty($arg)){
    include ROOT.'/views/header.php';  
    include ROOT.'/views/cabinet/rekl_cab_v.php';
}elseif ($arg==='plan') {
    include_once ROOT.'/views/header.php';  
    include ROOT.'/views/rekl/rekl_plan.php'; //вставка плана-заявки устаревший вариант
}
if($expl_arg[0]==='media'){
    $mediakey=$expl_arg[1];
    $mediaar=$r_str[$mediakey];
    unset($r_str);
    $r_str[$mediakey]=$mediaar;//оставляем в массиве только один элемент
    include_once ROOT.'/views/header.php';  
    include ROOT.'/views/rekl/rekl_plan.php'; //вставка плана-заявки
}
if($expl_arg[0]==='planstack'){
//    print_r($_SESSION['rad_stack_arr']);
    $keys = array_keys($_SESSION['rad_stack_arr']);
//    print_r($keys);
    $mediakey= $_SESSION['rad_stack_arr'][$keys[0]];//array_shift($_SESSION['rad_stack_arr']);
    if(!empty($mediakey)){
        $mediaar=$r_str[$mediakey];
        unset($r_str);
        $r_str[$mediakey]=$mediaar;//оставляем в массиве станций-структур только один элемент
        include_once ROOT.'/views/header.php';  
        include ROOT.'/views/rekl/rekl_plan.php'; //вставка плана-заявки
    }else{
        $_SESSION['snt']='Ваши заявки успешно отправлены менеджерам радиостанций, '
                . 'для отслеживания статуса откройте соответствующий медиаплан';
        
        header('Location: /cabinet/clientrcab/3');
    }
    
}