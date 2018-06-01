<?php
namespace Src\Platform\Models;

abstract class Main
{
    protected static $name;

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function db()
    {
        return \Flight::db();
    }

    /**
     * Undocumented function
     *
     * @param array $fields
     * @param string $name
     * @return void
     */
    public static function select(array $fields = [], string $name = null)
    {
        if (is_null($name)) {
            $name = static::$name;
        }
        $db = self::db()->table($name);
        return empty($fields) ? $db : $db->select($fields);
    }
}
