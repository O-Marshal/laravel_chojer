<?php

namespace Ckryo\Laravel\Admin\Controllers;


use Ckryo\Laravel\App\Http\Controllers\Controller;
use Ckryo\Laravel\Auth\Auth;
use Ckryo\Laravel\Admin\Models\Permission;
use Ckryo\Laravel\Admin\Models\Role;
use Ckryo\Laravel\Logi\Facades\Logi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// 权限管理
class PermissionUserController extends Controller
{

    function __construct()
    {
    }

    // 获取角色列表
    function index(Auth $auth) {
        return response()->ok('数据获取成功', Permission::tree($auth->user()));
    }

    // 创建部门
    function store (Request $request, Auth $auth) {

        $user = $auth->user();
        $org_id = $user->org_id;

        $this->validate($request, [
            'name' => "required|unique:admin_roles,name,NULL,id,org_id,{$org_id}",
            'code' => "required|unique:admin_roles,code,NULL,id,org_id,{$org_id}"
        ], [
            'name.required' => '部门名称不能为空',
            'name.unique' => '部门名称不能重复',
            'code.required' => '部门编号不能为空',
            'code.unique' => '部门编号不能重复'
        ]);


        DB::transaction(function () use ($request, $user) {
            $role = Role::create([
                'name' => $request->name,
                'code' => $request->code,
                'type' => 2,
                'org_id' => $user->org_id,
                'tel' => $request->tel,
                'description' => $request->description
            ]);
            Logi::action($role->id, 'admin_role', $role->id, 'create', '创建了角色:'.$role->name, json_encode($request->all(), JSON_UNESCAPED_UNICODE));
        });
        return response()->ok('部门创建成功');
    }

    function update(Request $request, Auth $auth, $role_id) {
        $user = $auth->user();
        $org_id = $user->org_id;

        $this->validate($request, [
            'name' => "unique:admin_roles,name,NULL,id,org_id,{$org_id}",
            'code' => "unique:admin_roles,code,NULL,id,org_id,{$org_id}"
        ], [
            'name.unique' => '部门名称不能重复',
            'code.unique' => '部门编号不能重复'
        ]);

        $updates = [];
        foreach ($request->only(['name', 'code', 'tel', 'description']) as $key => $value) {
            if ($value) $updates[$key] = $value;
        }

        if (count($updates) === 0) {
            return response()->ok('未修改任何数据');
        }

        DB::transaction(function () use ($updates, $user, $role_id) {
            $role = Role::find($role_id);
            if (!$role) throw new \Exception('非法操作,角色不存在');
            foreach ($updates as $key => $value) {
                $role->$key = $value;
            }
            $role->save();
            Logi::action($role->id, 'admin_role', $role->id, 'create', '修改了角色信息:'.$role->name, json_encode($updates, JSON_UNESCAPED_UNICODE));
        });
        return response()->ok('数据修改成功');
    }

    function destroy ($role_str) {
        $roles = explode('|', $role_str);
        DB::transaction(function () use ($roles) {
            $roleWhere = Role::whereIn('id', $roles);
            $roleCols = $roleWhere->get();
            if (count($roleCols) > 1) {
                Logi::action(0, 'admin_role', 0, 'deletes', "删除了".$roleCols->count()."个角色", json_encode($roleCols->toArray(), JSON_UNESCAPED_UNICODE));
            } elseif (count($roleCols) === 1) {
                $role = $roleCols->first();
                Logi::action($role->id, 'admin_role', $role->id, 'delete', "删除了角色:".$role->name, json_encode($roleCols->toArray(), JSON_UNESCAPED_UNICODE));
            }
            $roleWhere->delete();
        });
        return response()->ok('操作成功');
    }

}