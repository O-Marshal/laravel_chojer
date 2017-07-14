<?php

namespace Ckryo\Laravel\Admin\Controllers;

use Ckryo\Laravel\App\Http\Controllers\Controller;
use Ckryo\Laravel\Auth\Auth;
use Ckryo\Laravel\Admin\Models\Role;
use Ckryo\Laravel\Admin\Models\User;
use Ckryo\Laravel\Expand\ResourceControllerExpand;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    use ResourceControllerExpand;

    function resourceModel () {
        return new User;
    }

    function resourceModelNameKey () {
        return "name";
    }

    function resourceName () {
        return "admin_user";
    }

    function resourceDescription () {
        return "用户";
    }

    // 获取所有用户信息
    function index(Auth $auth) {
        $user = $auth->user();
        $keywords = '%'.request('keywords').'%';

        $users = $user->users()->where(function ($query) {
            $role_id = intval(request('role_id', -1));
            if ($role_id > 0) $query->where('role_id', $role_id);
        })->where(function ($query) use ($keywords) {
            $query->where('name', 'like', $keywords)
                ->orWhere('email', 'like', $keywords)
                ->orWhere('mobile', 'like', $keywords)
                ->orWhere('account', 'like', $keywords);
        })->with(['role', 'userInfo'])->paginate(10);
        return response()->page($users);
    }


    // 获取创建资源
    function create(Auth $auth) {
        $user = $auth->user();
        $org_id = $user->org_id;
        $roles = Role::where('org_id', $org_id)->get();
        return response()->ok('数据获取成功', [
            'roles' => $roles,
            'accountPrefix' => $auth->user()->account
        ]);
    }

    function storeValidate (Request $request, $admin) {
        $this->validate($request, [
            'name' => 'required',
            'role_id' => [
                'required',
                Rule::exists('admin_roles', 'id')->where(function ($query) use ($admin) {
                    $query->where('org_id', $admin->org_id);
                })
            ],
            'account' => 'required|admin_account',
            'password' => 'required|between:6,16',
        ], [
            'name.required' => '姓名不能为空',
            'role_id.*' => '角色不能为空',

            'account.required' => '账号不能为空',
            'account.admin_account' => '账号已存在',
            'password.required' => '密码不能为空',
            'password.digits_between' => '密码必须是6-16位的数字、字符或符号'
        ]);
    }
    function storeCustom (Request $request, $admin) {
        $account = $admin->account . '@' . $request->account;
        $user = User::create([
            'name' => $request->name,
            'avatar' => $request->avatar,
            'role_id' => $request->role_id,
            'org_id' => $admin->org_id,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'account' => $account,
            'password' => bcrypt($request->password)
        ]);
        $user->userInfo()->create([
            'sex' => $request->get('sex', 0),
            'qq' => $request->qq,
            'wechat' => $request->wechat,
            'address' => $request->address,
            'birthday' => $request->birthday ? date('Y-m-d', strtotime($request->birthday)) : null
        ]);
        return $user;
    }

    function updateValidate (Request $request, $admin) {
        $this->validate($request, [
            'role_id' => [
                Rule::exists('admin_roles', 'id')->where(function ($query) use ($admin) {
                    $query->where('org_id', $admin->org_id);
                })
            ],
            'account' => 'admin_account',
            'password' => 'between:6,16',
        ], [
            'role_id.*' => '角色不能为空',

            'account.admin_account' => '账号已存在',
            'password.digits_between' => '密码必须是6-16位的数字、字符或符号'
        ]);
    }

    function updateCustom (array $updates, $admin, User $user) {
        $users = array_only($updates, ['name', 'avatar', 'role_id', 'org_id', 'email', 'mobile', 'account', 'password']);
        foreach ($users as $key => $value) {
            if ($key == 'account') {
                $user->account = $user->org->account . '@' . $value;
            } else if ($key == 'password') {
                $user->$key = bcrypt($value);
            } else {
                $user->$key = $value;
            }
        }
        $userInfos = array_only($updates, ['sex', 'qq', 'wechat', 'address', 'birthday']);
        foreach ($userInfos as $key => $value) {
            if ($key == 'birthday') {
                $user->userInfo->birthday = $value ? date('Y-m-d', strtotime($value)) : null;
            } else {
                $user->userInfo->$key = $value;
            }
        }
        $user->userInfo->save();
        $user->save();
    }
}