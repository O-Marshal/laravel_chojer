<?php

namespace Ckryo\Laravel\Upload\Controllers;

use Ckryo\Laravel\App\Http\Controllers\Controller;
use Ckryo\Laravel\Auth\Auth;
use Ckryo\Laravel\Upload\Services\OSS;
use Illuminate\Http\Request;

// 用于文件、附件上传
class AvatarController extends Controller
{

    function store(Request $request, Auth $auth) {
        $ossKey = 'setting/avatar/user_'.$auth->user()->id.'/avatar_'.date('YmdHis');
        $url = OSS::upload($ossKey, $request->file('avatar'));
        return response()->json([
            'url' => $url,
            'preview' => $url.'/100x100'
        ]);
    }

}