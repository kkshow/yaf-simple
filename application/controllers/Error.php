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
        echo $exception->getCode();
        switch ($exception->getCode()) {
            case 0 :
                // 未定义的类型
                $errorMsg = $exception->getMessage();
                break;
            # 模块、控制层、动作、视图层读取失败
            case 515: // YAF_ERR_NOTFOUND_MODULE
            case 516: // YAF_ERR_NOTFOUND_CONTROLLER
            case 517: // YAF_ERR_NOTFOUND_ACTION
            case 518: // YAF_ERR_NOTFOUND_VIEW
                // 404
                @header('HTTP/1.1 404 Not Found');
                @header('Status: 404 Not Found');
                $errorMsg = 'WOW，看来你遇到了一个问题，手抖打错地址了吧？';
                break;
            default :
                // 自定义的异常
                $errorMsg = $exception->getMessage();
                break;
        }
        $this->getView()->assign("exception", $exception);
        $this->getView()->assign("errorMsg", $errorMsg);
        $this->display('error');
    }
}
