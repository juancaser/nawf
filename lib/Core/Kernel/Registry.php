<?php namespace Core\Kernel;
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * Global variable class
 */

class Registry {
    private $storage = array();
    private static $inst = null;
    private function __construct(){}
    private function __clone(){}
    
    /**
     * Return registry instance
     */
    public static function &getInstance(){
        if(is_null(static::$inst) || !static::$inst instanceof self) static::$inst = new self;
        return static::$inst;
    }    
    
    /**
     * Set variable
     *
     * @param string $name
     * @param string $value
     */
    public function __set($name,$value){$this->set($name,$value);}
    public function set($name,$value){
        $this->storage[$name] = $value;
    }
    
    /**
     * Sgt variable
     *
     * @param string $name
     * @return string
     */
    public function __get($name){return $this->get($name);}
    public function get($name,$default = null){
        if(isset($this->storage[$name])){
            if(is_callable($this->storage[$name])){
                return call_user_func_array($this->fields[$name], array($default));
            }else{
                return $this->storage[$name];
            }
        }
        return $default;
    }
    
    /**
     * Check if variable exists
     *
     * @param string $name
     * @return bool
     */
    public function has($name){
        return isset($this->storage[$name]);
    }
}
