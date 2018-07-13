<?php

namespace frontend\modules\api\v1\controllers;

use yii\rest\Controller;

/**
 * Default controller for the `v1` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the api version
     * @return array
     */
    public function actionIndex()
    {
        return array('api' => 'v1');
    }
}
