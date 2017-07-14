<?php

namespace Ckryo\Laravel\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = 'admin_user_personals';
    protected $connection = 'mysql';
    public $timestamps = false;

}