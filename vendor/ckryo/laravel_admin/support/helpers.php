<?php
/**
 * Created by PhpStorm.
 * User: liurong
 * Date: 2017/5/18
 * Time: 上午9:57
 */

if (!function_exists('db_transaction')) {
    /**
     * 数据库事务
     * @param Closure $block
     * @return mixed
     */
    function db_transaction (Closure $block) {
        return \Illuminate\Support\Facades\DB::transaction($block);
    }
}