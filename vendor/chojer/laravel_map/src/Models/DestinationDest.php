<?php
namespace Chojer\Laravel\Map\Models;
use Illuminate\Database\Eloquent\Model;


class DestinationDest extends Model
{
    protected $table = 'map_destination_dests';
    protected $connection = 'mysql';
    public $timestamps = false;

    function parent () {
        // 父表: 子表关联键 -> 父键
        return $this->belongsTo(DestinationCode::class, 'code_id');
    }

}