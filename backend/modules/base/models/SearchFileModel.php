<?php

namespace backend\modules\base\models;

use backend\modules\helpers\file\FileHelpers;
use yii\base\Model;
use yii\db\Query;

/**
 * Class SearchFileModel
 * @package backend\modules\base\models
 */
class SearchFileModel extends Model
{
    public $user_create;
    public $end_date;
    public $start_date;
    public $id;
    public $file_name;
    public $teg = [];
    public $trash = false;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'user_create',
                    'end_date',
                    'start_date',
                    'id',
                    'file_name',
                    'teg',
                ], 'safe'],
        ];
    }

    public function GetQuery()
    {
        $this->start_date   = (!empty($this->start_date))? date('Y-m-d H:i:s', strtotime($this->start_date . ' 00:00:00')) : '';
        $this->end_date     = (!empty($this->end_date))?   date('Y-m-d H:i:s', strtotime($this->end_date . ' 23:59:59'))   : '';


        $query = new Query();
        $query->select([
            'f.id AS id',
            'f.name AS file_name',
            'f.size AS file_size',
            'f.extension AS file_extension',
            'to_char(f.date, \'DD.MM.YYYY HH24:MI:SS\') AS date_create',
            "CONCAT(p.last_name, ' ', p.first_name) AS user",
        ])
            ->from([
                'file f'
            ])
            ->join('LEFT JOIN', 'profile p', 'p.user_id = f.user_create_id')
            ->join('LEFT JOIN', 'file_to_teg ftt', 'ftt.file_id = f.id')

            ->andFilterWhere(['=', 'f.id', $this->id])
            ->andFilterWhere(['ilike', 'f.name', $this->file_name])
            ->andFilterWhere(['>=', 'f.date', $this->start_date])
            ->andFilterWhere(['<=', 'f.date', $this->end_date])
            ->andFilterWhere(['=', 'f.user_create_id', $this->user_create])
            ->andFilterWhere(['ftt.teg_id' => $this->teg])
            ->andFilterWhere(['f.trash' => $this->trash])
            ->groupBy('f.id,p.last_name,p.first_name');
        return $query;
    }

    //форматирует размер файлов в нормальный вид
    public function DataSizeFormat($data)
    {
        foreach ($data as $key => $value){
            $data[$key]['file_size'] = FileHelpers::FileSizeFormat((float)($data[$key]['file_size']));
        }
        return $data;
    }

}
