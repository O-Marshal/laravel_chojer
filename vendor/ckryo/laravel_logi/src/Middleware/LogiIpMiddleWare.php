<?php
/**
 * Created by PhpStorm.
 * User: liurong
 * Date: 2017/3/27
 * Time: 下午2:55
 */

namespace Ckryo\Laravel\Logi\Middleware;

use Ckryo\Laravel\Logi\Logi;
use Closure;

class LogiMiddleWare
{
    private $logi;

    public function __construct(Logi $logi)
    {
        $this->logi = $logi;
    }

    public function handle($request, Closure $next)
    {
        $this->logi->ip();
        return $next($request);
    }
}