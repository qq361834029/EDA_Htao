<?php
define('APP_DEBUG',true);
define('DEBUG',true);
define('PAGE_TRACE',true);
//定义项目名称和路径
define('APP_PATH', '../admin/');
//define('APP_NAME', 'admin');
define('ADMIN_CONF_FILE','./Conf/config.php');
define('CONFIG_FILE',dirname(__FILE__).'/Runtime/~config.php');
define('ADMIN_RUNTIME_PATH',dirname(__FILE__).'/Runtime/');
define('LANG_PATH', ADMIN_RUNTIME_PATH.'Lang/');//更改语言包路径，否则后台无法读取语言包
// 加载框架入口文件
define('FrameName','YttPHP');
require('../' . FrameName . '/FrameWork/ThinkPHP.php');
