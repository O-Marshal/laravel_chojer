<?php

namespace Ckryo\Laravel\Admin\Controllers;


use Ckryo\Laravel\Admin\Models\User;
use Ckryo\Laravel\App\Http\Controllers\Controller;
use Ckryo\Laravel\Auth\Auth;
use Ckryo\Laravel\Admin\Models\Role;
use Ckryo\Laravel\Expand\ResourceControllerExpand;
use Illuminate\Http\Request;

// 部门
class RoleController extends Controller
{

    use ResourceControllerExpand;

    function resourceModel () {
        return new Role;
    }

    function resourceModelNameKey () {
        return "name";
    }

    function resourceName () {
        return "admin_role";
    }

    function resourceDescription () {
        return "角色";
    }

    function updateFillables () {
        return ['name', 'code', 'type', 'tel', 'description'];
    }

    // 获取角色列表
    function index(Auth $auth) {
        $user = $auth->user();
        $org_id = $user->org_id;
        $keywords = '%'.request('keywords').'%';
        $roles = Role::where('org_id', $org_id)->Where(function ($query) use ($keywords) {
            $query->where('name', 'like', $keywords)
                ->orWhere('code', 'like', $keywords);
        })->paginate(10);
        foreach ($roles as &$role) {
            $role->users;
            $role->user_count = $role->user_count();
        }
        return response()->page($roles);
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

    function storeCustom (Request $request, $admin) {
        return Role::create([
            'name' => $request->name,
            'code' => $request->code,
            'type' => 2,
            'org_id' => $admin->org_id,
            'tel' => $request->tel,
            'description' => $request->description
        ]);
    }

    function updateValidate (Request $request, $admin) {
        $admin_id = $admin->id;
        $this->validate($request, [
            'name' => "unique:admin_roles,name,NULL,id,org_id,{$admin_id}",
            'code' => "unique:admin_roles,code,NULL,id,org_id,{$admin_id}"
        ], [
            'name.unique' => '部门名称不能重复',
            'code.unique' => '部门编号不能重复'
        ]);
    }
}