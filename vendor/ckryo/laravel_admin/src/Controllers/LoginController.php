<?php

namespace Ckryo\Laravel\Admin\Controllers;

use Ckryo\Laravel\Admin\Models\Menu;
use Ckryo\Laravel\Admin\Models\User;
use Ckryo\Laravel\App\Http\Controllers\Controller;
use Ckryo\Laravel\Auth\Auth;
use Ckryo\Laravel\Handler\ErrorCodeException;
use Ckryo\Laravel\Logi\Facades\Logi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    private $user;

    function index(Request $request, Auth $auth, $token = null) {
        $user = $auth->user();
        $res = [
            'user_info' => [],
            'org_info' => [],
            'menu' => [
                'top' => Menu::buildMenuTop($user),
                'map' => Menu::buildMenuMap($user),
                'uri_tops' => Menu::UriTops(),
                'uris' => Menu::Uris()
            ]
        ];
        if ($token) {
            $res['auth_token'] = $token;
        } else {
            $token = $request->get('auth-token');
            Logi::login($user->id, $token, true);
            $res['auth_token'] = $token;
        }
        return response()->ok('登录成功', $res);
    }

    function store(Request $request, Auth $auth) {
        $this->validate($request, [
            'name' => 'required',
            'password' => 'required'
        ], [
            'name.required' => '账号不能为空',
            'password.required' => '密码不能为空',
        ]);
        $name = $request->name;
        if ($user = User::where('account', $name)->first()) {
            if (!Hash::check($request->password, $user->password)) {
                throw new ErrorCodeException(211);
            }
            $this->user = $user;
            $token = $auth->login($user);
            return $this->index($request, $auth, $token);
        }
        throw new ErrorCodeException(210);
    }
}