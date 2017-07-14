<?php

namespace Ckryo\Laravel\Cms\Controllers;

use Ckryo\Laravel\App\Http\Controllers\Controller;
use Ckryo\Laravel\Auth\Auth;
use Ckryo\Laravel\Cms\Models\CmsArticle;
use Ckryo\Laravel\Logi\Facades\Logi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// 用于文件、附件上传
class PushController extends Controller
{

    function store(Request $request, Auth $auth) {
        $this->validate($request, [
            'title' => "required",
            'content' => "required"
        ], [
            'title.required' => '标题不能为空',
            'content.required' => '内容不能为空',
        ]);

        DB::transaction(function () use ($request, $auth) {
            $admin = $auth->user();
            $art = CmsArticle::create([
                'title' => $request->title,
                'content' => $request->content,
                'type' => $request->type,
                'previews' => $request->previews,
                'author_id' => $admin->id
            ]);

            Logi::action($admin->id, 'cms_article', $art->id, 'create:'.$request->type, '发布了文章:'.$request->title, json_encode($request->all(), JSON_UNESCAPED_UNICODE));
        });

        return response()->ok('发布成功', '/cms/'.$request->type);
    }

}