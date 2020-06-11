<?php

namespace backend\modules\base\controllers;

use backend\modules\base\models\Entity\Teg;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;

class TegController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
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

    //справочник "Клбчевые слова для поиска файлов"
    public function actionDicTegFile($count = null)
    {
        $param = [
            'count' => (!empty($count)) ? $count : 10,
            'option' => [10, 25, 50, 100],
        ];

        $query = Teg::GetQuery();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $param['count']]);

        $data = $query
            ->orderBy('id DESC')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('dic_teg_file', [
            'data' => $data,
            'param' => $param,
            'pages' => $pages,
        ]);
    }

    //удаление ключевых слов по id
    public function actionTegDelete($id)
    {
        $teg = Teg::findOne($id);
        $teg->delete();
        return true;
    }

    //удалить все ключевые слова
    public function actionDeleteAll()
    {
        Teg::deleteAll();
        return true;
    }
}