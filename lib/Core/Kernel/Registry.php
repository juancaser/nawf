<?php namespace Core\Kernel;
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * Global registry class
 */
class Registry{
    
    /**
     * Registry instance
     *
     * @access private
     */
    private static $inst;
    
    /**
     * Variables
     *
     * @access private
     */
    private $variables = array();
    
    private function __construct(){
        /**
         * Prevent instantation
         */
    }
    
    /**
     * Return registry instance
     */
    public static function &getInstance(){
        if(is_null(static::$inst) || !(static::$inst instanceof self))
            static::$inst = new self;            
        return static::$inst;
    }
    
    /**
     * @uses set()
     */
    public function __set($key, $value){
        $this->set($key, $value);
    }
    
    /**
     * @uses get()
     */
    public function __get($key){
        return $this->get($key);
    }
    
    
    /**
     * Variable setter
     *
     * @param string $key
     * @param any $value
     * @return $this
     */
    public function set($key, $value){
        $this->variables[$key] = $value;
        return $this;
    }
    
    /**
     * Variable getter
     *
     @param string $key
     @return any
     */
    public function get($key){
        if($this->has($key)) return $this->variables[$key];
        return;
    }
    
    /**
     * Check if variable exists
     *
     * @param string $key
     * @return bool
     */
    public function has($key){
        return isset($this->variables[$key]);
    }
}