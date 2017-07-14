<?php
namespace Chojer\Laravel\Map\Models;
use Illuminate\Database\Eloquent\Model;


class DestinationGroup extends Model
{
    protected $table = 'map_destination_groups';
    protected $connection = 'mysql';
    public $timestamps = false;

    function children () {
        // 子表: 子表关联键 -> 父键
        return $this->hasMany(DestinationCode::class, 'group_id')->with('children')->select('*', 'id as value', 'name as label');
    }

}