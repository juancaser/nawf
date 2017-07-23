<?php
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * Helper library
 */

/**
 * Path helper functions
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


/**
 * Config helper functions
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

/**
 * String helpers
 */

if(!function_exists('mime_content_type')){
    /**
     * Override mime_content_type if server disables it
     *
     * @param string $filename
     * @return string
     */
    function mime_content_type($filename){
        $mime_types = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );
        
        if(is_dir($filename)){
            return 'directory';
        }else{
            $ext = pathinfo($filename,PATHINFO_EXTENSION);
            if (array_key_exists($ext, $mime_types)) {
                return $mime_types[$ext];
            }elseif(function_exists('finfo_open')) {
                $finfo = finfo_open(FILEINFO_MIME);
                $mimetype = finfo_file($finfo, $filename);
                finfo_close($finfo);
                return $mimetype;
            }else {
                return 'application/octet-stream';
            }
        }
    }    
}

/**
 * Generate slug
 *
 * @param string $text
 * @return string
 */
function generate_slug($text){
     // replace non letter or digits by -
     $text = preg_replace('~[^\pL\d]+~u', '-', $text);
     // transliterate
     $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
     // remove unwanted characters
     $text = preg_replace('~[^-\w]+~', '', $text);
     // trim
     $text = trim($text, '-');
     // remove duplicated - symbols
     $text = preg_replace('~-+~', '-', $text);
     // lowercase
     $text = strtolower($text);
     if (empty($text)) return 'n-a';
     return $text;
}

/**
 * URL Helpers
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
?>