<?php

namespace Ckryo\Laravel\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Permission extends Model
{
    protected $table = 'admin_permissions';
    protected $connection = 'mysql';
    public $timestamps = false;

    static function tree (User $user) {
        return static::where('parent_id', 0)->get()->toArray();
    }

    public function sub () {
        return $this->hasMany(static::class, 'parent_id')->select('id', 'key', 'name');
    }

    public function getDescriptionAttribute($value)
    {
        $this->sub;
    }
}