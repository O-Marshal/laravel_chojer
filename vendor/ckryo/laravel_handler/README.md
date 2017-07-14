# laravel_handler

错误处理及错误码管理

## 使用方式:
1. 引入包
```
composer require ckryo/laravel_hander
```
2. 注册服务容器
```
\Ckryo\Laravel\Handler\HandlerServiceProvider::class
```
3. 获取**errorcode.php**配置文件
```
php artisan vendor:publish
```

## 在自己的模块中使用

1. 新建一个 **errCode.php** 文件
```
/**
 * 登录授权错误码
 * 代码范围 200 - 399
 *
 * 登录授权 200 - 299
 * 权限验证 300 - 399
 */
return [
    'auth' => [
        '200' => '授权信息验证失败, 需要重新登录',
        '201' => '账号异地登录提醒',
        '210' => '账号不存在',
        '211' => '账号密码错误',
        '212' => '账号被禁用, 无法使用',
        '240' => '当前账号不属于该平台,无法从此处登录'
    ],
    'permission' => [
        '300' => '当前账号无权进行此操作'
    ]
];
```
2. 在服务容器中注册错误码 serviceprovider.php
```
$errCodes = require __DIR__.'/../config/errCode.php';
foreach ($errCodes as $model => $codes) {
    $errorCode->regist($model, $codes);
}
```

3. 在代码中抛出异常
```
throw new ErrorCodeException(200);
// 或者
throw new ErrorCodeException(错误码, '错误描述', '错误详情');
```
4. 使用 **handler** 处理错误信息
```
$this->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    \Ckryo\Laravel\Handler\Handler::class
);
```

## 你也可以进行二次开发
1. 创建自己的**Exception**

创建Exception需要实现 `\Ckryo\Laravel\Handler\Contracts\ExceptionFactory` 接口;
该接口只申明了一个`handle()` 函数,用于返回响应信息。
```
<?php

namespace Ckryo\Laravel\Handler;

use Ckryo\Laravel\Handler\Contracts\ExceptionFactory;
use Ckryo\Laravel\Handler\Facades\ErrorCode;

class ErrorCodeException extends \Exception implements ExceptionFactory
{
    protected $code;
    protected $message;
    protected $data;

    public function __construct($code, $message = null, $data = null)
    {
        $this->code = $code;
        $this->data = $data ?: $this;
        $this->message = $message ?: ErrorCode::getErrMsg($code);
    }

    public function handle()
    {
        return response()->json([
            'errCode' => $this->code,
            'errMsg' => $this->message,
            'data' => $this->data
        ]);
    }
}
```

2. 你也可以自定义 **Handler**

具体请参考[laravel源码及文档](http://d.laravel-china.org/docs/5.4)