<?php

namespace backend\modules\base\models;

use yii\base\Model;
use yii\db\Query;

/**
 * Class SearchFileHistory
 * @package backend\modules\base\models
 */
class SearchFileHistory extends Model
{
    public $file_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['file_id', 'integer']
        ];
    }

    //получение истории изменения файла
    public function GetHistory()
    {
        $query = new Query();
        $query->select([
            'to_char(fh.date, \'DD.MM.YYYY HH24:MI:SS\') AS date',
            'o.name AS operation_name',
            'CONCAT(p.last_name, \' \', p.first_name) AS user',
        ])
            ->from([
                'file_history fh'
            ])
            ->join('LEFT JOIN', 'profile p', 'p.user_id = fh.user_id')
            ->join('LEFT JOIN', 'dic_file_operation o', 'o.id = fh.operation_id')
            ->andFilterWhere(['fh.file_id' => $this->file_id]);
        return $query;
    }

}
