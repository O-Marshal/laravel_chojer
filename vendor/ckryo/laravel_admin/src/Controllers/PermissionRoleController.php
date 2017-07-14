<?php

namespace Ckryo\Laravel\Admin\Controllers;


use Ckryo\Laravel\App\Http\Controllers\Controller;
use Ckryo\Laravel\Auth\Auth;
use Ckryo\Laravel\Admin\Models\Permission;
use Ckryo\Laravel\Admin\Models\Role;
use Ckryo\Laravel\Admin\Models\RolePermission;
use Ckryo\Laravel\Logi\Facades\Logi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// TO DO 细粒化权限判断
// 权限管理
class PermissionRoleController extends Controller
{

    function __construct()
    {
    }

    // 获取角色权限
    function show(Auth $auth, $role_id) {
        $permissions = Permission::tree($auth->user());
        foreach ($permissions as &$permission) {
            foreach ($permission['sub'] as &$item) {
                $item['selected'] = RolePermission::where('role_id', $role_id)->where('permission_id', $item['id'])->count() === 1;
            }
        }
        return response()->ok('数据获取成功', $permissions);
    }

    // 设置权限
    function update(Request $request, Auth $auth, $role_id) {
        $user = $auth->user();

        $permissions = $request->permissions;

        DB::transaction(function () use ($permissions, $user, $role_id) {
            $role = Role::find($role_id);
            $datas = [];
            foreach ($permissions as $group) {
                foreach ($group['sub'] as $item) {
                    if ($item['selected'] == true)
                    $datas[] = [
                        'role_id' => $role_id,
                        'permission_id' => $item['id']
                    ];
                }
            }
            RolePermission::where('role_id', $role_id)->delete();
            RolePermission::insert($datas);
            Logi::action($user->id, 'admin_role_permissions', $role_id, 'admin_role_permissions', '修改了角色权限:'.$role->name, json_encode($permissions, JSON_UNESCAPED_UNICODE));
        });
        return response()->ok('数据修改成功');
    }

}