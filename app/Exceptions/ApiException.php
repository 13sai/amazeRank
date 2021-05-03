<?php
/**
 * Author: sai
 * Date: 2020/1/15
 * Time: 14:31
 */

namespace App\Exceptions;

class ApiException extends \Exception
{
    const ERROR_CODE = 1001;
    const ERROR_MSG  = 'ApiException';

    private $data = [];

    /**
     * BusinessException constructor.
     *
     * @param string $message
     * @param int $code
     * @param array $data
     */
    public function __construct(string $message, int $code = -1, $data = [])
    {
        $this->code = $code  ? : self::ERROR_CODE;
        $this->message  = $message ? : self::ERROR_MSG;
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * 异常输出
     */
    public function render($request)
    {
        return response()->json([
            'data' => $this->getData(),
            'code' => $this->getCode(),
            'msg'  => $this->getMessage(),
            'status' => 'failure',
        ], 200);
    }
}
