<?php
namespace Ckryo\Laravel\Logi\Facades;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Contracts\Auth\Authenticatable|null user();
 * @method static void ip() IP访问记录;
 * @method static bool action($user_id, $module, $union_id, $action, $desc = null, $data = null) 操作记录
 * @method static void login($user_id, $token, $visit = false, $channel = null) 登录记录
 */
class Logi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'logi';
    }
}