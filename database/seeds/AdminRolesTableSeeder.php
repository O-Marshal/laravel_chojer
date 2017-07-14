<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_roles')->truncate();
        DB::table('admin_roles')->insert([
            ['code' => 'admin', 'name' => '总管理员'],
            ['code' => 'dev', 'name' => '开发者'],
            ['code' => 'org', 'name' => '品牌管理员'],
            ['code' => 'provider', 'name' => '供应商'],
            ['code' => 'travel', 'name' => '旅行社'],
            ['code' => 'store', 'name' => '普通商户'],
            ['code' => 'person', 'name' => '直客'],
            ['code' => 'open', 'name' => '开放平台用户'],
        ]);
    }
}
