<?php
return [
    'class'=>'yii\web\UrlManager',
    'enablePrettyUrl'=>true,
    'enableStrictParsing' => true,
    'showScriptName'=>false,
    'rules' => [
        'GET api/v1'=>'api/v1/default',
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/user', 'only' => ['index','update', 'view'], 'extraPatterns' => ['GET' => 'index',]],
        // Auth
        'POST api/v1/login/login'=>'api/v1/login/login',
        'GET api/v1/login/logout'=>'api/v1/login/logout',
    ],
];