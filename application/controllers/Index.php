<?php
/**
 * Class IndexController
 * 入口类
 */
class IndexController extends Ctrl_Base {

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
        $dao = new IndexModel();
        $dao->insert("test", [
            "test" => md5(mt_rand().microtime(true))
        ]);
	}
}