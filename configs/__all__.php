<?php

$__config=[];
foreach (glob(BASEPATH."/configs/*.php") as $filename)
{
    if(__FILE__ === $filename){
        continue;
    }
    $__config[basename($filename,".php")] = require_once $filename;
}
return $__config;