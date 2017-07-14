<?php

namespace Ckryo\Laravel\Handler;

class ErrorCode
{

    private $errorCodes = [];
    private $errorMaps = [];
    private $errorModels = [];

    private $defaultMessage = '系统发生错误';

    /**
     * 注册错误码信息
     *
     * @param string $modelName 模块名称
     * @param array $codes 错误码对照字典
     */
    public function regist($modelName,Array $codes) {
        $this->errorModels[strtoupper($modelName)] = $codes;
        foreach ($codes as $key => $val) {
            $this->errorCodes[$key] = $val;
            $this->errorMaps[$key] = $modelName;
        }
    }

    public function getErrMsg($code) {
        if (array_key_exists($code, $this->errorCodes)) {
            return $this->errorCodes[$code];
        }
        return $this->defaultMessage;
    }

    public function getErrorCodes() {
        return $this->errorCodes;
    }


}