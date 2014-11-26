<?php

/**
 * Class ErrorController
 */
class ErrorController extends yaf_controller_abstract
{

    /**
     * @param $exception
     */
    public function errorAction($exception) {
        switch ($exception->getCode()) {
            case YAF_ERR_NOTFOUND_MODULE:          # 模块读取失败
            case YAF_ERR_NOTFOUND_CONTROLLER:
            case YAF_ERR_NOTFOUND_ACTION:
            case YAF_ERR_NOTFOUND_VIEW:
                // 404
                @header('HTTP/1.1 404 Not Found');
                @header('Status: 404 Not Found');
                $errorMsg = 'WOW，看来你遇到了一个问题，手抖打错地址了吧？';
                break;
            case '42S22':
                // 数据库异常
                $errorMsg = '数据库异常。';
                break;
            default :
                // 自定义的异常
                $errorMsg = '说起来你好像遇到一个未知的错误呢。';
                break;
        }
        $this->getView()->assign("exception", $exception);
        $this->getView()->assign("errorMsg", $errorMsg);
    }

}
