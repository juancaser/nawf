<?php
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * Config string helper
 */

/**
 * Load config file
 *
 * @param string $config
 * @param string $default
 * @return array
 */
function config($config, $default = null){
    $keys = explode('.',$config);    
    $cfg_file = array_shift($keys);    
    $path = abspath('config'.DIRECTORY_SEPARATOR.$cfg_file).'.php';    
    if(file_exists($path)){        
        $items = require $path;
        if(count($keys) > 0){
            $results = array();
            if(count($keys) > 0){
                $cfg_key = implode('.',$keys);    
            }else{
                $cfg_key = array_shift($keys);
            }            
            
            foreach($items as $key => $value) $results[$key] = $value;
            
            $recIte = new RecursiveIteratorIterator(new RecursiveArrayIterator($items));            
            foreach($recIte as $leafValue) {
                $new_keys = array();
                foreach(range(0, $recIte->getDepth()) as $depth) {
                    $new_keys[] = $recIte->getSubIterator($depth)->key();
                }
                $results[join('.', $new_keys) ] = $leafValue;
            }            
            if(array_key_exists($cfg_key, $results)) return $results[$cfg_key];
        }else{
            return $items;
        }
    }
    return $default;    
}

/**
 * Get environment variables
 *
 * @param string $name
 * @param string $default
 * @return string
 */
function env($name, $default){
    if(function_exists('parse_ini_file')){
        $path = abspath('.env');
        
        // Check if .env variables and loads it
        if(file_exists($path)){
            $variables = parse_ini_file($path);
            if($variables != false){
                if(array_key_exists($name,$variables)){
                    return $variables[$name];
                }else{
                    if(function_exists('getenv')){
                        if($var = getenv($name)) return $var;
                    }
                }
            }
        }
    }
    return $default;
}