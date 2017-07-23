<?php namespace Core\Kernel;
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * Middleware class
 */

class Middleware{
     
     /**
      * Middlewares variable
      *
      * @access private
      */
     private $middlewares = [];
     
     /**
      * Middleware function
      *
      * @param string $name
      * @param callable $callback
      */
     public function func($name, $callback){
          $this->middlewares[$name][] = $callback;
     }
     
     /**
      * Run middleware callback
      */
     public function run(){
          $args = func_get_args();
          $name =   array_shift($args);
          if(array_key_exists($name, $this->middlewares)){
               foreach($this->middlewares[$name] as $middleware){
                    if(is_callable($middleware)){
                         $data = call_user_func_array($middleware,$args);
                    }
               }
          }
          return $data;
     }
}
