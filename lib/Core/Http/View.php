<?php namespace Core\Http;
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * View class
 */

class View {
     /**
      * Variable array
      *
      * @access private
      */
     private $vars = array();
     
     /**
      * Section hook
      *
      * @access private
      */
     private $sections = array();
     
     
     /**
      * Display loaded view
      *
      * @param string $view
      * @param array $args
      * @return string
      */
     public function display($view, $args = null){
          ob_start();
          $this->inc($view,$args);
          $data = ob_get_clean();
          return $data;
     }
     
     /**
      * Getter and Setter
      */
     public function __set($key, $value){
          $this->set_var($key, $value);
     }
     public function __get($key){
          if(isset($this->vars[$key])) return $this->vars[$key];
          return;
     }     
     public function set_var($key, $value){
          $this->vars[$key] = $value;
     }
     
     
     /**
      * Add section block
      *
      * @param string $name
      * @param callable $callback
      */
     public function block($name, $callback){
          $this->sections[$name][] = $callback;
     }

     /**
      * Load section blocks
      *
      * @param string $name
      */     
     public function section($name){
          if(!isset($this->sections[$name])) return;
          foreach($this->sections[$name] as $section){
               call_user_func($section);
          }
     }
     
     /**
      * Load view
      *
      * @param string $view
      * @param array $args
      */
     private function inc($view, $args = null){
          $view = trim(str_replace(array('.','\\','/'),DIRECTORY_SEPARATOR,$view),DIRECTORY_SEPARATOR);          
          if(file_exists($path = config('app.path.view').DIRECTORY_SEPARATOR.$view.'.php')){
               if(is_array($args)) $this->vars = array_merge($this->vars,$args);
               if(count($this->vars) > 0) extract($this->vars);
               include($path);     
          }
          
     }
}
