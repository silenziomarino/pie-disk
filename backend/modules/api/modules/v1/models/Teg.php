<?php namespace backend\modules\api\modules\v1\models;

use backend\modules\base\models\Entity\Teg AS ARecord;
use yii\web\Linkable;
use yii\web\Link;
use yii\helpers\Url;

class Teg extends ARecord implements Linkable
{
    public function rules()
    {
        return [
            ['name', 'string'],
        ];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['teg/view', 'id' => $this->id], true),
        ];
    }
}
