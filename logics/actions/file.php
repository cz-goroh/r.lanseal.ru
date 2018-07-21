<?php

$exarg=explode('_', $arg);
if($exarg[0]==='rolik'){
    $rolik_id=$exarg[1];
    $file=ROOT.'/audio/rolik_'.$rolik_id.'.mp3';
    $fname=$arg;
    Secure::dnldFile($file,'rolik'.$fname.'.mp3');
}

