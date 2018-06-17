<?php

/**路径设置**/

define('CORE',ROOT.'/core/');

define('VIEW',ROOT,'/view/');

define('MODEL',ROOT.'/model/');

define('ACTION',ROOT.'/action/');

define('MEDIUM',ROOT.'/medium/');

define('EXTEND',ROOT.'/extend/');

define('DB_HOST', '210.209.123.206');
define('DB_USER', 'sq_hx10086');
define('DB_PASSWD', 'yzhx10086');
define('DB_NAME', 'sq_hx10086');
define('DB_CHARSET', 'UTF8');
/**COOKIE设置**/

define('COOKIE_DOMAIN','.fastty.com');

define('COOKIE_TIMEOUT',2592000);	#30天

define('COOKIE_ENCRYPT_KEY','tvrc4m_roam');

// assert
assert_options(ASSERT_ACTIVE,1);
assert_options(ASSERT_WARNING,1); // 为每个失败的断言产生一个 PHP 警告（warning）
assert_options(ASSERT_QUIET_EVAL,0); // 在断言表达式求值时禁用 error_reporting
assert_options(ASSERT_BAIL,0); // 在断言失败时中止执行
// assert_options(ASSERT_CALLBACK,nil); //断言失败时调用回调函数
