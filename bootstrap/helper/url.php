<?php
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * URL Helper
 */

 
/**
 * Create url link
 *
 * @param string $path
 * @param array $query_strings
 * @param bool $return
 * @return strings
 */
function url($path = '/', array $http_query = null, $echo = false){
    $http_host = str_replace(['http://','https://','www.'],'', $_SERVER['HTTP_HOST']);
    $domain = config('app.domain', $http_host);
    $https = config('app.https', false);
    $force_www = config('app.force_www', false);
    
    $base_url = ($https ? 'https://' : 'http://').($force_www ? 'www.' : '').$domain.'/';
    $base_url.=trim($path,'/');
    
    if(!is_null($http_query)){
        // Sanitize query string
        array_walk_recursive($http_query, function(&$item){
            $item = rawurlencode($item);
        });
        $base_url.='?'.http_build_query($http_query);
    }
    if(!$echo){
        return $base_url;    
    }else{
        echo $base_url;
    }
}

/**
 * Load asset
 *
 * @param string $path
 * @param bool $echo
 * @return string
 */
function asset($path, $echo = false){
    if(file_exists(asset_path($path))){
        $path = url('assets/'.$path);
        if(!$echo){
            return $path;    
        }else{
            echo $path;
        }
    }
}

/**
 * Redirect url
 *
 * @param string $uri
 * @param string $http_response_code
 * @param bool $replace
 */
function redirect($uri, $http_response_code = '', $replace = true){
    $url = url($uri);
    header('Location: '.$url, $replace, $http_response_code);
    exit();
}