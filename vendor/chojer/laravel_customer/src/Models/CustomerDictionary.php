<?php
namespace Chojer\Laravel\Customer\Models;

use Illuminate\Database\Eloquent\Model;


class CustomerDictionary extends Model
{
    protected $table = 'customer_dictionaries';
    protected $connection = 'mysql';
    public $timestamps = false;

    static function tree () {
        return static::with('children')->where('parent_id', 0)->select('*', 'id as value', 'name as label')->get();
    }

    function children () {
        return $this->hasMany(static::class, 'parent_id')->select('*', 'id as value', 'name as label');
    }

    public function parent () {
        return $this->belongsTo(static::class, 'parent_id');
    }

}