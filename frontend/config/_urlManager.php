<?php
return [
    'class'=>'yii\web\UrlManager',
    'enablePrettyUrl'=>true,
    'enableStrictParsing' => true,
    'showScriptName'=>false,
    'rules' => [
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/default', 'only' => ['index']],
    ],
];