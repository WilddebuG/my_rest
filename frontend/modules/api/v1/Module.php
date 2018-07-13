<?php

namespace frontend\modules\api\v1;

/**
 * v1 module definition class
 */
class Module extends \frontend\modules\api\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\api\v1\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
