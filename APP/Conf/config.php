<?php
/**
 * 公共配置文件
 */
return array(
	// 分组配置
	'APP_GROUP_LIST' => 'Index,Admin',
	'DEFAULT_GROUP' => 'Index',
	// 独立分组
	'APP_GROUP_MODE' => 1,
	'APP_GROUP_PATH' => 'Modules',
	// 模板文件 CONTROLLER_NAME 与 ACTION_NAME 之间的分割符
	// 'TMPL_FILE_DEPR' => '_',
	
	// 数据库配置参数
	'DB_HOST' => 'localhost',
	'DB_USER' => 'root',
	'DB_PWD' => '',
	'DB_NAME' => 'wish',
	'DB_PREFIX' => 'tp_',
	
	// 点语法默认解析
	'TMPL_VAR_IDENTIFY' => 'array',
	// 默认过滤函数
	// 'DEFAULT_FILTER' => 'htmlspecialchars',
	// session类型(将session存储到数据库)
	'SESSION_TYPE' => 'Db',
);
?>