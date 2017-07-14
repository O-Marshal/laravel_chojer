<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_users')->truncate();
        DB::table('admin_users')->insert([
            ['role_id' => 1, 'name' => '虫茧科技', 'account' => 'admin', 'password' => bcrypt('admin123')],
            ['role_id' => 1, 'name' => '虫茧科技', 'account' => 'api', 'password' => bcrypt('api123')],
        ]);
    }
}
