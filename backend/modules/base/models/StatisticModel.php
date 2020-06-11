<?php

namespace backend\modules\base\models;

use backend\modules\base\models\Entity\FileHistory;
use backend\modules\helpers\file\FileHelpers;
use yii\base\Model;
use yii\db\Query;

class StatisticModel extends Model
{
    public $user_create;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [],
        ];
    }

    //по каждому типу находим занятое место на сервере
    public static function GetTypeInfoSize()
    {
        $mime_list = [
            'application' => 'Приложения',
            'audio'       => 'Аудио',
            'example'     => 'Примеры',
            'image'       => 'Изображения',
            'message'     => 'Сообщения',
            'model'       => '3D-модели',
            'multipart'   => 'Составные',
            'text'        => 'Текст',
            'video'       => 'Видео',
            'font'        => 'Данные шрифтов',
        ];

        $labels = [];
        $data = [];
        foreach ($mime_list as $key => $value){
            $query = new Query();
            $result = $query->select(['sum(f.size)'])
                ->from(['file f'])
                ->andFilterWhere(['ilike', 'f.mime', $key])
                ->all();

            if(!empty($result[0]['sum'])){

                $size = FileHelpers::FileSizeFormat($result[0]['sum']);
                $labels[] = $value.' ('.$size.')';
                $data[] = $result[0]['sum'];
            }
        }
        $total_sum = FileHelpers::FileSizeFormat(array_sum($data));
        return [
            'chart_name' => 'Статистика загруженности сервера по типу информации.',
            'labels'    => $labels,
            'data'      => $data,
            'total_sum' => $total_sum
        ];
    }

    public static function GetFileTimeLine()
    {

        $labels = [];
        $data = [];

        $now = new \DateTime;
        for ($i=11;$i>=0;$i--){
            $clone = clone $now;
            $clone->modify( "-$i month");

            $year  = $clone->format('Y');
            $month = $clone->format('m');
            $last_day = date('t', $clone->getTimestamp());

            $start = date('Y-m-d H:i:s', strtotime($year . '-' . $month . '-' . '1' . ' 00:00:00'));
            $end = date('Y-m-d H:i:s', strtotime($year . '-' . $month . '-' . $last_day . ' 23:59:59'));

            $count = FileHistory::find()
                ->andFilterWhere(['>=', 'date', $start])
                ->andFilterWhere(['<=', 'date', $end])
                ->count();

            $labels[] = $month . '.' . $year;
            $data[]   = $count;
        }


        $total = array_sum($data);
        return [
            'chart_name' => 'Интенсивность добавления файлов по месяцам за 1 год.',
            'labels'     => $labels,
            'data'       => $data,
            'total'      => $total
        ];
    }

    public static function GetActiveUser()
    {
        $labels = [];
        $data = [];

        $query = new Query();
        $result = $query
            ->select([
                'p.id',
                "CONCAT(p.last_name, ' ', p.first_name) AS user",
                'count(fh.id)',
            ])
            ->from(['file_history fh'])
            ->join('LEFT JOIN', 'profile p', 'p.user_id = fh.user_id')
            ->groupBy('p.id')
            ->all();

        foreach ($result as $key => $value){
            $labels[] = $value['user'];
            $data[] = $value['count'];
        }
        $total = array_sum($data);
        return [
            'chart_name' => 'Активность пользователей',
            'labels'     => $labels,
            'data'       => $data,
            'total'      => $total
        ];
    }
}
