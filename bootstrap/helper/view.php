<?php
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * View helper
 */

 
/**
 * Load view files
 *
 * @param string $path
 * @param string $type
 * @param array $variables
 * @return bool
 */
function view($path, array $variables = null, $return = true){
    $path = app_path('view/'.$path).'.php';
    $content = load_view($path, $variables, config('cache.cache', false));    
    if($return){
        return $content;
    }else{
        echo $content;
    }
}

function load_view($path, $variables, $cache = false){    
    if($cache){
        $cache_name = storage_path('cache/view_'.sha1($path.'@nawcf_cache')).'.cache';        
        if(count($variables) > 0) extract($variables);
        
        $cache_age = config('cache.max_age',7200);
        $content = null;
        $make_cache = false;
        
        if(!file_exists($cache_name)){
            $make_cache = true;
        }elseif((time()-filemtime($cache_name)) > $cache_age){
            $make_cache = true;
        }
        
        // View file has been modified lets create a cache
        if($make_cache){
            ob_start();
            include($path);
            $content = ob_get_clean();
            file_put_contents($cache_name, $content);
        }else{
            $content = file_get_contents($cache_name);
        }
    }else{
        ob_start();
        include($path);
        $content = ob_get_clean();        
    }
    return $content;     
}

/**
 * Load helper file
 *
 * @param string $name
 */
function helper($name){
    $path = app_path('helper/'.$name.'.php');
    if(file_exists($path)) include($path);
}
