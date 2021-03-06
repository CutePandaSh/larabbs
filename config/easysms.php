<?php

return [
    'timeout' => 10.0,

    'default' => [
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

        'gateways' => [
            'aliyun',
        ],
    ],

    'gateways' => [
        'errorlog' => [
            'file' => '/tmp/easy-sms.log',
        ],
        'aliyun' => [
            'access_key_id' => env('SMS_ALIYUN_ACCESS_KEY_ID'),
            'access_key_secret' => env('SMS_ALIYUN_ACCESS_KEY_SECRET'),
            'sign_name' => 'LarabbsDemo',
            'templates' => [
                'register' => env('SMS_ALIYUN_TEMPLATE_REGISTER'),
            ],
        ],
    ],
];
