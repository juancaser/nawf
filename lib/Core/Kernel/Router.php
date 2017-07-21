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
     * Router vars
     *
     * @access private
     */
    private $routes = array('post' => array(), 'get' => array());
    
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
        $this->routes[$method]['/^' .$uri. '$/'] = $callback;	       
    }
    
    /**
     * Execute routing
     *
     * @param string $url
     * @return bool
     */
    public function execute($uri) {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        foreach($this->routes[$method] as $pattern => $callback){            
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
