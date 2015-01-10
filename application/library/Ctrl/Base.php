<?php
/**
 * 控制器 基础类
 * @author 张洋 2050479@qq.com
 */
abstract class Ctrl_Base extends Yaf_Controller_Abstract {
    /**
     * c层构造方法
     */
    function init(){
        /**
         * 如果是Ajax请求, 则关闭HTML输出
         */
        if ($this->getRequest()->isXmlHttpRequest()) {
            Yaf_Dispatcher::getInstance()->disableView();
        }
    }

    /********************** START 列表增删改查 ************************/
    /**
     * 列表
     */
    public function indexAction(){
        #空方法,系统直接调用index.phtml
        #通常调试yaf也在这里啦
    }

    /**
     * 列表取数方法
     */
    function pageJsonAction(){
    }

    /**
     * 列表取数 - 无分页
     */
    function listJsonAction(){
    }

    /**
     * 增、改
     * @param int $id
     */
    public function saveAction($id=0){
    }

    /**
     * 删除
     * @param int $id
     */
    public function delAction($id=0){
    }

    /********************** END 列表增删改查 ************************/

    /**
     * 注册变量到模板
     * @param str|array $pKey
     * @param mixed $pVal
     */
    public function assign($pKey, $pVal = '') {
        if (is_array($pKey)) {
            return $this->_view->assign($pKey);
        }
        $this->_view->assign($pKey, $pVal);
    }
}