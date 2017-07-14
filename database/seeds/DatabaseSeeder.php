<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan make:seeder AdminMenusTableSeeder
//        $this->call(AdminRolesTableSeeder::class);
//        $this->call(AdminUsersTableSeeder::class);
//        $this->call(AdminPermissionsTableSeeder::class);
        $this->call(AdminMenusTableSeeder::class);
//        $this->call(ProductTableSeeder::class);
    }
}
