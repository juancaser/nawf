<?php namespace Core\Http;
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * View class
 */
use Core\Support\Facades\Middleware;

class View {
     /**
      * Variable array
      *
      * @access private
      */
     private $vars = [];
     
     private $path;
     private $layout;
     
     
     /**
      * Section hook
      *
      * @access private
      */
     private $sections = [];
     
     /**
      * Set view path
      *
      * @param string $path
      */
     public function path($path){
          $this->path = $path;
     }
     
     
     private function locate_view($view){
          $view = str_replace(['\\','/'], DIRECTORY_SEPARATOR,$view);
          $view_ex = explode('.',$view);
          if(count($view_ex) > 1){
               $view = implode(DIRECTORY_SEPARATOR,$view_ex);
          }
          
          $path = $this->path.DIRECTORY_SEPARATOR.$view.'.php';
          if(file_exists($path)){
               
               return $path;
          }else{
               return false;
          }
     }
     
     /**
      * Return loaded view
      *
      * @param string $view
      * @param array $vars
      * @return string
      */
     private function load($view, array $vars = null){
          $content = '';
          if($path = $this->locate_view($view)){
               $_vars = null;
               if(!is_null($vars)){
                    foreach($vars as $key => $value){
                         $this->setVar($key, $value);
                    }
               }
               ob_start();
               include($path);
               $content = ob_get_clean();
          }
          return $content;
     }
     
     /**
      * Display the loaded view
      *
      * @param string $view
      * @param array $vars
      * @param bool $return
      * @return string
      */
     public function display($view, array $vars = null, $echo = false){
          if($path = $this->locate_view($view)){
               $this->load($view, $vars);
               $content = $this->load($this->layout);
               
               // Send content to middleware just incase there is another processing
               // of the data that is not part of the view class
               $content = Middleware::run('view.display',$path, $content);
               
               if(!$echo){
                    return $content;
               }else{
                    echo $content;
               }
          }
     }
     
     /**
      * Set view layout
      */
     public function layout($view){
          $this->layout = $view;
     }
     
     
     /**
      * Getter and Setter
      */
     public function __set($key, $value){
          $this->setVar($key, $value);
     }
     public function __get($key){
          return $this->getVar($key);
     }
     
     /**
      * Set variable
      *
      * @param string $key
      * @param string $value
      */
     public function setVar($key, $value){
          $this->vars[$key] = $value;
     }
     
     /**
      * Get variable
      *
      * @param string $key
      * @return any
      */
     public function getVar($key){
          if(array_key_exists($key, $this->vars)) return $this->vars[$key];
          return;
     }
     
     public function block($name, $callback = null){          
          if(array_key_exists($name, $this->sections)){
               foreach($this->sections[$name] as $section){
                    if(is_callable($callback)){
                         ob_start();
                         call_user_func($callback);
                         $cb = ob_get_clean();
                         echo call_user_func_array($section, [$cb]);                         
                    }else{
                         echo call_user_func($section);     
                    }                    
               }          
          }
     }
     
     public function section($name, $callback){
          $this->sections[$name][] = $callback;
     }

}
