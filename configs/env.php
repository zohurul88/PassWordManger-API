<?php
return [
    'development' => [
        'db' => [
            'hostname' => 'localhost',
            'username' => 'root',
            'password' => '123456',
            'database' => 'pass_mng',
        ],
        'base_url' => 'http://api2.portwallet.local/v1',
        'jwt_key' => '1234',
        'auth_expire' => (60 * 60 * 24 * 30),
        'code_expire' => (30 * 24 * 60 * 60),
        'access_expire' => (30 * 24 * 60 * 60),
        'refresh_expire' => (12 * 30 * 24 * 60 * 60),
        'myaccount_url' => 'http://myaccount.portwallet.local/grant-permission',
        'domain_sign' => '7ebd688f3c9',
        'secret_allow_time' => (60 * 60 * 7),
    ],
    'sandbox' => [
        'db' => [
            'hostname' => '128.199.251.14',
            'username' => 'oauth',
            'password' => 'Z3bhK@63jF47spSRz',
            'database' => 'sandbox',
        ],
        'base_url' => 'https://api-sandbox.portwallet.com/oauth2/v1',
        'jwt_key' => 'BD3687_F38tA4DzD0DC60DFs11*-5%SC0EFF6L3136^C9M09948AC4AA*9E6-421d4F79821764C466750B',
        'auth_expire' => (60 * 60 * 24),
        'code_expire' => (2 * 60),
        'access_expire' => (30 * 24 * 60 * 60),
        'refresh_expire' => (6 * 30 * 24 * 60 * 60),
        'myaccount_url' => 'https://myaccount-sandbox.portwallet.com/grant-permission',
        'domain_sign' => '1d5e003acf0',
        'secret_allow_time' => (60 * 3),
    ],
    'production' => [
        'db' => [
            'hostname' => '192.168.2.212',
            'username' => 'portwallet_live',
            'password' => 't9XzUFBy3ZbTyd4N',
            'database' => 'portwallet_local',
        ],
        'base_url' => 'http://api2.portwallet.com',
        'jwt_key' => '600dF1043449FF3-4D18C-AB98C104S3776t1A10zCs663E5D944DL978DADM8CEC65B^%6A_*672F296F*2',
        'auth_expire' => (60 * 10),
        'code_expire' => (2 * 60),
        'access_expire' => (30 * 24 * 60 * 60),
        'refresh_expire' => (30 * 24 * 60 * 60),
        'myaccount_url' => 'http://myaccount.portwallet.com',
        'domain_sign' => '15b2ee3baa7',
        'secret_allow_time' => (60 * 1),
    ],
];

//tH58,pnCxP(^TL7=c2J!+MwU}#-Q%d\A<j?@hB>ZsgqF:G;`
