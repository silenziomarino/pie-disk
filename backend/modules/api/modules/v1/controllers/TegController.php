<?php namespace backend\modules\api\modules\v1\controllers;

use backend\modules\api\modules\v1\models\Teg;
use backend\modules\base\models\Entity\User;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class TegController extends ActiveController
{
    public $modelClass = Teg::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => function ($username, $password) {
                if ($user = User::findOne(['email' => $username]) and $user->validatePassword($password)) {
                    return $user;
                }
                return null;
            }
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['admin'],
                ],
            ],
        ];
        return $behaviors;
    }
}
