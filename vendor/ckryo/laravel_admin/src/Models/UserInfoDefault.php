<?php

namespace Ckryo\Laravel\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfoDefault extends Model
{
    protected $table = 'admin_user_info_defaults';
    protected $connection = 'mysql';
    public $timestamps = false;


    protected $primaryKey = 'user_id';


    protected $fillable = ['user_id', 'sex', 'qq', 'wechat', 'address', 'birthday'];

}