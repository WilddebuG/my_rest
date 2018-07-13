<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'modules' => [
        'api' => [
            'class' => 'frontend\modules\api\Module',
            'modules' => [
                'v1' => [
                    'class' => 'frontend\modules\api\v1\Module',
                ],
            ],
        ],
    ],
];
