<?php

namespace Ckryo\Laravel\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'admin_user_info_companies';
    protected $connection = 'mysql';
    public $timestamps = false;
}
