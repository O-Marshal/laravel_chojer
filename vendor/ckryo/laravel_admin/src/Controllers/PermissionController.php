<?php

namespace Ckryo\Laravel\Admin\Controllers;


use Ckryo\Laravel\Admin\Models\User;
use Ckryo\Laravel\App\Http\Controllers\Controller;
use Ckryo\Laravel\Auth\Auth;
use Ckryo\Laravel\Admin\Models\Permission;
use Ckryo\Laravel\Admin\Models\Role;
use Ckryo\Laravel\Expand\ResourceControllerExpand;
use Illuminate\Http\Request;

// 权限管理
class PermissionController extends Controller
{

    use ResourceControllerExpand;

    function resourceModel () {
        return new Role;
    }

    function resourceModelNameKey () {
        return "name";
    }

    function resourceName () {
        return "admin_permission";
    }

    function resourceDescription () {
        return "权限";
    }

    // 获取角色列表
    function index(Auth $auth) {
        return response()->ok('数据获取成功', Permission::tree($auth->user()));
    }

    function storeValidate (Request $request, User $admin) {
        $admin_id = $admin->id;
        $this->validate($request, [
            'name' => "required|unique:admin_roles,name,NULL,id,org_id,{$admin_id}",
            'code' => "required|unique:admin_roles,code,NULL,id,org_id,{$admin_id}"
        ], [
            'name.required' => '部门名称不能为空',
            'name.unique' => '部门名称不能重复',
            'code.required' => '部门编号不能为空',
            'code.unique' => '部门编号不能重复'
        ]);
    }

}