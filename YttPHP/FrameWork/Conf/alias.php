<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: alias.php 2929 2012-05-02 06:45:47Z liu21st@gmail.com $

!defined('THINK_PATH') && exit();
// 系统别名定义文件
return array(
    'Model'         => CORE_PATH.'Core/Model.class.php',
    'Db'            => CORE_PATH.'Core/Db.class.php',
    'Log'          =>   CORE_PATH.'Core/Log.class.php',
    'ThinkTemplate' => CORE_PATH.'Template/ThinkTemplate.class.php',
    'TagLib'        => CORE_PATH.'Template/TagLib.class.php',
    'Cache'         => CORE_PATH.'Core/Cache.class.php',
    'Widget'         => CORE_PATH.'Core/Widget.class.php',
    'TagLibCx'      => CORE_PATH.'Driver/TagLib/TagLibCx.class.php',
    
    'RelationModel'   => CORE_PATH.'Core/RelationModel.class.php',
    'ViewModel'        => CORE_PATH.'Core/ViewModel.class.php',
    'AdvModel'         => CORE_PATH.'Core/AdvModel.class.php', 
);