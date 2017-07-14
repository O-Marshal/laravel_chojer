<?php
/**
 * Created by PhpStorm.
 * User: liurong
 * Date: 2017/5/18
 * Time: 上午9:57
 */

if (!function_exists('logi')) {
    /**
     * 操作记录
     * @param $user_id
     * @param $module
     * @param $union_id
     * @param $action
     * @param null $desc
     * @param null $data
     * @return bool
     */
    function logi ($user_id, $module, $union_id, $action, $desc = null, $data = null) {
        return \Ckryo\Laravel\Http\Facades\Logi::action($user_id, $module, $union_id, $action, $desc, $data);
    }
}