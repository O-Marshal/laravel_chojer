<?php

namespace Ckryo\Laravel\Cms\Controllers;

use Ckryo\Laravel\App\Http\Controllers\Controller;
use Ckryo\Laravel\Auth\Auth;
use Ckryo\Laravel\Cms\Models\CmsArticle;
use Ckryo\Laravel\Logi\Facades\Logi;
use Illuminate\Support\Facades\DB;

abstract class CmsController extends Controller
{

    protected $type = 'news';
    protected $description_key = "name";
    protected $description_name = "新闻";

    function index () {
        $result = CmsArticle::with('author')->where('type', $this->type)->orderBy('created_at', 'desc')->paginate(10);
        return response()->page($result);
    }

    function getModel () {
        return new CmsArticle();
    }

    function getDestroyMessageWithDatas ($sql) {
        return '删除了'.$sql->count().'条'.$this->description_name.'数据';
    }

    function getDestroyMessageWithSinge ($data) {
        $key = $this->description_key;
        return '删除了'.$this->description_name.':'.$data->$key;
    }

    function destroy (Auth $auth, $item_str) {
        $admin = $auth->user();
        $items = explode('|', $item_str);
        DB::transaction(function () use ($admin, $items) {
            $sqlWhere = $this->getModel()->whereIn('id', $items);
            $sqlData = $sqlWhere->get();
            if (count($sqlData) > 1) {
                Logi::action(0, 'cms', 0, 'deletes', $this->getDestroyMessageWithDatas($sqlData), json_encode($sqlData->toArray(), JSON_UNESCAPED_UNICODE));
            } elseif (count($sqlData) === 1) {
                $data = $sqlData->first();
                Logi::action($admin->id, 'cms', $data->id, 'delete', $this->getDestroyMessageWithSinge($data), json_encode($data->toArray(), JSON_UNESCAPED_UNICODE));
            }
            $sqlWhere->delete();
        });
        return response()->ok('操作成功');
    }

}