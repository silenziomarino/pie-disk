<?php namespace backend\modules\api\modules\v1\return_data;

/**
 * Базовый класс для возвращаемых данных
 */
class ApiReturnData
{

    const ErrorNo = 0;
    const ErrorEpicFail = -1;

    /**
     * Ответ запроса с данными
     * @param array
     */
    public $data;
    /**
     * Статус выполнения запроса
     * @param integer
     */
    public $errorCode;
    /**
     * Сообщение об ощибке
     * @param string
     */
    public $errorMessage;

    /**
     *
     * @param array $data
     * @param integer $errorCode
     * @param string $errorMessage
     */
    public function __construct($data,$errorCode = self::ErrorNo, $errorMessage = "")
    {
        $this->data = $data;
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
    }

    function getErrorCode()
    {
        return $this->errorCode;
    }

    function getErrorMessage()
    {
        return $this->errorMessage;
    }

    function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }


}
