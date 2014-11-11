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
        $rs = $dao->select("account", "user_name", [
            "user_id" => 1
        ]);
        var_dump($rs);
	}
}