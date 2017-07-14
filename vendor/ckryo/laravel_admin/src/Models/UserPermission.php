<?php

namespace Ckryo\Laravel\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $table = 'admin_user_permissions';
    protected $connection = 'mysql';
    public $timestamps = false;
}
