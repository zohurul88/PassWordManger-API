<?php
namespace App;

use \Firebase\JWT\JWT;

class JsonWT
{
    public static function encode(array $data, string $key = null)
    {
        $key = \is_null($key) ? \Flight::config()->jwt_key : $key;
        $data['created_at'] = time();
        $data['uri'] = \Flight::config()->domain_sign;
        return JWT::encode($data, $key);
    }

    public static function decode(string $token, string $key = null)
    {
        $key = \is_null($key) ? \Flight::config()->jwt_key : $key;
        try {
            $jwt = JWT::decode($token, $key, array('HS256'));
        } catch (\UnexpectedValueException $ex) {
            return 0;
        } catch (\DomainException $ex) {
            return 0;
        } catch (\InvalidArgumentException $ex) {
            return 0;
        }
        if (isset($jwt->expired_at) && time() > $jwt->expired_at) {
            return -1;
        }
        if (isset($jwt->uri) && $jwt->uri !== \Flight::config()->domain_sign) {
            return 0;
        }
        return $jwt;
    }

}
