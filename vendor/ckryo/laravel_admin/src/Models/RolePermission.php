<?php

namespace Ckryo\Laravel\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $table = 'admin_role_permissions';
    protected $connection = 'mysql';
    public $timestamps = false;
}
