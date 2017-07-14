<?php
namespace Chojer\Laravel\Map\Models;
use Illuminate\Database\Eloquent\Model;


class DestinationCode extends Model
{
    protected $table = 'map_destination_codes';
    protected $connection = 'mysql';
    public $timestamps = false;

    function parent () {
        // 父表: 子表关联键 -> 父键
        return $this->belongsTo(DestinationGroup::class, 'group_id');
    }

    function children () {
        // 子表: 子表关联键 -> 父键
        return $this->hasMany(DestinationDest::class, 'code_id')->select('*', 'id as value', 'name as label');
    }

}