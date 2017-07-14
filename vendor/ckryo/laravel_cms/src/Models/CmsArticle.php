<?php
/**
 * Created by PhpStorm.
 * User: liurong
 * Date: 2017/5/19
 * Time: 下午5:05
 */

namespace Ckryo\Laravel\Cms\Models;

use Ckryo\Laravel\Admin\Models\User;
use Illuminate\Database\Eloquent\Model;

class CmsArticle extends Model
{

    protected $table = 'cms_articles';
    protected $connection = 'mysql';

    protected $fillable = ['title', 'content', 'type', 'previews', 'author_id'];


    function author () {
        return $this->belongsTo(User::class, 'author_id')->select('id', 'name', 'role_id', 'org_id', 'avatar');
    }

}