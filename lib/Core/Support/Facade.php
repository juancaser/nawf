<?php namespace Core\Support;
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * Facade base class
 */

use Core\Kernel\Registry;

abstract class Facade{
    /**
     * Get class name
     */
    static function getClass(){}
    
    /**
     * __callStatic magic method
     */
    public static function __callStatic($name, array $arguments){
        $registry = Registry::getInstance();
        if($registry->has(static::getClassName())){            
            $accessor =  $registry->get(static::getClassName());
            
        }else{
            $ref = new \ReflectionClass(static::getClass());
            $accessor = $ref->newInstance();            
            $registry->set(static::getClassName(), $accessor);
        }
        if(method_exists($accessor,$name)){
            return call_user_func_array(array($accessor,$name), $arguments);    
        }else{
            return;
        }        
    }

    /**
     * Get name
     * @access private
     */
    private static function getClassName(){        
        $nameex = explode('\\',static::getClass());
        return array_pop($nameex);
    }
    
}