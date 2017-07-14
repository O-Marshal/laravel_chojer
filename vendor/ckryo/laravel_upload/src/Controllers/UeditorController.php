<?php

namespace Ckryo\Laravel\Upload\Controllers;

use Ckryo\Laravel\App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// 用于文件、附件上传
class UeditorController extends Controller
{

    function index(Request $request)
    {
        $configPath = __DIR__ . '/../../config/ueditor.json';
        $config_str = str_replace('$PREFIX_URL', env('UE_PREFIX_URL', '/'), preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents($configPath)));
        $config = json_decode($config_str, true);
        return response()->json($config, 200, [], JSON_UNESCAPED_UNICODE);
    }
}