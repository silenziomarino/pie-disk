<?php namespace backend\modules\api;

/**
 * Class Api
 * @package backend\modules\api
 */
class Api extends \yii\base\Module
{
    public function init()
    {
        parent::init();
        $this->modules = [
            'v1' => [
                'class' => 'backend\modules\api\modules\v1\ApiV1',
            ],
        ];
        $this->module->request->parsers = [
            'application/json' => 'yii\web\JsonParser',
            'asArray' => true,
        ];
        \Yii::$app->user->enableSession = false;
    }
}