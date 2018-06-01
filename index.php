<?php

date_default_timezone_set("Asia/Dhaka");
set_time_limit(180);
error_reporting(-1);
ini_set('display_errors', 1);

define("BASEPATH", __DIR__);
define("ENVIRONMENT", getenv("APPLICATION_ENV") ?? "production");

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/app/bootstrap.php';
\Flight::start();
