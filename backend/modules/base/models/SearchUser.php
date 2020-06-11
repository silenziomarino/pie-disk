<?php

namespace backend\modules\base\models;

use yii\base\Model;
use yii\db\Query;

/**
 * Class SearchUser
 * @package backend\modules\base\models
 * @property $user_id
 * @property $start_date
 * @property $end_date
 */
class SearchUser extends Model
{
    public $user_id = [];
    public $start_date;
    public $end_date;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'user_id',
                    'start_date',
                    'end_date',
                ], 'safe'],
        ];
    }

    public function GetQuery()
    {
        $this->start_date   = (!empty($this->start_date))? date('Y-m-d H:i:s', strtotime($this->start_date . ' 00:00:00')) : '';
        $this->end_date     = (!empty($this->end_date))?   date('Y-m-d H:i:s', strtotime($this->end_date . ' 23:59:59'))   : '';

        $start_date = $this->start_date ? strtotime($this->start_date) : '';
        $end_date   = $this->end_date   ? strtotime($this->end_date)   : '';

        $query = new Query();
        $query->select([
            'u.id AS id',
            'u.email AS email',
            'u.created_at AS date',
            "CONCAT(p.last_name, ' ', p.first_name, ' ', p.middle_name) AS fio",
            "u.lock AS lock",
        ])
            ->from([
                'user u'
            ])
            ->join('LEFT JOIN', 'profile p', 'p.user_id = u.id')

            ->andFilterWhere(['>=', 'u.created_at', $start_date])
            ->andFilterWhere(['<=', 'u.created_at', $end_date])
            ->andFilterWhere(['in', 'u.id', $this->user_id])
            ->groupBy('u.id,p.last_name,p.first_name,p.middle_name');
        return $query;
    }
}
