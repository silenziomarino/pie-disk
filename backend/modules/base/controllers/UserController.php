<?php

namespace backend\modules\base\controllers;

use backend\modules\base\models\AuthItemModel;
use backend\modules\base\models\RecoveryForm;
use backend\modules\base\models\SignupConfirm;
use backend\modules\base\models\SignupForm;
use backend\modules\base\models\UserModel;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use backend\modules\base\models\AuthModel;
use backend\modules\base\models\Entity\AuthAssignment;
use backend\modules\base\models\Entity\AuthItem;
use backend\modules\base\models\Entity\Profile;
use backend\modules\base\models\Entity\User;
use backend\modules\base\models\LoginForm;
use backend\modules\base\models\ProfileForm;
use backend\modules\base\models\SearchUser;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup', 'recovery-window'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout','recovery-window'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'profile',
                            'recovery',
                            'get-fio-by-part'
                        ],
                        'roles' => ['visitor'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'confirm-reg',
                        ],
                        'roles' => ['moderator'],
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
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * поиск записи в таблице
     * @param $id
     * @return User|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Запрашиваемая страница не существует!');
    }

    /**
     * Login action.
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    //регистрация
    public function actionSignup()
    {
        $post = Yii::$app->request->post();
        $model = new SignupForm();
        if ($model->load($post) && $model->SignUp()) {
            //получаем имя приглашающего
            $inviter = Profile::GetProfile($model->inviter);
            $inviter = $inviter['last_name'].' '.$inviter['first_name'].' '.$inviter['middle_name'];

            return $this->render('signup_response',[
                'inviter' => $inviter,
            ]);
        }
        //Список пользователей кто может подтвердить регистрацию
        $inviter_list = AuthModel::GetListUserWithBigRole();

        return $this->render('signup', [
            'model' => $model,
            'inviter_list' => $inviter_list,
        ]);
    }

    public function actionProfile()
    {
        $model = new ProfileForm();
        $post = Yii::$app->request->post();
        if (Yii::$app->request->isPost) {
            if ($model->load($post) && $model->validate()) {
                //загружаем фото
                $model->photo = UploadedFile::getInstances($model, 'photo');
                $model->update();
            }
        }

        $id = Yii::$app->user->getId();
        $profile = Profile::GetProfile($id);
        $model->first_name  = $profile['first_name'];
        $model->last_name   = $profile['last_name'];
        $model->middle_name = $profile['middle_name'];
        $model->photo       = $profile['photo'];
        $email = Yii::$app->user->GetEmail();
        return $this->render('profile', [
            'model' => $model,
            'email' => $email,
        ]);
    }

    public function actionUserList()
    {
        $model = new SearchUser();
        return $this->render('user_list', [
            'model' => $model,
        ]);
    }

    public function actionSearchUserList()
    {

        $param = [
            'count' => 10,
            'option' => [10, 25, 50, 100],
        ];
        $post = Yii::$app->request->post();

        $model = new SearchUser();//фильтры поиска и список файлов
        $model->load($post);
        $param['count'] = (!empty($post['count']))? $post['count']: $param['count'];

        $query = $model->GetQuery();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $param['count']]);

        $data = $query
            ->orderBy('u.id DESC')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->renderAjax('search_user_list',[
            'model' => $model,
            'param' => $param,
            'data'  => $data,
            'pages' => $pages,
        ]);
    }

    //спраочник пользователей для фильтров с chosen по имени
    public function actionGetFioByPart($name)
    {
        $list = Profile::GetFioLikeName($name);
        $list = ArrayHelper::map($list,"id","name");
        return json_encode($list);
    }

    //получаем список ролей
    public function actionGetRole()
    {
        $post = Yii::$app->request->post();
        $user_id = (int)$post['user_id'];
        if(empty($user_id))return false;

        $role = AuthAssignment::GetUserRole($user_id);
        //справочник ролей
        $dic_auth_item = AuthItemModel::GetDicAuthItem();
        $dic_auth_item = ArrayHelper::map($dic_auth_item, "id", "name");

        return $this->renderAjax('role',[
            'role' => $role->item_name,
            'dic_auth_item' => $dic_auth_item,
        ]);
    }

    //сохраняем новую роль пользователя
    public function actionSetRole()
    {
        $post = Yii::$app->request->post();
        $user_id = (int)$post['user_id'];
        $role = (string)$post['role'];
        if (empty($user_id) || empty($role)) return false;

        $AuthAss = AuthAssignment::GetUserRole($user_id);
        $AuthAss->item_name = $role;
        if ($AuthAss->save()) return true;
    }

    //удаление пользователя
    public function actionUserDelete()
    {
        $post = Yii::$app->request->post();
        $user_id = (int)$post['user_id'];
        $res = UserModel::deleteUser($user_id);
        return $res;
    }

    //блокировка/разблокировка пользователя по id
    public function actionUserLock()
    {
        $post = Yii::$app->request->post();
        $user_id = (int)$post['user_id'];
        $status = (bool)$post['status'];
        return UserModel::lockUser($user_id,$status);
    }

    //подтверждение(/отказ от) регистрации модератором или админом
    public function actionConfirmReg()
    {
        $post = Yii::$app->request->post();

        $model = new SignupConfirm();
        $model->invited_id = (int)$post['id'];
        $model->status = (boolean)$post['status'];
        $model->auth_item = (string)$post['auth_item'];
        return $model->confirmUserRegistr();
    }

    //modal окно востановление пароля
    public function actionRecoveryWindow()
    {
        return $this->renderAjax('recovery',[
            'model' => new RecoveryForm(),
        ]);
    }

    //востановление пароля
    public function actionRecovery()
    {
        $post = Yii::$app->request->post();
        $model = new RecoveryForm();

        if(Yii::$app->user->isGuest){
            $model->load($post);
            return $model->recovery();
        }else{
            $model->email = Yii::$app->user->GetEmail();
            return $model->recovery();
        }
    }
}
