<?php

namespace console\controllers;

use backend\modules\base\models\FileModel;
use backend\modules\base\rbac\AdminRule;
use backend\modules\base\rbac\CreatorRule;
use backend\modules\base\rbac\InviterRule;
use backend\modules\base\rbac\ModeratorRule;
use Yii;
use yii\console\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $auth = Yii::$app->authManager;
        //-------------------------------------------------------------
        // добовляем правило редаклирования фалов
        $rule = new CreatorRule;
        $auth->add($rule);

        // добавляем право "updateFile" и связываем правило с правом
        $updateOwnPost = $auth->createPermission('updateFile');
        $updateOwnPost->description = 'Обновление файлов';
        $updateOwnPost->ruleName = $rule->name;
        $auth->add($updateOwnPost);

        $author = Yii::$app->authManager->getRole('moderator');
        // и тут мы позволяем модератору редактировать свои файлы
        $auth->addChild($author, $updateOwnPost);
        //--------------------------------------------------------------
        // добовляем правило подтверждения регистрации
        $rule2 = new InviterRule;
        $auth->add($rule2);

        //добавляем право
        $confirmUser = $auth->createPermission('confirmUser');
        $confirmUser->description = 'Подтверждение регистрации';
        $confirmUser->ruleName = $rule2->name;
        $auth->add($confirmUser);

        $author = Yii::$app->authManager->getRole('moderator');
        $auth->addChild($author, $confirmUser);
        //-------------------------------------------------------------
        // добовляем правило: действия только для модераторов
        $rule3 = new ModeratorRule;
        $auth->add($rule3);

        //добавляем право на действия только для модераторов
        $confirmUser = $auth->createPermission('forModeroator');
        $confirmUser->description = 'Дает право если ты Модератор';
        $confirmUser->ruleName = $rule3->name;
        $auth->add($confirmUser);

        $author = Yii::$app->authManager->getRole('moderator');
        $auth->addChild($author, $confirmUser);
        //-------------------------------------------------------------
        // добовляем правило: действия только для админа
        $rule4 = new AdminRule;
        $auth->add($rule4);

        //добавляем право на действия только для модераторов
        $confirmUser = $auth->createPermission('forAdmin');
        $confirmUser->description = 'Дает право если ты Админ';
        $confirmUser->ruleName = $rule4->name;
        $auth->add($confirmUser);

        $author = Yii::$app->authManager->getRole('admin');
        $auth->addChild($author, $confirmUser);
        //-------------------------------------------------------------
    }

    //удаляем записи из корзины через 30 дней
    //  59 23 * * *
    public function actionDropTrashFile()
    {
        FileModel::DropTrashFile();
    }
}
