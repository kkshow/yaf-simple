<?php

/**
 * Class Mod_Base
 * 继承medoo，此层实现一些通用的封装方法
 * @author 邝忠武 175156573qq.com
 */
class Mod_Base extends Db_Medoo
{

    function __construct($options = null, $pConfig = 'default') {
        parent::__construct($options, $pConfig);
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
        return $this->select($this->table, $field, $condition);
    }

    /**
     * 查询一行数据
     * @param array $condition
     * @param string $field
     * @return array
     */
    public function getRow($condition = [], $field = '*') {
        echo $this->table;
        return $this->get($this->table, $field, $condition);
    }

    /**
     * 查询一个字段值
     * @param array $condition
     * @param $field
     * @return string
     */
    public function getField($condition = [], $field) {
        if ($field) {
            $row = $this->getRow($condition, $field);
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
        if (!$this->pdo->beginTransaction()) {
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
            $this->pdo->commit();
        }
        return true;
    }

    /**
     * 事务回滚
     */
    public function back() {
        if ($this->_begin_transaction) {
            $this->_begin_transaction = false;
            $this->pdo->rollback();
        }
        return false;
    }
}