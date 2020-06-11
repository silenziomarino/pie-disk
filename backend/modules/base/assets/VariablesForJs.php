<?php

namespace backend\modules\base\assets;

class VariablesForJs
{
    /**
     * Переменные для DatePicker
     * @return string
     */
    public static function VariablesForDatePicker()
    {
        return
            'var applyLabelDate ="Готово"; ' .
            'var cancelLabel ="Отмена"; ' .
            'var fromLabelDate ="От"; ' .
            'var toLabelDate ="До"; ' .

            'var suDate ="Вс"; ' .
            'var moDate ="Пн"; ' .
            'var tuDate ="Вт"; ' .
            'var weDate ="Ср"; ' .
            'var thDate ="Чт"; ' .
            'var frDate ="Пт"; ' .
            'var saDate ="Сб"; ' .

            'var janDate ="Январь"; ' .
            'var febDate ="Февраль"; ' .
            'var marchDate ="Март"; ' .
            'var aprDate ="Апрель"; ' .
            'var mayDate ="Май"; ' .
            'var juneDate ="Июнь"; ' .
            'var julDate ="Июль"; ' .
            'var augDate ="Август"; ' .
            'var sepDate ="Сентябрь"; ' .
            'var octDate ="Октябрь"; ' .
            'var novDate ="Ноябрь"; ' .
            'var decDate ="Декабрь";';
    }

    /**
     * Переменные для DualList
     * @return string
     */
    public static function VariablesForDualList()
    {
        return
              'var filterTextClearDualbox ="Показать все"; ' .
              'var filterPlaceHolderDualbox ="Фильтр"; ' .
              'var moveSelectedLabelDualbox ="Переместить выбранные"; ' .
              'var moveAllLabelDualbox ="Переместить все"; ' .
              'var removeSelectedLabelDualbox ="Удалить выбранные"; ' .
              'var removeAllLabelDualbox ="Удалить все"; ' .
              'var infoTextDualbox ="Показано"; ' .
              'var infoTextFilteredDualbox ="Отсортировано"; ' .
              'var infoTextEmptyDualbox ="Пустой список"; ';
    }


    /**
     * Переменная langDate
     * @return string
     */
    public static function VariablesLangDate()
    {
        $langDate   = 'ru';
        return 'var langDate = "' . $langDate . '";';
    }

    /**
     * Переменные для DataTables
     * @return string
     */
    public static function VariablesForDataTables()
    {
         return
            'var tilteDialog ="Удалить выбранный элемент?"; ' .
            'var deleteButton ="Удалить"; ' .
            'var cancelButton ="Отмена"; ';
    }
}