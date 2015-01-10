<?php

/**
 * Class IndexController
 * 入口类
 */
class IndexController extends Ctrl_Base
{

    /**
     * 初始化方法
     */
    public function init() {
        parent::init(); // 初始化
    }

    /**
     * 默认方法
     */
    public function indexAction() {
        // 禁用模板
        Yaf_Dispatcher::getInstance()->disableView();

        $dao = new IndexModel();
        var_dump($dao->getRow(['id' => 88]));
    }
}