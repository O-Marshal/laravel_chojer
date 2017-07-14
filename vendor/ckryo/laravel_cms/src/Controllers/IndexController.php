<?php

namespace Ckryo\Laravel\Cms\Controllers;

use Ckryo\Laravel\App\Http\Controllers\Controller;
use Ckryo\Laravel\Cms\Models\CmsArticle;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{

    function index () {
        $result = CmsArticle::select('type', DB::raw('count(id) as count'))->groupBy('type')->get()->toArray();
        $new_array = [];
        foreach ($result as $item) $new_array[$item['type']] = $item['count'];
        return response()->data($new_array);
    }

}