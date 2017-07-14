<?php

namespace Ckryo\Laravel\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'admin_users';
    protected $connection = 'mysql';

    protected $fillable = ['website_id', 'org_id', 'role_id', 'name', 'post', 'email', 'mobile', 'avatar', 'account', 'password'];

    // 角色信息
    function role () {
        return $this->belongsTo(Role::class);
    }

    // 组织信息
    function org () {
        // 父表: 子表关联键 -> 父键
        return $this->belongsTo(static::class, 'org_id');
    }

    // 组织ID
    public function getOrgIdAttribute($value)
    {
        return intval($value) ?: $this->id;
    }

    public function info () {
        switch (strtoupper($this->role->code)) {
            case 'ADMIN':
                return $this->hasOne(UserInfoCompany::class);
        }
        return $this->hasOne(UserInfoDefault::class);
    }

    public function userInfo () {
        return $this->hasOne(UserInfoDefault::class);
    }

    // 用户列表 - 子账号列表
    function users() {
        return $this->hasMany(User::class, 'org_id', 'org_id');
    }
}