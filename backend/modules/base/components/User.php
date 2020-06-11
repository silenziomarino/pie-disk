<?php
namespace backend\modules\base\components;

use backend\modules\base\models\Entity\AuthAssignment;
use backend\modules\base\models\Entity\Notify;
use backend\modules\base\models\Entity\Profile;
use backend\modules\base\models\Entity\User as Users;

/**
 * Class User
 * @package backend\modules\base\components
 * @property string $user_fio
 * @property string $user_name
 * @property string $email
 * @property string $photo
 */
class User extends \yii\web\User
{
    public function init() {
        parent::init();
    }

    private $user_fio;
    private $user_name;
    private $email;
    private $photo;

    /**
     * @return string - полное имя пользователя
     */
    public function GetUserFio(){
        if($this->user_fio){
            return $this->user_fio;
        }else{
            $id = $this->identity->getId();
            $profile = Profile::GetProfile($id);
            $this->user_fio  = (!empty($profile))? $profile->last_name.' '.$profile->first_name.' '.$profile->middle_name   : '';
            return $this->user_fio;
        }
    }

    /**
     * @return string user_name - например: Тяпкина М.
     */
    public function GetUserName()
    {
        if($this->user_name){
            return $this->user_name;
        }else{
            $id = $this->identity->getId();
            $profile = Profile::GetProfile($id);
            $this->user_name = (!empty($profile))? $profile->first_name : '';
            return $this->user_name;
        }
    }

    /**
     * @return string user_name - например: Тяпкина М.
     */
    public function GetEmail()
    {
        if($this->email){
            return $this->email;
        }else{
            $id = $this->identity->getId();
            $user = Users::findIdentity($id);
            $this->email = $user->email;
            return $this->email;
        }
    }

    /**
     * @return string user_name - например: Тяпкина М.
     */
    public function GetImg()
    {
        if($this->photo){
            return $this->photo;
        }else{
            $id = $this->identity->getId();
            $profile = Profile::GetProfile($id);
            if(!empty($profile->photo)){
                $this->photo = $profile->photo;
                return $this->photo;
            }else{
                return "/img/avatar.png";
            }

        }
    }

    public function GetCountNotify()
    {
        $user_id = $this->identity->getId();
        return Notify::GetCountNotify($user_id);
    }

    public function GetLeftMenu()
    {
        $user_id = $this->identity->getId();
        $role = AuthAssignment::GetUserRole($user_id);
        $role_name = $role->item_name;
        $array = [
            'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
        ];

        if ($role_name == 'admin') {
            $array['items'][] = ['label' => 'система', 'options' => ['class' => 'header']];
            $array['items'][] = [
                'label' => 'Управл. пользователями ',
                'icon' => 'address-book',
                'url' => '#',
                'items' => [
                    ['label' => 'Пользователи', 'icon' => 'angle-right', 'url' => ['/base/user/user-list'],],
                ]
            ];
            $array['items'][] = [
                'label' => 'Справочники',
                'icon' => 'book',
                'url' => '#',
                'items' => [
                    ['label' => 'Ключевые слова', 'icon' => 'angle-right', 'url' => ['/base/teg/dic-teg-file'],],
                    ['label' => 'Типы файлов', 'icon' => 'angle-right', 'url' => ['/base/file/dic-type-file'],],
                ]
            ];
        }
        if ($role_name == 'admin' || $role_name == 'moderator') {
            $array['items'][] = ['label' => 'Статистика', 'icon' => 'thermometer-half', 'url' => ['/base/report/index'],];
            $array['items'][] = ['label' => 'меню', 'options' => ['class' => 'header']];
            $array['items'][] = ['label' => 'Профиль', 'icon' => 'user-circle', 'url' => ['/base/user/profile']];
            $array['items'][] = ['label' => 'Мои документы', 'icon' => 'copy', 'url' => ['/base/file/my-file']];
            $array['items'][] = ['label' => 'Корзина', 'icon' => 'trash', 'url' => ['/base/file/my-trash']];
            $array['items'][] = ['label' => 'Выйти', 'icon' => 'power-off', 'url' => ['/base/user/logout']];
        } else if ($role_name == 'visitor') {
            $array['items'][] = ['label' => 'меню', 'options' => ['class' => 'header']];
            $array['items'][] = ['label' => 'Профиль', 'icon' => 'user-circle', 'url' => ['/base/user/profile']];
            $array['items'][] = ['label' => 'Выйти', 'icon' => 'power-off', 'url' => ['/base/user/logout']];
        }
        return $array;
    }
}