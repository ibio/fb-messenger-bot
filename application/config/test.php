<?php
/**
 * Configuration
 *
 * For more info about constants please @see http://php.net/manual/en/function.define.php
 * If you want to know why we use "define" instead of "const" @see http://stackoverflow.com/q/2447791/1114320
 */
$root = preg_replace("!{$_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']);
/**
 * Configuration for: Error reporting
 * Useful to show every little problem during development, but only show hard errors in production
 */
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);
//turn off
// error_reporting(0);

/**
 * Configuration for: Project URL
 * Put your URL here, for local development "127.0.0.1" or "localhost" (plus sub-folder) is fine
 */
define('ROOT', $root . '/');
define('HOST', 'http://test.ypseek.com/');
define('URL',  'http://test.ypseek.com/interface/index.php');
define('VERITY_EXPIRE_TIME', 3 * 24 * 60 * 60);
define('CHECK_INTERVAL_TASK_TIME', 1 * 60);
define('LAST_ORDER_TIME', 19);

define('');

/**
 * Configuration for: Database
 * This is the place where you define your database credentials, database type etc.
 */
define('DB_TYPE', 'mysql');
define('DB_PREFIX', 'yp_');
//
define('DB_HOST', 'localhost');
define('DB_NAME', '');
define('DB_USER', 'test');
define('DB_PASS', '');

