<?php

$config = require BASEPATH . '/configs/__all__.php';
require BASEPATH . '/helpers/__all__.php';
$ns_controller = $config['config']['ns_controller'];
if (isset($config['routes'])) {
    foreach ($config['routes'] as $route => $func) {
        \Flight::route($route, array($ns_controller . '\\' . $func[0], $func[1]), true);
    }
}
\Flight::map('config', function () {
    global $config;
    $environment = false;
    if (isset($config['env'][ENVIRONMENT])) {
        $environment = $config['env'][ENVIRONMENT] ?? false;
        unset($config['env']);
        $config = array_merge($config['config'], $environment);
    }
    return (object) $config;
});

\Flight::map('db', function () {
    $db_config = \Flight::config()->db;
    $config = array(
        'driver' => 'mysql',
        'host' => $db_config['hostname'],
        'database' => $db_config['database'],
        'username' => $db_config['username'],
        'password' => $db_config['password'],
        'charset' => 'utf8',
        'options' => array(
            PDO::ATTR_PERSISTENT => true,
        ),
    );
    try {
        $connection = new \Pixie\Connection('mysql', $config);
        return new \Pixie\QueryBuilder\QueryBuilderHandler($connection);
    } catch (\Exception $e) {
        \Flight::jsonResponse(array('error' => array('code' => 2003, 'description' => 'Wrong DB connection!')), 500);
    }
    die;
});

//Mappings.
\Flight::map('notFound', function () {
    $response["status"] = "failed";
    $response["errors"]["message"] = "Not Found";
    \Flight::jsonResponse($response, 404);
});
\Flight::map('jsonResponse', function ($data, $code = 200) {
    \Flight::json($data, $code);
    die;
});
