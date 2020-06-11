<?php

namespace backend\modules\base\controllers;

use backend\modules\base\models\AuthItemModel;
use backend\modules\base\models\Entity\AuthItem;
use backend\modules\base\models\Entity\Notify;
use backend\modules\base\models\Entity\Profile;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class NotifyController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [

                    [
                        'allow' => true,
                        'actions' => [
                            'index',
                        ],
                        'roles' => ['visitor'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'auth',
                        ],
                        'roles' => ['moderator'],
                    ],
                ],
            ]
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    public function actionIndex()
    {
        //получить 5 последних уведомлений
        $user_id = Yii::$app->user->getId();
        $notify = Notify::GetNotify($user_id);

        $txt = '';
        foreach ($notify as $item) {
            switch ($item->view){
                case 'auth':
                    $txt .= Yii::$app->runAction('base/notify/auth', [
                        'params' => $item->params,
                    ]);
                    break;
            }
        }
        if(empty($txt))$txt = 'Новых уведомлений нет!';
        return $txt;
    }

    /**
     * подтверждение регистрации
     * @param $params
     * @return string
     */
    public function actionAuth($params)
    {
        $params = json_decode($params,true);
        //справочник ролей
        $dic_auth_item = AuthItemModel::GetDicAuthItem();
        $dic_auth_item = ArrayHelper::map($dic_auth_item, "id", "name");
        //имя регистрируемого
        $invited_p = Profile::GetProfile($params['invited']);
        $invited_fio = $invited_p->last_name . " " . $invited_p->first_name . " " . $invited_p->middle_name;
        return $this->renderAjax('auth',[
            'invited_id'    => $invited_p->user_id,
            'dic_auth_item' => $dic_auth_item,
            'invited_fio'   => $invited_fio,
        ]);
    }
}
