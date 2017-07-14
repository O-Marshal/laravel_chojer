<?php

namespace Ckryo\Laravel\Auth;

use Ckryo\Laravel\Logi\Facades\Logi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Auth
{
    protected $user;

    protected $request;

    protected $token;

    protected $request_auth_key = "auth-token";

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the token for the current request.
     *
     * @return string
     */
    public function getTokenForRequest()
    {
        if ($this->token) return $this->token;

        if ($this->request->hasHeader($this->request_auth_key)) {
            $token = $this->request->header($this->request_auth_key);
        } else {
            $token = $this->request->query($this->request_auth_key);
        }

        if (empty($token)) {
            $token = $this->request->input($this->request_auth_key);
        }

        return $this->token = $token;
    }


    public function user($action = "json")
    {
        if (! is_null($this->user)) {
            return $this->user;
        }

        $user = null;
        $token = $this->getTokenForRequest();

        // 获取用户模型
        $model = config('auth');

        if (! empty($token)) { // 从驱动中获取 用户信息
            $user = $model->where($this->modelIdentifiedKey($action), $token)->first();
        }

        return $this->user = $user;
    }

    /**
     * 获取默认key - 保证数据库存在此字段
     * @param string $action
     * @return string
     */
    function modelIdentifiedKey ($action = "json") {
        return $action."_token";
    }

    /**
     *
     * 登录
     *
     * @param Model $user 登录用户
     * @param string $action 登录方式
     * @return string 返回 token
     */
    public function login(Model $user, $action = "json")
    {
        $modelKey = $this->modelIdentifiedKey($action);
        $time = time();
        $token = Str::random(8) . md5($action."_{$user->id}__{$time}") . Str::random(60);
        $user->$modelKey = $token;
        $user->save();
        $this->user = $user;
        Logi::login($user->id, $token);
        return $token;
    }

    /**
     * Set the current request instance.
     *
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

}
