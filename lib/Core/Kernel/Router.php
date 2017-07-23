<?php namespace Core\Kernel;
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * Router main class
 */
class Router{
    /**
     * Domain where the route be assigned to
     *
     * @access private
     * 
     */
    private $domain = 'any';
     
    /**
     * Router vars
     *
     * @access private
     */
    private $routes = ['any' => ['post' => [], 'get' => []]];

    
    /**
     * Error callback
     */
    private $error = array();
    
    
    /**
     * Add error callback
     *
     * @param callable $callback
     */
    public function error($callback){
        if(!is_callable($callback)) return;
        $this->error[] = $callback;
        return $this;
    }
    
    /**
     * Add post route
     *
     * @uses route()
     * @param string $uri
     * @param callable $callback
     */
    public function post($uri, $callback) {
        if(!is_callable($callback)) return;
        $this->route($uri, $callback, __FUNCTION__);
    }

    /**
     * Add get route
     *
     * @uses route()
     * @param string $uri
     * @param callable $callback
     */    
    public function get($uri, $callback) {
        if(!is_callable($callback)) return;
        $this->route($uri, $callback, __FUNCTION__);
    }
     
    /**
     * Add route
     *
     * @uses route()
     * @param string $uri
     * @param callable $callback
     */
     public function route($uri, $callback,$method = 'get') {
        if(!is_callable($callback)) return;
        if($uri != '/') $uri = trim($uri,'/');
        $uri = str_replace('/', '\/', $uri);        
        $this->routes[$this->domain][$method]['/^' .$uri. '$/'] = $callback;	       
     }
     
     public function domain($domain, $callback){
          $this->domain = $domain;
          call_user_func($callback);
          $this->domain = 'any';          
     }
    
     /**
      * Execute routing
      *
      * @param string $url
      * @return bool
      */
     public function execute($uri) {
          $method = strtolower($_SERVER['REQUEST_METHOD']);
          $routes = $this->routes['any'][$method];
          
          if(isset($_SERVER['HTTP_HOST'])){
               $current_domain = str_replace(['https://','http://','www'],'', $_SERVER['HTTP_HOST']);               
               if(array_key_exists($current_domain,$this->routes)) $routes = $this->routes[$current_domain][$method];;
          }

          foreach($routes as $pattern => $callback){            
               if(preg_match($pattern, $uri, $params)) {
                    array_shift($params);                
                    return call_user_func_array($callback, array_values($params));
               }
          }
          $this->trigger_error(404);
          return false;
     }
    
    /**
     * Trigger error callback
     *
     * @param int $code
     */
    private function trigger_error($code){
        // Not found trigger error callback
        foreach($this->error as $callback){
            call_user_func_array($callback, array($code));
        }        
    }
}
