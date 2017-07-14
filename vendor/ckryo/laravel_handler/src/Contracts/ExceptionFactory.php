<?php
namespace Ckryo\Laravel\Handler\Contracts;

interface ExceptionFactory {

    /**
     * 回调处理错误信息
     *
     * @return bool
     */
    public function handle();

}