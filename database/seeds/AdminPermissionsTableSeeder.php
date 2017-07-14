<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['key' => 'user', 'name' => '用户管理', 'sub' => [
                ['key' => 'index', 'name' => '查询'],
                ['key' => 'make', 'name' => '创建/删除'],
                ['key' => 'use', 'name' => '禁用/启用'],
                ['key' => 'permission', 'name' => '设定权限']
            ]],
            ['key' => 'provider', 'name' => '供应商管理', 'sub' => [
                ['key' => 'index', 'name' => '查询'],
                ['key' => 'make', 'name' => '创建/删除'],
                ['key' => 'use', 'name' => '禁用/启用'],
                ['key' => 'permission', 'name' => '设定权限']
            ]],
            ['key' => 'agent', 'name' => '分销商管理', 'sub' => [
                ['key' => 'index', 'name' => '查询'],
                ['key' => 'make', 'name' => '创建/删除'],
                ['key' => 'use', 'name' => '禁用/启用'],
                ['key' => 'permission', 'name' => '设定权限']
            ]],
            ['key' => 'product', 'name' => '产品管理', 'sub' => [
                ['key' => 'index', 'name' => '查询'],
                ['key' => 'make', 'name' => '创建/编辑'],
                ['key' => 'push', 'name' => '发布管理'],
                ['key' => 'permission', 'name' => '设定权限']
            ]],
            ['key' => 'agent', 'name' => '订单管理', 'sub' => [
                ['key' => 'index', 'name' => '查询'],
                ['key' => 'make', 'name' => '创建/删除'],
                ['key' => 'use', 'name' => '禁用/启用'],
                ['key' => 'permission', 'name' => '设定权限']
            ]]
        ];

        DB::table('admin_permissions')->truncate();
        foreach ($permissions as $permission) {
            $only_permission = array_only($permission, ['key', 'name', 'description']);
            $permission_id = DB::table('admin_permissions')->insertGetId($only_permission);
            $sub = array_map(function ($item) use ($permission_id) {
                $item['parent_id'] = $permission_id;
                return $item;
            }, $permission['sub']);
            DB::table('admin_permissions')->insert($sub);
        }
    }
}
