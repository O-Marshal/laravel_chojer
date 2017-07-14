<?php
namespace Ckryo\Laravel\Logi\Models;
use Illuminate\Database\Eloquent\Model;


class LogiActionModel extends Model
{
    protected $table = 'logi_actions';
    protected $connection = 'mysql';
    public $timestamps = false;
}