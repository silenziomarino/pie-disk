<?php namespace backend\modules\api\modules\v1\controllers;

use backend\modules\api\modules\v1\models\TypeFile;
use backend\modules\base\models\Entity\User;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class TypeFileController extends ActiveController
{
    public $modelClass = TypeFile::class;

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
                    'actions' => [
                        'index',
                        'view',
                    ], 'roles' => ['visitor'],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'index',
                        'view',
                    ], 'roles' => ['moderator'],
                ],
                [
                    'allow' => true,
                    'roles' => ['admin'],
                ],
            ],
        ];
        return $behaviors;
    }
}
