<?php namespace Core\Http;
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * Cache class
 */

class Cache{
     /**
      * Cache age
      */
     private $cache_age = 7200;
     
     /**
      * Cache name
      */
     private $cache_name;
     
     /**
      * Cache save path
      */
     private $path;
     
     
     /**
      * Set cache path
      *
      * @param string $path
      */
     public function path($path){
          $this->path = $path;
     }
     
     /**
      * Set cache name
      *
      * @param string $cache_name
      */
     public function name($cache_name){
          $this->cache_name = $cache_name;
     }
     
     /**
      * Set cache age
      *
      * @param int $cache_age
      */
     public function age($cache_age){
          $this->cache_age = $cache_age;
     }
     
     /**
      * Render cache file
      *
      * @param string $content
      * @return string
      */
     public function render($content){
          $cache_file = $this->path.DIRECTORY_SEPARATOR.$this->cache_name;
          if(!file_exists($cache_file)){
              file_put_contents($cache_file,$content);
          }elseif(md5_file($cache_file) != md5($content)){
               file_put_contents($cache_file,$content);
          }else{
              $content = file_get_contents($cache_file);
          }
          return $content;
     }
}
