<?php

namespace Ckryo\Laravel\Admin\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    protected $table = 'admin_menus';
    protected $connection = 'mysql';
    public $timestamps = false;

    static private $var_tree = null;
    static private $var_top = [];
    static private $var_map = [];


    /**
     * 构建菜单树形结构
     *
     * @param User $user
     * @return array 菜单数组
     */
    static function tree($user) {
        if (static::$var_tree) return self::$var_tree;
        return static::$var_tree = static::where('is_top', 1)->where('parent_id', 0)->get();
    }

    static function formart(Collection $col) {
        $menus = [];
        foreach ($col as $item) {
            // 格式化 top 结构
            if ($item->is_top == 1) {
                $key = '_'.$item->id;
                $tmp = [
                    'title' => $item->title,
                    'is_top' => $item->is_top,
                    'parent_id' => $item->parent_id,
                    'uri' => $item->uri,
                    'icon' => $item->icon
                ];
                if (count($item->sub) > 0) {
                    $sub = static::formart($item->sub);
                    if (count($sub) > 0) {
                        $tmp['sub'] = $sub;
                    }
                }
                $menus[$key] = $tmp;
            } else {
                // 格式化 map
                $parent = $item->parent;
                $key = '_'.$parent->id;
                $item['key'] = '_'.$item->id;
                if (!array_key_exists($key, static::$var_map)) {
                    static::$var_map[$key] = [];
                }
                array_push(static::$var_map[$key], $item);
            }
        }
        return $menus;
    }

    static public function buildMenuTop($user) {
        if (count(static::$var_top) === 0) {
            return static::$var_top = static::formart(static::tree($user));
        }
        return static::$var_top;

    }

    static function buildMenuMap ($user) {
        if (count(static::$var_map) === 0) {
            static::formart(static::tree($user));
        }
        return static::$var_map;
    }

    static function UriTops () {
        $uris = static::where('is_top', 1)->where('parent_id', 0)->whereNotNull('uri')->select('id', 'title', 'uri')->get();
        $result = [];
        foreach ($uris as $uri) $result[$uri['uri']] = $uri;
        return $result;
    }
    static function Uris () {
        $uris = static::where('is_top', 0)->whereNotNull('uri')->select('id', 'title', 'uri')->get();
        $result = [];
        foreach ($uris as $uri) $result[$uri['uri']] = $uri;
        return $result;
    }

    function parent () {
        // 父表: 子表关联键 -> 父键
        return $this->belongsTo(static::class, 'parent_id')->select('id', 'title', 'uri', 'icon');
    }

    function sub () {
        // 子表: 子表关联键 -> 父键
        return $this->hasMany(static::class, 'parent_id');
    }

    public function getTreeAttribute($value)
    {
        $this->sub;
    }
}