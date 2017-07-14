<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminMenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            ['title' => '首页', 'is_top' => 1, 'order' => 0, 'uri' => '/index', 'icon' => 'home', 'sub' => [
                ['title' => '首页', 'sub' => [
                    ['title' => '总览', 'uri' => '/index', 'icon' => 'home']
                ]],
                ['title' => '统计数据', 'sub' => [
                    ['title' => '销售统计', 'uri' => '/index', 'icon' => 'home'],
                    ['title' => '经营统计', 'uri' => '/index', 'icon' => 'home']
                ]],
                ['title' => '日志', 'sub' => [
                    ['title' => '登录记录', 'uri' => '/index', 'icon' => 'home'],
                    ['title' => '操作记录', 'uri' => '/index', 'icon' => 'home']
                ]],
            ]],
            ['title' => '内容管理', 'is_top' => 1,'uri' => '/cms/index', 'icon' => 'ios-clock', 'sub' => [
                ['title' => '内容管理', 'sub' => [
                    ['title' => '概览', 'uri' => '/cms/index', 'icon' => 'ios-clock'],
                    ['title' => '发布文章', 'uri' => '/cms/push', 'icon' => 'plus-circled']
                ]],
                ['title' => '新闻公告', 'sub' => [
                    ['title' => '新闻内容', 'uri' => '/cms/news', 'icon' => 'ios-paper'],
                    ['title' => '通知公告', 'uri' => '/cms/notice', 'icon' => 'ios-bell'],
                    ['title' => 'FAQ', 'uri' => '/cms/faq', 'icon' => 'ios-help'],
                ]]
            ]],
            ['title' => '用户管理', 'is_top' => 1,'uri' => '/account/index', 'icon' => 'person-stalker', 'sub' => [
                ['title' => '用户管理', 'sub' => [
                    ['title' => '总览', 'uri' => '/account/index', 'icon' => 'person-stalker']
                ]],
                ['title' => '商户', 'sub' => [
                    ['title' => '商户管理', 'uri' => '/account/store', 'icon' => 'ribbon-b']
                ]],
                ['title' => '员工管理', 'sub' => [
                    ['title' => '角色管理', 'uri' => '/account/role', 'icon' => 'ios-browsers'],
                    ['title' => '员工资料', 'uri' => '/account/user', 'icon' => 'person-stalker']
                ]],
                ['title' => '同行资料', 'sub' => [
                    ['title' => '我的同行客户', 'uri' => '/account/frequenter', 'icon' => 'ios-people-outline'],
                    ['title' => '同行总览', 'uri' => '/account/frequenter_mine', 'icon' => 'ios-people']
                ]]
            ]],
            ['title' => '产品管理', 'is_top' => 1,'uri' => '/product/index', 'icon' => 'ios-browsers', 'sub' => [
                ['title' => '产品管理', 'sub' => [
                    ['title' => '概览', 'uri' => '/product/index', 'icon' => 'ios-clock'],
                    ['title' => '发布产品', 'uri' => '/product/push', 'icon' => 'plus-circled']
                ]],
                ['title' => '基础设定', 'sub' => [
                    ['title' => '目的地标签', 'uri' => '/product/setting/destination', 'icon' => 'ios-clock'],
                    ['title' => '报价字典', 'uri' => '/product/setting/price', 'icon' => 'ios-clock']
                ]],
                ['title' => '旅游线路', 'sub' => [
                    ['title' => '跟团游', 'uri' => '/product/tour/team', 'icon' => 'ios-clock'],
                    ['title' => '自由行', 'uri' => '/product/tour/self', 'icon' => 'ios-clock']
                ]],
                ['title' => '其它产品', 'sub' => [
                    ['title' => '机票', 'uri' => '/doc/log', 'icon' => 'ios-clock'],
                    ['title' => '酒店', 'uri' => '/doc/admin', 'icon' => 'ios-clock'],
                    ['title' => '门票', 'uri' => '/doc/admin', 'icon' => 'ios-clock'],
                    ['title' => '签证', 'uri' => '/doc/admin', 'icon' => 'ios-clock'],
                    ['title' => '租车', 'uri' => '/doc/admin', 'icon' => 'ios-clock']
                ]],
            ]],
//            ['title' => '产品管理', 'is_top' => 1, 'uri' => '/prod', 'icon' => 'ios-browsers'],
//            ['title' => '订单管理', 'is_top' => 1, 'uri' => '/order', 'icon' => 'android-menu'],
//            ['title' => '客户管理', 'is_top' => 1, 'uri' => '/cust', 'icon' => 'android-contact'],
            ['title' => '系统设置', 'is_top' => 1, 'uri' => '/setting/index', 'icon' => 'gear-b', 'sub' => [
                ['title' => '功能设置', 'sub' => [
                    ['title' => '总览', 'uri' => '/setting/index', 'icon' => 'home'],
                    ['title' => '账户设置', 'uri' => '/setting/account', 'icon' => 'home']
                ]],
                ['title' => '站点设置', 'sub' => [
                    ['title' => 'CMS', 'uri' => '/setting/domain/cms', 'icon' => 'home'],
                    ['title' => '直客网站', 'uri' => '/setting/domain/guest', 'icon' => 'home'],
                    ['title' => '后台设置', 'uri' => '/setting/domain/admin', 'icon' => 'home']
                ]],
                ['title' => '日志', 'sub' => [
                    ['title' => '登录记录', 'uri' => '/index', 'icon' => 'home'],
                    ['title' => '操作记录', 'uri' => '/index', 'icon' => 'home']
                ]]
            ]]
        ];

        DB::table('admin_menus')->truncate();
        foreach ($menus as $menu) {
            $only_menu = array_only($menu, ['title', 'is_top', 'order', 'uri', 'icon']);
            $menu_id = DB::table('admin_menus')->insertGetId($only_menu);
            if (array_key_exists('sub', $menu) && is_array($menu['sub']) && count($menu['sub']) > 0) $this->recursionCreate($menu_id, $menu['sub']);
        }
    }

    function recursionCreate ($parent_id, array $sub) {
        foreach ($sub as $menu) {
            $only_menu = array_only($menu, ['title', 'is_top', 'order', 'uri', 'icon']);
            $only_menu['parent_id'] = $parent_id;
            $menu_id = DB::table('admin_menus')->insertGetId($only_menu);
            if (array_key_exists('sub', $menu) && is_array($menu['sub']) && count($menu['sub']) > 0) $this->recursionCreate($menu_id, $menu['sub']);
        }
    }
}
