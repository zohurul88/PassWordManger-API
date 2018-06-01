<?php
 
foreach (glob(BASEPATH."/helpers/*.php") as $filename)
{
    if(__FILE__ === $filename){
        continue;
    }
    require_once $filename;
}