<?php
namespace App;

class Bearer
{
    private $bearer = false;
    private $signature = false;
    private $keyExplode = false;
    public $verifySign = false;

    public function __construct()
    {
        $this->bearer = $_SERVER['HTTP_AUTHORIZATION'] ?? false;
        $this->signature = $_SERVER['HTTP_SIGNATURE'] ?? false;
        $this->init();
    }

    private function init()
    {
        if ($this->bearer) {
            $this->bearer = preg_replace('!\s+!', ' ', ucfirst($this->bearer));
            preg_match('/Bearer\s(\S+)/', $this->bearer, $matches);
            $this->bearer = $matches[1] ?? false;
        }
        if ($this->verifySign) {
            $this->signature = trim($this->signature);
        }
    }

    public function verify()
    {
        if (!$this->bearer) {
            return false;
        }

        if (!$this->bearer && $this->verifySign) {
            return false;
        }
        $token = JsonWT::decode($this->bearer);
        if (!\is_object($token)) {
            return false;
        }
        $key = $this->keyExplode = \explode(".", $token->key);
        if (!isset($key[0]) || !isset($key[2]) || !isset($key[3]) || !isset($key[5])) {
            return false;
        }
        $auth_id = $this->fetchClientId($token->key);
        if ($this->verifySign) {
            if (!$this->verifySignature($auth_id)) {
                return false;
            }
        }
        return [
            'user_id' => $this->fetchUserId($token->key),
            'app_id' => $auth_id,
            'type' => $token->type ?? null,
            'jwt' => $token,
        ];
    }

    private function fetchUserId()
    {
        $key = $this->keyExplode[0];
        $chain = $this->keyExplode[2];
        return ($key / $chain / 786);
    }

    private function fetchClientId()
    {
        $key = $this->keyExplode[3];
        $chain = $this->keyExplode[5];
        return ($key / $chain / 786);
    }

    private function verifySignature($auth_id)
    {
        $auth = \Flight::db()->table('api_auth')->select(['secret_key'])->where('id', $auth_id)->first();
        if ($auth) {
            $time = time();
            $secret_allow_time = @intval(\Flight::config()->secret_allow_time);
            $allowUpTo = ($time - $secret_allow_time);
            for ($time; $time >= $allowUpTo; $time--) {
                //\printf("%s->%s->%s<br/>",$time,md5($auth->secret_key . $time),\strtolower($this->signature));
                if (md5($auth->secret_key . $time) === \strtolower($this->signature)) {
                    return true;
                    break;
                }
            }
        } 
        \Flight::jsonResponse([
            'status'=>'failed',
            'message'=>'Invalid Signature'
        ],403);
    }

}
