<?php
namespace backend\modules\base\models\Entity;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * класс пользователей системы
 * Class User
 * @package backend\modules\base\models\Auth
 * @property integer $id
 * @property integer $email
 * @property integer $auth_key
 * @property integer $password
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $lock
 * @property boolean $inviter_id
 */
class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * генерация ключа аутентификации
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $now = new \DateTime();
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
                $this->created_at = $now->getTimestamp();
            }
            $this->updated_at = $now->getTimestamp();

            return true;
        }
        return false;
    }
    /**
     * поиск пользователя по id
     * @param int|string $id
     * @return User|IdentityInterface|null
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return User|IdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * Поиск по email
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }
    /**
     * возвращает id пользователя
     * @return int|mixed|string
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * получение  ключа
     * @return mixed|string
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * проверка  ключа на валидность
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    //проверка пароля
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * генерирует пароль
     * @param $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
}

