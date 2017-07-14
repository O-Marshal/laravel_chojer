<?php

namespace Ckryo\Laravel\Http;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class HttpServiceProvider extends ServiceProvider
{

    public function boot () {

        $json_headers = [
            'Content-Type' => 'application/json'
        ];

        Response::macro('ok', function ($msg = '操作成功', $data = null) use ($json_headers) {
            return Response::make(json_encode([
                'errCode' => 0,
                'errMsg' => $msg,
                'data' => $data
            ], JSON_UNESCAPED_UNICODE), 200)->withHeaders($json_headers);
        });

        Response::macro('data', function ($data = null) use ($json_headers) {
            return Response::make(json_encode([
                'errCode' => 0,
                'errMsg' => '操作成功',
                'data' => $data
            ], JSON_UNESCAPED_UNICODE), 200)->withHeaders($json_headers);
        });

        Response::macro('page', function ($result) use ($json_headers) {
            return Response::make(json_encode([
                'errCode' => 0,
                'errMsg' => 'ok',
                'datas' => $result->items(),
                'page' => [
                    'total' => $result->total(),
                    'per_page' => $result->perPage(),
                    'current_page' => $result->currentPage()
                ]
            ], JSON_UNESCAPED_UNICODE), 200)->withHeaders($json_headers);
        });
    }

}