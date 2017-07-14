<?php

namespace Ckryo\Laravel\Handler\Facades;

use Illuminate\Support\Facades\Facade;

class ErrorCode extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'errorcode';
    }
}