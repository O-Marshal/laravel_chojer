<?php

namespace Ckryo\Laravel\Http\Facades;

use Illuminate\Support\Facades\Facade;

class ErrorCode extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'errorcode';
    }


}