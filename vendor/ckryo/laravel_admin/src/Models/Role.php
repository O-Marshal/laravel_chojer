<?php

namespace Ckryo\Laravel\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $table = 'admin_roles';
    protected $connection = 'mysql';
    public $timestamps = false;

    protected $fillable = ['name', 'code', 'type', 'org_id', 'tel', 'description'];


    // 用户列表
    function users() {
        return $this->hasMany(User::class, 'role_id');
    }

    // 用户合计
    function user_count() {
        return $this->users->count();
    }


    /**
     * 创建角色核心方法
     *
     * @param $name
     * @param $description
     * @param int $role_id
     * @param int $org_id
     * @param int $type
     * @param int $template_id
     * @return bool
     */
    private function createRole($name, $description, $role_id = 0, $org_id = 0, $type = 0, $template_id = 0) {
        $this->name = $name;
        $this->description = $description;
        $this->role_id = $role_id;
        $this->org_id = $org_id;
        $this->type = $type;
        $this->template_id = $template_id;
        return $this->save();
    }

    /**
     * 创建管理员或开发者角色
     *
     * @param $name 角色名称
     * @param $description 描述
     * @param int $role_id 父级角色
     * @return mixed
     */
    static function createByAdminWithPrivate($name, $description, $role_id = 0) {
        return (new static)->createRole($name, $description, $role_id);
    }

    /**
     * 开放角色, 供用户注册
     *
     * @param $name 角色名称
     * @param $description 描述
     * @param int $role_id 父级角色
     * @return mixed
     */
    static function createByAdminWithPublic($name, $description, $role_id = 0) {
        return (new static)->createRole($name, $description, $role_id);
    }

    static function ArtisanList($role_id = 0) {
        return static::where('org_id', 0)->where('role_id', $role_id)->get();
    }

}