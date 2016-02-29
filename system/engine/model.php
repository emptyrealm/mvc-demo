<?php
defined('DIR_SYSTEM') or exit('Access Invalid!');
/**
 * Created by JetBrains PhpStorm.
 * User: lance
 * Time: 下午2:05
 * To change this template use File | Settings | File Templates.
 */
abstract class Model {
    protected $registry;

    public function __construct($registry) {
        $this->registry = $registry;
    }

    public function __get($key) {
        return $this->registry->get($key);
    }

    public function __set($key, $value) {
        $this->registry->set($key, $value);
    }
}