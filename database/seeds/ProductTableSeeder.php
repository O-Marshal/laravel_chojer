<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_dictionaries')->truncate();
        DB::table('product_dictionaries')->insert([
            ['name' => '跟团线路', 'key' => 'tour', 'parent_id' => 0],
            ['name' => '跟团游', 'key' => '/team', 'parent_id' => 1],
            ['name' => '自由行', 'key' => '/self', 'parent_id' => 1],
            ['name' => '自驾游', 'key' => '/ateam', 'parent_id' => 1],
            ['name' => '游轮', 'key' => '/bteam', 'parent_id' => 1],
            ['name' => '机票', 'key' => 'plane', 'parent_id' => 0]
        ]);
    }
}
