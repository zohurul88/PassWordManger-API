<?php
namespace Src\Platform\Models;

use Src\Platform\Models\Main;

class User extends Main
{
    protected static $name = 'users'; 

    /**
     * Undocumented function
     *
     * @param [type] $data
     * @return void
     */
    public static function push($data)
    {
        return \Flight::db()->table(self::$name)->insert($data);
    }

    public static function getByEmail($email){
        $result=parent::select(["id"])
        ->where("email",$email)
        ->limit(1)
        ->first();
        return empty($result) ? false : $result;
    }

}
