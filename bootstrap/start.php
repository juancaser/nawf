<?php
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * NAWC Bootloader
 */

// Set absolute path
define('ABSPATH', dirname(__DIR__));

// Display all error
if(defined('ERR_REPORTING') && !is_bool(ERR_REPORTING)){    
    error_reporting(ERR_REPORTING);    
}


// Load class Autoloader
include('autoloader.php');

/**
 * Load all global helper
 */
include('helper/path.php');
include('helper/config.php');
include('helper/view.php');
include('helper/string.php');
include('helper/url.php');


/**
 * Load autoload class
 */
$autoload = config('app.autoload');
foreach($autoload as $name => $class){
    class_alias($class, $name);   
}

/**
 * Init
 *
 *  Load init.php if it exist
 */
if(file_exists(app_path('init.php'))) include(app_path('init.php'));

/**
 * Router
 */
include(app_path('routes.php'));
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri,'/');

$subdir = config('app.subdir','');
$subdir = trim($subdir,'/');

if(!empty($subdir)){    
    if($subdir == substr($uri,0, strlen($subdir))){        
        $uri = trim(substr($uri,strlen($subdir), strlen($uri)),'/');        
    }
}

if($view = Route::execute((empty($uri) ? '/' : $uri))){
    header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
    exit($view);
}