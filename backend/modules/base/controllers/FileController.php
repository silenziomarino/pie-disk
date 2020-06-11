<?php

namespace backend\modules\base\controllers;

use backend\modules\base\models\Entity\File;
use backend\modules\base\models\Entity\FileHistory;
use backend\modules\base\models\Entity\FileToTeg;
use backend\modules\base\models\Entity\TypeFile;
use backend\modules\base\models\Entity\Teg;
use backend\modules\base\models\FileForm;
use backend\modules\base\models\FileTypeForm;
use backend\modules\base\models\SearchFileHistory;
use backend\modules\base\models\SearchFileModel;
use backend\modules\base\models\TegForm;
use backend\modules\helpers\file\FileHelpers;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class FileController extends Controller
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
                            'create',
                            'update',
                            'option',
                            'delete',
                            'my-file',
                            'search-my-file',
                            'history',
                            'my-trash',
                            'trash-restore',
                            'search-my-trash',
                        ],
                        'roles' => ['moderator'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'file-bar',
                            'download',
                            'get-tegs',
                            'info-load',
                        ],
                        'roles' => ['visitor'],
                    ],
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

    /**
     * загрузка файла в базу
     * @return \yii\web\Response
     */
    public function actionCreate()
    {
        $model = new FileForm(['scenario' => FileForm::FILE_CREATE]);
        if (Yii::$app->request->isPost) {
            $model->files = UploadedFile::getInstances($model, 'files');
            if ($model->validate()) {
                $list = $model->create();//список id файлов в базе
                $list = json_encode($list);
                if (!empty($list)) return $this->redirect(['option', 'list' => $list]);
            }
        }
        return $this->goBack();
    }

    /**
     * выводит файлы на редактирование
     * @param $list
     * @return string
     */
    public function actionOption($list)
    {
        $list = json_decode($list);

        //получаем список файлов которые запросил пользователь
        $File = File::find()
            ->where([
                'id' => $list,
            ])->all();

        $TegForm = [];
        $FileForm = [];
        foreach ($File as $file){
            $FileForm[$file['id']] = new FileForm();
            $FileForm[$file['id']]->id = (int)$file['id'];
            $FileForm[$file['id']]->name = $file['name'];
            //получаем id тегох привязаных к файлу
            $FileToTeg = FileToTeg::findRowsByFileId($file['id']);
            //записываем для кажого файла теги в одну строку
            $str_tegs = [];
            foreach ($FileToTeg as $teg){
                $Teg = Teg::findTegById($teg['teg_id']);
                $str_tegs[$file['id']] .= $Teg->name.", ";
            }
            $TegForm[$file['id']] = new TegForm();
            $TegForm[$file['id']]->id = $file['id'];
            $TegForm[$file['id']]->str = $str_tegs ? $str_tegs[$file['id']] : null;
        }
        return $this->render('options', [
            'data_file' => $FileForm,
            'data_teg'  => $TegForm,
        ]);
    }

    /**
     * принимает данные на сохранение
     * @return \yii\web\Response
     */
    public function actionUpdate()
    {
        $post = Yii::$app->request->post();
        $TegForm = new TegForm();
        $FileForm = new FileForm(['scenario' => FileForm::FILE_UPDATE]);
        if($TegForm->load($post) && $TegForm->validate()){
            $TegForm->update();
        }
        if($FileForm->load($post) && $FileForm->validate()){
            $FileForm->update();
        }
        return 'true';
    }

    /**
     * поиск записи в таблице
     * @param $id
     * @return File|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = File::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Запрашиваемая страница не существует!');
    }

    //страница с файлами пользователя
    public function actionMyFile()
    {
        $modelFileForm = new FileForm();//кнопка загрузить
        $model = new SearchFileModel();//фильтры поиска и список файлов

        //справочники тегов
        $dic_teg = Teg::GetTegList();
        $dic_teg = ArrayHelper::map($dic_teg,"id","name");

        //право на добавление документа
        $addDocRule = false;
        if (\Yii::$app->user->can('forModeroator')) {
            $addDocRule = true;
        }

        return $this->render('my_file',[
            'model'         => $model,
            'modelFileForm' => $modelFileForm,
            'dic_teg'       => $dic_teg,
            'addDocRule'    => $addDocRule,
        ]);
    }

    //поиск файлов текущего пользователя
    public function actionSearchMyFile()
    {
        $param = [
            'count' => 10,
            'option' => [10, 25, 50, 100],
        ];
        $post = Yii::$app->request->post();

        $model = new SearchFileModel();//фильтры поиска и список файлов
        $model->load($post);
        $model->user_create = Yii::$app->user->getId();

        $param['count'] = (!empty($post['count'])) ? $post['count'] : $param['count'];

        $query = $model->GetQuery();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $param['count']]);

        $data = $query
            ->orderBy('f.id DESC')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $data = $model->DataSizeFormat($data);
        return $this->renderAjax('search_my_file', [
            'model' => $model,
            'param' => $param,
            'data'  => $data,
            'pages' => $pages,
        ]);
    }


    //возвращает список тего по имени
    public function actionGetTegs($name)
    {
        $tegs = Teg::GetTegLikeName($name);
        $list = ArrayHelper::map($tegs,"id","name");
        return json_encode($list);
    }

    //панель с инструментами для каждого файла
    public function actionFileBar()
    {
        $post = Yii::$app->request->post();
        if(!empty($post)) {
            $file_id = $post['file_id'];
            $user_id = Yii::$app->user->getId();

            $file = File::findOne($file_id);
            return $this->renderAjax('file_bar', [
                'file' => $file,
            ]);
        }
    }

    /**
     * получаем истории изменений файла по id
     * @return string
     */
    public function actionHistory()
    {
        $post = Yii::$app->request->post();
        $model = new SearchFileHistory();
        $model->file_id = (int)$post['file_id'];
        if($model->validate()){
            $query = $model->GetHistory();
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
            $data = $query
                ->orderBy('fh.id DESC')
                ->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
            return $this->renderAjax('history', [
                'model' => $model,
                'data'  => $data,
                'pages' => $pages,
            ]);
        }
    }

    //информация перед загрузкой файлов на сайт
    public function actionInfoLoad()
    {
        //макс размер файла
        $upload_max_filesize = ini_get('upload_max_filesize');
        $bytes = FileHelpers::ReturnBytes($upload_max_filesize);
        $max_filesize = FileHelpers::FileSizeFormat($bytes);

        //справочник форматов файлов
        $dic_format = TypeFile::GetTypeList();
        $dic_format = ArrayHelper::map($dic_format,"id","name");

        return $this->renderAjax('info_load',[
            'max_filesize' => $max_filesize,
            'dic_format' => $dic_format,
        ]);
    }

    //справочник "Тип файлов"
    public function actionDicTypeFile()
    {
        $post = Yii::$app->request->post();
        $model = new FileTypeForm();
        if($model->load($post) && $model->validate()){
            $model->update();
            return $this->redirect(['dic-type-file']);
        }

        $dic_type = TypeFile::GetTypeList();
        foreach ($dic_type as $value){
            $model->str .= $value['name'].", ";
        }

        return $this->render('dic_type_file',[
            'model' => $model,
        ]);
    }

    //моя корзина с файлами
    public function actionMyTrash()
    {
        $model = new SearchFileModel();

        //справочники тегов
        $dic_teg = Teg::GetTegList();
        $dic_teg = ArrayHelper::map($dic_teg,"id","name");
        return $this->render('my_trash',[
            'model'         => $model,
            'dic_teg'       => $dic_teg,
        ]);
    }
    public function actionSearchMyTrash()
    {
        $param = [
            'count' => 10,
            'option' => [10, 25, 50, 100],
        ];
        $post = Yii::$app->request->post();

        $model = new SearchFileModel();//фильтры поиска и список файлов
        $model->load($post);
        $model->user_create = Yii::$app->user->getId();
        $model->trash = true;

        $param['count'] = (!empty($post['count'])) ? $post['count'] : $param['count'];

        $query = $model->GetQuery($param);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $param['count']]);

        $data = $query
            ->orderBy('f.id DESC')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $data = $model->DataSizeFormat($data);
        return $this->renderAjax('search_my_trash', [
            'model' => $model,
            'param' => $param,
            'data'  => $data,
            'pages' => $pages,
        ]);
    }

    //скачивание файла
    public function actionDownload($id)
    {
        //делаем запись в истории файлов
        FileHistory::AddHistory($id,FileHistory::DOWNLOAD);

        $file = File::findFile($id);
        header("Content-type:$file->mime");
        header("Content-Disposition:attachment;filename=".$file->name.".".$file->extension);
        echo base64_decode(stream_get_contents($file->binary));
    }

    //Добавление в корзину
    public function actionDelete($id)
    {
        $file = $this->findModel($id);
        if (\Yii::$app->user->can('updateFile', ['file' => $file])) {
            //делаем запись в истории файлов
            FileHistory::AddHistory($id, FileHistory::TO_TRASH);
            $file->trash = true;
            $file->save();
            return true;
        }
        return false;
    }

    //востановление файла из корзины
    public function actionTrashRestore($id)
    {
        $file = $this->findModel($id);
        if (\Yii::$app->user->can('updateFile', ['file' => $file])) {
            //делаем запись в истории файлов
            FileHistory::AddHistory($id, FileHistory::RESTORE_FROM_TRASH);
            $file->trash = false;
            $file->save();
            return true;
        }
    }
}
