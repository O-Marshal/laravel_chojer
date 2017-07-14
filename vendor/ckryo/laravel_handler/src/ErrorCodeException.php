<?php

namespace Ckryo\Laravel\Handler;

use Ckryo\Laravel\Handler\Contracts\ExceptionFactory;
use Ckryo\Laravel\Handler\Facades\ErrorCode;

class ErrorCodeException extends \Exception implements ExceptionFactory
{
    protected $code;
    protected $message;
    protected $data;

    public function __construct($code, $message = null, $data = null)
    {
        $this->code = $code;
        $this->data = $data ?: $this;
        $this->message = $message ?: ErrorCode::getErrMsg($code);
    }

    public function handle()
    {
        return response()->json([
            'errCode' => $this->code,
            'errMsg' => $this->message,
            'data' => $this->data
        ]);
    }
}