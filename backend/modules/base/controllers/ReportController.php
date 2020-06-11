<?php

namespace backend\modules\base\controllers;

use backend\modules\base\models\StatisticModel;
use yii\filters\AccessControl;
use yii\web\Controller;

class ReportController extends Controller
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
                        ], 'roles' => ['moderator'],
                    ],
                ],
            ]
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    //страница отчетов
    public function actionIndex()
    {
        $disk = StatisticModel::GetTypeInfoSize();
        $timeline = StatisticModel::GetFileTimeLine();
        $activeUser = StatisticModel::GetActiveUser();
        return $this->render('index',[
            'disk' => $disk,
            'timeline' => $timeline,
            'activeUser' => $activeUser,
        ]);
    }
}