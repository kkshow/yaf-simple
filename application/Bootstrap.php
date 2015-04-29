<?php

/**
 * Bootstrap类, 在这个类中, 所以以_init开头的方法
 * 都会被调用, 调用次序和申明次序相同
 */
class Bootstrap extends Yaf_Bootstrap_Abstract
{

    /**
     * 把配置存到注册表
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initConfig(Yaf_Dispatcher $dispatcher) {
        Yaf_Registry::set("config", Yaf_Application::app()->getConfig());
        define('PATH_APP', Yaf_Registry::get("config")->application->directory);
        define('PATH_TPL', PATH_APP . '/views');

        // 初始化项目访问路径
        $baseUrl = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
        $baseUrl .= '://' . $_SERVER['HTTP_HOST'];
        define('PATH_BASE', $baseUrl);                                                             # 项目访问路径

        // 初始化数据库的配置
        define('DB_USE', Yaf_Registry::get("config")->db->use);                                    # 是否已用数据库
        define('DB_TYPE', Yaf_Registry::get("config")->db->dbtype);                                # 数据库类型
        define('DB_HOST', Yaf_Registry::get("config")->db->host->master);                          # 主库地址
        define('DB_PORT', Yaf_Registry::get("config")->db->port);                                  # 端口号
        define('DB_NAME', Yaf_Registry::get("config")->db->dbname);                                # 数据库名
        define('DB_USERNAME', Yaf_Registry::get("config")->db->username);                          # 用户名称
        define('DB_PASSWORD', Yaf_Registry::get("config")->db->password);                          # 用户密码
        define('DB_CHARSET', Yaf_Registry::get("config")->db->charset);                            # 数据库编码

        // 初始化文件路径
        define('PATH_JS', PATH_BASE . Yaf_Registry::get("config")->host->js);                      # js目录
        define('PATH_CSS', PATH_BASE . Yaf_Registry::get("config")->host->css);                    # css目录
        define('PATH_IMG', PATH_BASE . Yaf_Registry::get("config")->host->img);                    # images目录
        define('PATH_RESOURCES', PATH_BASE . Yaf_Registry::get("config")->host->resources);        # 公用资源目录
        define('PATH_STATIC', PATH_BASE . Yaf_Registry::get("config")->host->static);              # 自建静态资源

        define('PATH_HELPER', __DIR__ . '/helper');                                                # helper目录
    }

    /**
     * 路由配置
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initRoute(Yaf_Dispatcher $dispatcher) {
        // 添加配置中的路由
        $router = Yaf_Dispatcher::getInstance()->getRouter();
        $router->addConfig(Yaf_Registry::get("config")->routes);
    }
}