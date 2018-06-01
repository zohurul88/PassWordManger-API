<?php
namespace Src\Platform\Controllers;

use JsonSchema\Constraints\Constraint;
use JsonSchema\Validator as jsonValidator;
/**
 * Abstract Main class
 */
abstract class Main
{
    protected static $name = null;
    protected static $config = null;
    protected static $user_id = 0;
    protected static $app_id = 0;
    protected static $token_type = null;
    protected static $jwt = null;
    public static function __callStatic($method, $params)
    { 
        self::$config = \Flight::config();
        if (!is_null(static::$name) && method_exists(static::$name, "_{$method}")) {
            self::checkBearer(static::$name . '.' . $method, $params);
            array_unshift($params, \Flight::request());
            call_user_func_array(array(static::$name, "_{$method}"), $params);
        } else {
            \Flight::notFound();
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $callable
     * @param [type] $params
     * @return void
     */
    private static function checkBearer($callable, $params)
    {
        if (isset(self::$config->bearer_exclude) && \is_array(self::$config->bearer_exclude)) {
            $callable = \str_replace(self::$config->ns_controller . '\\', '', $callable);
            if (\in_array($callable, self::$config->bearer_exclude)) {
                return true;
            }
        }
        if ($info = bearer()->verify()) {
            self::$user_id = $info['user_id'];
            self::$app_id = $info['app_id'];
            self::$token_type = $info['type'];
            self::$jwt = $info['jwt'];
        } else {
            
            $response["status"] = "failed";
            $response["message"] = "Unauthorized access ";
            \Flight::jsonResponse($response, 401);
        }
    }
    /**
     * Undocumented function
     *
     * @param [type] $dataToValidate
     * @param [type] $name
     * @return void
     */
    protected static function jsonSchemaValidate(&$dataToValidate, $name)
    {
        $validator = new jsonValidator;
        $validator->validate($dataToValidate, (object) ['$ref' => 'file://' . realpath(__DIR__ . "/../Schema/" . $name . ".json")], Constraint::CHECK_MODE_APPLY_DEFAULTS);
        if (!$validator->isValid()) {
            \Flight::jsonResponse(self::commonError($validator->getErrors()), 400);
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $explanation
     * @return void
     */
    public static function commonError($explanation)
    {
        $response = [
            'error' => [
                'cause' => "INVALID_REQUEST",
                'explanation' => $explanation,
            ],
            'result' => 'ERROR',
        ];
        if (is_array($explanation)) {
            $response['error']['explanation'] = sprintf("%s field has error it's %s", $explanation[0]['property'], $explanation[0]['message']);
            $response['error']['property'] = $explanation[0]['property'];
        }
        return $response;
    }

}
