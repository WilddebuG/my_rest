<?php
return [
    'class'=>'yii\web\UrlManager',
    'enablePrettyUrl'=>true,
    'enableStrictParsing' => true,
    'showScriptName'=>false,
    'rules' => [
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/default', 'only' => ['index']],
//        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/login'],
        'GET api/v1'=>'api/v1/default',
        'POST api/v1/login/login'=>'api/v1/login/login',
    ],
];