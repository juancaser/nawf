<?php if(!defined('ABSPATH')) exit();
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * Class Autoloader
 */

/**
 * Class autoloader
 * @param string $class
 */
function nawc_autoloader($class){
    $abspath = realpath('./').DIRECTORY_SEPARATOR;    
    $class = rtrim($class,DIRECTORY_SEPARATOR);
    $class = rtrim($class,'/');
    $class = rtrim($class,'\\');
    $class = str_replace('\\',DIRECTORY_SEPARATOR,$class);
    $class_ex = explode(DIRECTORY_SEPARATOR,$class);
    if(array_shift($class_ex) == 'App'){
        $path = $abspath.lcfirst($class).'.php';
    }else{
        $path = $abspath.'lib'.DIRECTORY_SEPARATOR.$class.'.php';
    }    
    if(file_exists($path)){
        include_once($path);
    }
    
}

spl_autoload_register('nawc_autoloader');