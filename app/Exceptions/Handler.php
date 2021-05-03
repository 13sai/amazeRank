<?php

namespace App\Exceptions;

use App\Jobs\SystemNotify;
use App\Services\ExceptionReport;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
        ApiException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function render($request, Exception $e)
    {
        foreach ($this->dontReport as $report) {
            if ($e instanceof $report) {
                return parent::render($request, $e);
            }
        }


        if ($e instanceof  UnauthorizedHttpException) {
            return response()->json([
                'data' => [],
                'code' => 401,
                'msg'  => 'Unauthorized',
                'status' => 'failure',
            ], 401);
        }

        if ($e instanceof  NotFoundHttpException) {
            return response()->json([
                'data' => [],
                'code' => 404,
                'msg'  => '',
                'status' => 'failure',
            ], 404);
        }

        if (env('APP_DEBUG')) {
            return parent::render($request, $e); //开发环境，则显示详细错误信息
        } else {
            Log::channel('error')->error($e);
            $job = (new SystemNotify($e->getMessage(), "#### message \n> ".$e->getMessage()."\n #### file \n> ".$e->getFile()."(".$e->getLine().")"));
            dispatch($job);
            return response()->json([
                'data' => [],
                'code' => 500,
                'msg'  => '服务器异常',
                'status' => 'failure',
            ], 500);
        }
    }
}
