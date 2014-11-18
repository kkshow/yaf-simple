<?php

/**
 * Class Orm_Base
 * 继承medoo，此层实现一些通用的封装方法
 * @author 邝忠武 175156573qq.com
 */
class Orm_Base extends Db_Medoo{

    function init(){
        parent::init();
    }

    /**
     * 事务标志位
     */
    private $_begin_transaction = false;

    /**
     * 事务开启
     */
    function begin(){
        # 已经有事务，退出事务
        $this->back();
        if(!$this->pdo->beginTransaction()){
            return false;
        }
        $this->_begin_transaction = true;
        return true;
    }

    /**
     * 事务提交
     */
    function commit(){
        if($this->_begin_transaction) {
            $this->_begin_transaction = false;
            $this->pdo->commit();
        }
        return true;
    }

    /**
     * 事务回滚
     */
    function back(){
        if($this->_begin_transaction) {
            $this->_begin_transaction = false;
            $this->pdo->rollback();
        }
        return false;
    }
}