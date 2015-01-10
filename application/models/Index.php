<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2014/11/11
 * Time: 18:59
 */
class IndexModel extends Mod_Base
{

    function __construct($options = null, $pConfig = 'default') {
        parent::__construct($options, $pConfig);
    }

    public $table = 'test';
}