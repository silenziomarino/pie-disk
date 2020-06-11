<?php

namespace backend\modules\base\controllers;


use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\modules\base\models\Entity\Profile;
use backend\modules\base\models\FileForm;
use backend\modules\base\models\SearchFileModel;

class HomeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','search-index'],
                        'roles' => ['visitor'],
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $modelFileForm = new FileForm();//кнопка загрузить
        $model = new SearchFileModel();//фильтры поиска и список файлов

        //справочник пользователй
        $profile = new Profile();
        $dic_profile = $profile->GetDicProfile();
        $dic_profile = ArrayHelper::map($dic_profile,"id","name");

        //право на добавление документа
        $addDocRule = false;
        if (\Yii::$app->user->can('forModeroator')) {
            $addDocRule = true;
        }

        return $this->render('index',[
            'model'         => $model,
            'modelFileForm' => $modelFileForm,
            'dic_profile'   => $dic_profile,
            'addDocRule'    => $addDocRule,
        ]);
    }

    public function actionSearchIndex()
    {

        $param = [
            'count' => 10,
            'option' => [10, 25, 50, 100],
        ];
        $post = Yii::$app->request->post();

        $model = new SearchFileModel();//фильтры поиска и список файлов
        $model->load($post);
        $param['count'] = (!empty($post['count']))? $post['count']: $param['count'];

        $query = $model->GetQuery($param);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $param['count']]);

        $data = $query
            ->orderBy('f.id DESC')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $data = $model->DataSizeFormat($data);
        return $this->renderAjax('search_index',[
            'model' => $model,
            'param' => $param,
            'data'  => $data,
            'pages' => $pages,
        ]);
    }
}
