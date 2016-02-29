<?php
defined('DIR_SYSTEM') or exit('Access Invalid!');
/**
 * Class Controller
 * 请求控制器
 */

abstract class Controller {
    protected $registry;
    protected $id;
    protected $layout;
    protected $template;
    protected $children = array();
    protected $data = array();
    protected $output;

    public function __construct($registry) {
        $this->registry = $registry;
    }

    public function __get($key) {
        return $this->registry->get($key);
    }

    public function __set($key, $value) {
        $this->registry->set($key, $value);
    }

    protected function forward($route, $args = array()) {
        return new Action($route, $args);
    }

    /**
     * 跳转
     * @param $url
     * @param int $status
     */
    protected function redirect($url, $status = 302) {
        header('Status: ' . $status);
        header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url));
        exit();
    }

    /**
     * 子类view
     * @param $child
     * @param array $args
     * @return mixed
     */
    protected function getChild($child, $args = array()) {
        $action = new Action($child, $args);

        if (file_exists($action->getFile())) {
            require_once($action->getFile());

            $class = $action->getClass();

            $controller = new $class($this->registry);

            $controller->{$action->getMethod()}($action->getArgs());

            return $controller->output;
        } else {
            trigger_error('错误: 找不到对应的控制器文件 ' . $child . '!');
            exit();
        }
    }

    /**
     * 渲染
     * @param $template
     * @return string
     */
    protected function render($template) {
        if(empty($template)){
            trigger_error('错误: 模板参数为空!');
            exit();
        }
        $this->template=$template;
        foreach ($this->children as $child) {
            $this->data[basename($child)] = $this->getChild($child);
        }
        $info = pathinfo($this->template);

        if(empty($info['extension'])){
            $this->template.=FILE_SUFFIX;
        }

        if (file_exists(DIR_APPLICATION .DIR_VIEW . DS . DIR_TEMPLATE . DS. $this->template)) {
            extract($this->data);

            ob_start();

            require(DIR_APPLICATION . DIR_VIEW . DS . DIR_TEMPLATE . DS. $this->template);

            $this->output = ob_get_contents();

            ob_end_clean();

            return $this->output;
        } else {
            trigger_error('错误: 没有找到模板 ' . DIR_APPLICATION . $this->template . '!');
            exit();
        }
    }

}