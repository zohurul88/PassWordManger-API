<?php
namespace Src\Platform\Controllers;

use Src\Platform\Models\User;

class Users extends Main
{
    protected static $name = __CLASS__;

    public static function _newUser($r)
    {
        $request = json_decode(json_encode($r->data->getData()));
        parent::jsonSchemaValidate($request, 'user-create');
        if (User::getByEmail($request->email)) {
            \Flight::jsonResponse(self::commonError(EMAIL_ALREADY_EXISTS), 400);
        }
        $data = [
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "password" => password_hash($request->password, CRYPT_BLOWFISH),
        ];
        $user_id = User::push($data);
        if ($user_id) {
            $data['id'] = $user_id;
            //sendGrid::sendEmail($data);
            self::responseForNewUser($data, 201);
        } else {
            \Flight::jsonResponse(self::commonError(EMAIL_ALREADY_EXISTS), 400);
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $data
     * @param integer $http_status
     * @return void
     */
    public static function responseForNewUser($data, $http_status = 200)
    {
        \Flight::jsonResponse([
            'result' => "success",
            "data" => [
                "id" => $data['id'],
                'email' => $data['email'],
                "attribute" => [
                    'name' => [
                        "first" => $data['first_name'],
                        'last' => $data['last_name'],
                    ],
                    'created' => date(DATE_RFC2822, time()),
                ],
            ],
        ], $http_status);
    }
}
