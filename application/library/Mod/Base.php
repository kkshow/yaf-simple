<?php

/**
 * Class Mod_Base
 * 继承medoo，此层实现一些通用的封装方法
 * @author 邝忠武 175156573qq.com
 */
class Mod_Base
{

    function __construct($options = null, $pConfig = 'default') {

        // 实例化DB操作类
        $this->db = DB_USE ? $this->getInstance($options, $pConfig) : $this;
    }

    /**
     * 未定义函数处理
     * 如果未启用数据库连接调用数据库操作方法时，提示错误
     * @param $pMethod
     * @param $pArgs
     * @throws Exception
     */
    function __call($pMethod, $pArgs) {
        if (!DB_USE) {
            $tempDb = new Db_Medoo();
            if (method_exists($tempDb, $pMethod)) {
                throw new Exception('未启用数据库连接，需要将配置文件中的db.use设置为1。');
            }
        }
        throw new Exception('未定义的方法');
    }

    public $db;
    public static $instance = [];

    /**
     * 获取数据库实例
     * @param null $options
     * @param string $pConfig
     */
    public function getInstance($options = null, $pConfig = 'default') {

        if (!isset(self::$instance[$pConfig])) {
            self::$instance[$pConfig] = new Db_Medoo($options);
        };
        return self::$instance[$pConfig];
    }

    public $pk = 'id';
    public $table;

    /*********************************** 封装的查询方法 ****************************************/

    /**
     * 查询列表信息
     * @param array $condition
     * @param string $field
     * @return array
     */
    public function getList($condition = [], $field = '*') {
        return $this->db->select($this->table, $field, $condition);
    }

    /**
     * 查询一行数据
     * @param array $condition
     * @param string $field
     * @return array
     */
    public function getRow($condition = [], $field = '*') {
        return $this->db->get($this->table, $field, $condition);
    }

    /**
     * 查询一个字段值
     * @param array $condition
     * @param $field
     * @return string
     */
    public function getField($condition = [], $field) {
        if ($field) {
            $row = $this->db->getRow($condition, $field);
            return $row[$field];
        } else {
            return '';
        }
    }

    /*********************************** 事务处理部分 ****************************************/

    /**
     * 事务标志位
     */
    private $_begin_transaction = false;

    /**
     * 事务开启
     */
    public function begin() {
        # 已经有事务，退出事务
        $this->back();
        if (!$this->db->pdo->beginTransaction()) {
            return false;
        }
        $this->_begin_transaction = true;
        return true;
    }

    /**
     * 事务提交
     */
    public function commit() {
        if ($this->_begin_transaction) {
            $this->_begin_transaction = false;
            $this->db->pdo->commit();
        }
        return true;
    }

    /**
     * 事务回滚
     */
    public function back() {
        if ($this->_begin_transaction) {
            $this->_begin_transaction = false;
            $this->db->pdo->rollback();
        }
        return false;
    }
}