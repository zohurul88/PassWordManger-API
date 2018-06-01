<?php

/**
 * Undocumented function
 *
 * @param [type] $url
 * @param integer $http_code
 * @return void
 */
function redirect($url, $http_code = 301)
{
    $parse_url = parse_url($url); 
    if (isset($parse_url['scheme']) && isset($parse_url['host'])) {
        $base_url = '';
    } else {
        $base_url = \Flight::config()->base_url.'/';
    }
    $url = $base_url  . $url;
    header("Location: " . $url, false, $http_code);
    die;
}

/**
 * Undocumented function
 *
 * @return void
 */
function session()
{
    return new \App\SHandler();
}

function bearer(){
    return new \App\Bearer();
}
/**
 * Undocumented function
 *
 * @param [type] $assoc
 * @param [type] $key
 * @param [type] $value
 * @return void
 */
function makeKeyValuePair($assoc, $key, $value)
{
    if (!is_array($assoc) || empty($assoc)) {
        return false;
    }
    $keys = array_column($assoc, $key);
    $values = array_column($assoc, $value);
    return array_combine($keys, $values);
}
