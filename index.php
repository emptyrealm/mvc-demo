<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lance
 * Time: 上午11:56
 * To change this template use File | Settings | File Templates.
 */

// 变量设置
define('VERSION', '0.1');
define('ENVIRONMENT','development');

define('DS',DIRECTORY_SEPARATOR);
define('ROOT',dirname(dirname(__FILE__)));
// 当前文件名
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));


//目录文件名称
$system_path = 'system';
$application_folder = 'application';

switch (ENVIRONMENT)
{
    case 'development':
        error_reporting(-1);
        ini_set('display_errors', 1);
        break;

    case 'testing':
    case 'production':
        ini_set('display_errors', 0);
        if (version_compare(PHP_VERSION, '5.3', '>='))
        {
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        }
        else
        {
            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
        }
        break;
    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        exit('环境设置不正确');
}

// 设置框架核心代码目录
if (realpath($system_path) !== FALSE)
{
    $system_path = realpath($system_path).'/';
}

// 确保有/
$system_path = rtrim($system_path, '/').'/';

// 检查系统目录是否正确
if ( ! is_dir($system_path))
{
    exit("系统目录不正确，路径为: ".pathinfo(__FILE__, PATHINFO_BASENAME));
}

// 系统目录
define('DIR_SYSTEM', str_replace("\\", "/", $system_path));

// 应用目录
if (is_dir($application_folder))
{
    define('DIR_APPLICATION', $application_folder.'/');
}else{
    if ( ! is_dir(DIR_SYSTEM.$application_folder.'/'))
    {
        exit("您的应用目录路径没有正确设置。请打开以下文件并纠正： ".SELF);
    }
    define('DIR_APPLICATION', DIR_SYSTEM.$application_folder.'/');
}

require_once(DIR_SYSTEM.DS.'bootstrap.php');
