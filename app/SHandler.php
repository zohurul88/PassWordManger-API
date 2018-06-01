<?php
namespace App;

class SHandler
{
    /**
     * Undocumented function
     */
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    /**
     * Undocumented function
     *
     * @param [type] $name
     * @param [type] $value
     */
    public function __set($name, $value)
    {
        $this->setSession($name, $value);
    }
    /**
     * Undocumented function
     *
     * @param [type] $name
     * @return void
     */
    public function __get($name)
    {
        return $this->getSession($name);
    }
    /**
     * Undocumented function
     *
     * @param [type] $name
     * @param [type] $value
     * @return void
     */
    public function setSession($name, $value)
    {
        $_SESSION[$name] = $value;
    }
    /**
     * Undocumented function
     *
     * @param [type] $name
     * @return void
     */
    public function getSession($name)
    {
        return $_SESSION[$name] ?? false;
    }

    /**
     * Undocumented function
     *
     * @param [type] $name
     * @return void
     */
    public function getCookie($name)
    {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    }
}
