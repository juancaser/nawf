<?php
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * Path generator helper
 */

/**
 * Generate absolute path
 *
 * @param string $path
 * @param string $ext
 * @return string
 */
function abspath($path){
    $abspath = realpath('./');    
    $path = $abspath.DIRECTORY_SEPARATOR.sanitize_path($path);
    return $path;
}

/**
 * Return relevant application path
 * Shorthand for abspath
 * 
 * @uses abspath()
 * @uses sanitize_path()
 *
 * @param string $path
 * @return string
 */
function app_path($path){
    return abspath('app'.DIRECTORY_SEPARATOR.sanitize_path($path));
}

/**
 * Return relevant asset path
 * Shorthand for abspath
 * 
 * @uses abspath()
 * @uses sanitize_path()
 *
 * @param string $path
 * @return string
 */
function asset_path($path){
    return abspath('assets'.DIRECTORY_SEPARATOR.sanitize_path($path));    
}

/**
 * Return relevant storage path
 * Shorthand for abspath
 * 
 * @uses abspath()
 * @uses sanitize_path()
 *
 * @param string $path
 * @return string
 */
function storage_path($path){
    return abspath('storage'.DIRECTORY_SEPARATOR.sanitize_path($path));    
}

/**
 * Sanitize path
 *
 * @param string $path
 * @return string
 */
function sanitize_path($path){
    $path = trim($path,DIRECTORY_SEPARATOR);
    $path = trim($path,'/');
    $path = trim($path,'\\');    
    $path = str_replace(array('\\','/'),DIRECTORY_SEPARATOR,$path);
    return $path;
}

