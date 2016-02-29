<?php
defined('DIR_SYSTEM') or exit('Access Invalid!');
/**
 * Class Front
 *
 */
final class Front {

	protected $registry;
	protected $pre_action = array();
	protected $error;

	public function __construct($registry) {
		$this->registry = $registry;
	}

    /**
     * 前置控制器，为了可用同时执行多个控制前
     * @param $pre_action
     */
    public function addPreAction($pre_action) {
		$this->pre_action[] = $pre_action;
	}

    /**
     * 调用
     * @param $action
     * @param $error
     */
    public function dispatch($action, $error) {
		$this->error = $error;
			
		foreach ($this->pre_action as $pre_action) {
			$result = $this->execute($pre_action);
					
			if ($result) {
				$action = $result;
				
				break;
			}
		}
			
		while ($action) {
			$action = $this->execute($action);
		}
  	}

    /**
     * 执行
     * @param $action
     * @return mixed
     */
    private function execute($action) {
		if (file_exists($action->getFile())) {
			require_once($action->getFile());
			
			$class = $action->getClass();
			$controller = new $class($this->registry);
			
			if (is_callable(array($controller, $action->getMethod()))) {
				$action = call_user_func_array(array($controller, $action->getMethod()), $action->getArgs());
			} else {
				$action = $this->error;
			
				$this->error = '';
			}
		} else {
			$action = $this->error;
			
			$this->error = '';
		}
		
		return $action;
	}
}