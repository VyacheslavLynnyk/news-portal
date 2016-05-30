<?php
class Session
{
    protected static $flash_message;

    public static function setFlash($messsage)
    {
        self::$flash_message = $messsage;
    }

    public static function flash()
    {
        echo self::$flash_message;
        self::$flash_message = null;
    }

    public static function hasFlash()
    {
        return isset(self::$flash_message);
    }

    public static function saveData($name, $data)
    {
        $_SESSION['saved_data'][$name] = $data;
    }

    public static function getData($name)
    {
        if (isset($_SESSION['saved_data'][$name])) {
            return $_SESSION['saved_data'][$name];
        } else {
            return false;
        }
    }
}