<?php
defined('DIR_SYSTEM') or exit('Access Invalid!');
/**
 * Created by JetBrains PhpStorm.
 * User: lance
 * Time: 下午12:21
 * To change this template use File | Settings | File Templates.
 */



define('FILE_SUFFIX','.php');
define('DIR_ENGINE','engine');
define('DIR_LIBRARY','library');
define('DIR_HELPER','helper');
define('DIR_MODEL','model');
define('DIR_CONTROLLER','controller');
define('DIR_DATABASE','database');
define('DIR_STYLESHEET','stylesheet');
define('DIR_CONFIG','config');
define('DIR_VIEW','view');
define('DIR_TEMPLATE','template');
define('DIR_IMAGE','image');
define('DIR_JAVASCRIPT','javascript');

define('SRC_JAVASCRIPT', DIR_APPLICATION.DIR_VIEW.DS.DIR_JAVASCRIPT.DS);
define('SRC_STYLESHEET', DIR_APPLICATION.DIR_VIEW.DS.DIR_STYLESHEET.DS);

// config
require_once(DIR_APPLICATION.DIR_CONFIG. DS .'config.php');

// Engine
require_once(DIR_SYSTEM . DIR_ENGINE . DS .'loader.php');
require_once(DIR_SYSTEM . DIR_ENGINE . DS .'controller.php');
require_once(DIR_SYSTEM . DIR_ENGINE . DS .'model.php');
require_once(DIR_SYSTEM . DIR_ENGINE . DS .'action.php');
require_once(DIR_SYSTEM . DIR_ENGINE . DS .'front.php');
require_once(DIR_SYSTEM . DIR_ENGINE . DS .'registry.php');
require_once(DIR_SYSTEM . DIR_ENGINE . DS .'response.php');

//Library
require_once(DIR_SYSTEM . DIR_LIBRARY . DS .'request.php');
require_once(DIR_SYSTEM . DIR_LIBRARY . DS .'db.php');

//用于注册obj
$registry = new Registry();

//加载
$loader = new Loader($registry);
$registry->set('load', $loader);

//http请求
$request = new Request();
$registry->set('request', $request);

// Response
$response = new Response();
$response->addHeader('Content-Type: text/html; charset=utf-8');
$registry->set('response', $response);

//数据库
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

// Router
if (isset($request->get['r'])) {
    $action = new Action($request->get['route']);
} else {
    $action = new Action('demo/home');
}

$controller = new Front($registry);

// 执行控制器
$controller->dispatch($action, new Action('error/not_found'));
// 输出view
$response->output();