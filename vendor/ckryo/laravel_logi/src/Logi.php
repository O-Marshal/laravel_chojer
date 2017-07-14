<?php

namespace Ckryo\Laravel\Logi;

use Ckryo\Laravel\Logi\Models\LogiActionModel;
use Ckryo\Laravel\Logi\Models\LogiIpModel;

class Logi
{
    private $request;

    private $id;

    private $ip;
    private $host;
    private $uri;
    private $method;
    private $finger;

    /**
     * LogService constructor.
     *
     * log 事件包括:
     * ip _ ip 中间件, ip 限制请求, ip 黑名单管理, ip 验证码条件
     * event _ 操作记录, 登录记录, 交易记录, 支付记录
     * 变更 - 变更参数映射关系字典
     * 错误提醒
     */
    public function __construct($app)
    {
        $this->app = $app;
        $this->request = $app['request'];
        $this->ip = $app['request']->getClientIp();
        $this->host = $app['request']->getHost();
        $this->uri = $app['request']->getRequestUri();
        $this->method = $app['request']->method();
    }

    function getfinger () {
        if ($this->finger) return $this->finger;
        return $this->finger = sha1(implode('|', [
            $this->ip, $this->host, $this->uri, $this->method
        ]));
    }

    /**
     * IP访问记录
     */
    function ip() {
        $logi_ip = new LogiIpModel();
        $logi_ip->is_secure = $this->request->isSecure() ? 1 : 0;
        $logi_ip->finger = $this->getfinger();
        $logi_ip->method = $this->method;
        $logi_ip->host = $this->host;
        $logi_ip->uri = $this->uri;
        $logi_ip->ip = $this->ip;
        $logi_ip->user_agent = $this->request->header('user-agent');
        $logi_ip->params = json_encode($this->request->all(), JSON_UNESCAPED_UNICODE);
        $logi_ip->save();

        $this->id = $this->request->logi_id = $logi_ip->id;
    }

    /**
     * 登录记录
     */
    function login($user_id, $token, $visit = false, $channel = null) {

        $action = "auth";
        if ($channel) $action .= ":" . $channel;

        if ($visit) {
            return $this->action($user_id, $action, $user_id, 'check', '访问了系统', $token);
        }
        return $this->action($user_id, $action, $user_id, 'login', '登陆了系统', $token);
    }

    /**
     * 行为操作记录
     */
    function action($user_id, $module, $union_id, $action, $desc = null, $data = null) {
        $login = new LogiActionModel();
        $login->user_id = $user_id;
        $login->logi_id = $this->id;
        $login->union_module = $module;
        $login->union_id = $union_id;
        $login->action = $action;
        $login->description = $desc;
        $login->data = $data;
        return $login->save();
    }


    /**
     * 判断账户是否被限定
     * @return bool
     */
    function is_block() {
        return false;
    }
}