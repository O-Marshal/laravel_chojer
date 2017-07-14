<?php

namespace Ckryo\Laravel\Upload\Controllers;
use Ckryo\Laravel\App\Http\Controllers\Controller;
use Ckryo\Laravel\Auth\Auth;
use Ckryo\Laravel\Upload\Services\OSS;
use Illuminate\Http\Request;


class ImageController extends Controller
{

    function index(Auth $auth) {
        $path = 'org_'.$auth->user()->org_id.'/images/';
        $list = OSS::listAll($path);
        return response()->ok('ok', $list);
    }

    function store(Request $request, Auth $auth) {
        $ossKey = 'org_'.$auth->user()->org_id.'/images/'.date('YmdHis').str_random(6);
        $url = OSS::upload($ossKey, $request->file('image'));
        return response()->json([
            'url' => $url,
            'preview' => $url.'/100x100'
        ]);
    }

}