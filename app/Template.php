<?php
namespace App;

class Template
{
    /**
     * Undocumented function
     *
     * @param array $data
     * @param string $file
     * @return void
     */
    public static function load(array $data = [], string $file = "")
    {
        $filename = self::_fetchFileName($file);
        if (is_null($filename)) {
            $response["errors"]["message"] = "Template not found.";
            \Flight::json($response, 404);
        }
        extract($data);
        $config = \Flight::config();
        include $filename;
        die;
    }

    /**
     * Undocumented function
     *
     * @param string $file
     * @return void
     */
    private static function _fetchFileName(string $file)
    {
        return !is_null($file) && file_exists($file) ? $file : self::findFormBacktrace($file);
    }

    /**
     * Undocumented function
     *
     * @param string $file
     * @return void
     */
    private static function findFormBacktrace(string $file = '')
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS) ?? null;
        $dir = $file = '';

        if (isset($backtrace[2]['file'])) {
            $dir = dirname($backtrace[2]['file']);
        }
        $method_name = '';
        if (!empty($file)) {
            $method_name = $file;
        } else if (isset($backtrace[3]['function'])) {
            $method_name = self::uncamelize(substr($backtrace[3]['function'], 1));
        }
        if (!empty($dir) && !empty($method_name)) {
            $filename = $dir . '/../views/' . $method_name . '.php';
            if (file_exists($filename)) {
                return $filename;
            }
        }
        return null;
    }
    private static function uncamelize($camel, $splitter = "-")
    {
        $camel = preg_replace('/(?!^)[[:upper:]][[:lower:]]/', '$0', preg_replace('/(?!^)[[:upper:]]+/', $splitter . '$0', $camel));
        return strtolower($camel);
    }
}
