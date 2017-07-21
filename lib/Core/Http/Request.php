<?php namespace Core\Http;
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * Input field and request class
 */

class Request {
    /**
     * Request variables
     *
     * @access private
     */
    private $request;
    
    /**
     * Post variables
     *
     * @access private
     */
    private $post;
    
    /**
     * Get variables
     *
     * @access private
     */
    private $get;
    
    /**
     * Current request method
     *
     * @access private
     */
    private $method = 'request';
    
    function __construct(){
        $this->init();
    }
    
    /**
     * Initialize
     */
    private function init(){
        if(is_null($this->request)) $this->request = $_REQUEST;
        if(is_null($this->post)) $this->post = $_POST;
        if(is_null($this->get)) $this->get = $_GET;
    }

    /**
     * Set method to post
     *
     * @return $this
     */
    function post(){
        $this->init();
        $this->method = 'post';
        return $this;
    }

    /**
     * Set method to get
     *
     * @return $this
     */    
    function get(){
        $this->init();
        $this->method = 'get';
        return $this;
    }
    
    /**
     * Reset method back to request
     *
     * @return $this
     */
    function reset(){
        $this->init();
        $this->method = 'request';
        return $this;
    }
    
    /**
     * Get all input data, if setting the method was not called
     * it would use $_REQUEST
     *
     * @return $this
     */
    function all(){
        $this->init();
        if($this->method == 'post'){
            return $this->post;
        }elseif($this->method == 'get'){
            return $this->get;
        }else{
            return $this->request;
        }
    }
    
    /**
     * Get input value
     *
     * @param string $key
     * @param string $default
     * @return string
     */
    function input($key, $default = ''){
        $this->init();
        if($this->has($key)){
            $input = $this->all();
            if(array_key_exists($key,$input)){
                return $input[$key];
            }
        }
        return $default;
    }
    
    /**
     * Check request exists
     *
     * @param string $key
     * @return bool
     */
    function has($key){
        $this->init();
        $req = $this->request;
        if($this->method == 'post'){            
            $req = $this->post;
        }elseif($this->method == 'get'){
            $req = $this->get;
        }
        
        if(array_key_exists($key,$req)) return true;
        return false;
    }
    
    /**
     * Check if request value is empty
     *
     * @param string $key
     * @return bool
     */
    function is_empty($key){
        $this->init();
        if($this->has($key)){
            $input = $this->input($key);
            if(!empty($input)){
                return true;
            }            
        }
        return false;
    }
}
