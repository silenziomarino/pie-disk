<?php namespace backend\modules\api\modules\v1\controllers;

use backend\modules\api\modules\v1\return_data\ApiReturnData;
use backend\modules\base\models\Entity\File;
use backend\modules\base\models\Entity\FileHistory;
use backend\modules\base\models\Entity\User;
use backend\modules\base\models\FileForm;
use backend\modules\base\models\SearchFileModel;
use phpDocumentor\Reflection\Types\Integer;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\Controller;
use yii\web\UploadedFile;

class FileController extends Controller
{
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
                    'roles' => ['moderator'],
                    'actions' => [
                        'create',
                    ],
                ],
                ['allow' => true, 'roles' => ['admin']],
            ],
        ];
        return $behaviors;
    }

    //список всех файлов
    public function actionIndex()
    {
        try {
            if (\Yii::$app->request->isGet) {
                $get = \Yii::$app->request->get();
                $param = [
                    'count' => 10,
                    'option' => [10, 25, 50, 100],
                ];
                $model = new SearchFileModel();
                $model->id = !empty($get['id']) ? $get['id'] : '';
                $model->file_name = !empty($get['file_name']) ? $get['file_name'] : '';

                $query = $model->GetQuery();
                $countQuery = clone $query;
                $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $param['count']]);

                $data = $query
                    ->orderBy('f.id DESC')
                    ->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();
                $data = $model->DataSizeFormat($data);
                return new ApiReturnData($data);
            }
        } catch (\Exception $e) {
            return new ApiReturnData([], ApiReturnData::ErrorEpicFail, $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return ApiReturnData
     */
    public function actionView($id)
    {
        try {
            $model = new SearchFileModel();
            $model->id = $id;
            $query = $model->GetQuery();
            $data = $query->all();
            return new ApiReturnData($data);
        } catch (\Exception $e) {
            return new ApiReturnData([], ApiReturnData::ErrorEpicFail, $e->getMessage());
        }
    }

    /**
     * Сохранение файлов
     * @return ApiReturnData
     */
    public function actionCreate()
    {

        try {
            $model = new FileForm(['scenario' => FileForm::FILE_CREATE]);
            if (Yii::$app->request->isPost) {
                $model->files = UploadedFile::getInstances($model, 'files');
                if ($model->validate()) {
                    $list = $model->create();//список id файлов в базе
                    if (!empty($list)) return new ApiReturnData(true);
                }
            }
        } catch (\Exception $e) {
            return new ApiReturnData([], ApiReturnData::ErrorEpicFail, $e->getMessage());
        }
    }

    //список файлов текущего пользователя
    public function actionMy()
    {
        try {
            if (\Yii::$app->request->isGet) {
                $get = \Yii::$app->request->get();
                $param = [
                    'count' => 10,
                    'option' => [10, 25, 50, 100],
                ];
                $model = new SearchFileModel();
                $model->file_name = !empty($get['file_name']) ? $get['file_name'] : '';
                $model->user_create = Yii::$app->user->getId();

                $query = $model->GetQuery();
                $countQuery = clone $query;
                $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $param['count']]);

                $data = $query
                    ->orderBy('f.id DESC')
                    ->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();
                $data = $model->DataSizeFormat($data);
                return new ApiReturnData($data);
            }
        } catch (\Exception $e) {
            return new ApiReturnData([], ApiReturnData::ErrorEpicFail, $e->getMessage());
        }
    }

    //Добавление в корзину
    public function actionDelete($id)
    {
        try {
            $file = File::findOne($id);
            if (\Yii::$app->user->can('updateFile', ['file' => $file])) {
                //делаем запись в истории файлов
                FileHistory::AddHistory($id, FileHistory::TO_TRASH);
                $file->trash = true;
                $file->save();
                return new ApiReturnData(true);
            }
        } catch (\Exception $e) {
            return new ApiReturnData([], ApiReturnData::ErrorEpicFail, $e->getMessage());
        }
    }
}
