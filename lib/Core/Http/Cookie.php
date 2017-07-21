<?php namespace Core\Http;
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * Cookie class
 */

class Cookie {
     
     /**
      * Sets cookie
      *
      * @param string $key
      * @param string $value
      * @param string $expiration
      */
     function set($key, $value, $expiration = null){
         $expiration = (is_null($expiration) ? time() + (86400) : $expiration);
         setcookie($key, $value, $expiration, '/');
     }

     /**
      * Get cookiet
      *
      * @param string $key
      * @param string $default
      * @return string
      */     
     function get($key, $default = ''){
          if(isset($_COOKIE[$key])) return $_COOKIE[$key];
          return $default;
     }
     
     /**
      * Check if cookie exists
      *
      * @param string $key
      * @return bool
      */
     function has($key){
          if(isset($_COOKIE[$key])) return true;
          return false;
     }     
     
     /**
      * Update a cookie
      *
      * @param string $key
      * @param string $value
      */
     function update($key, $value){
          setcookie($key, $value, time() + (86400 * 30), '/'); // 86400 = 1 day
     }
     
     /**
      * Delete a cookie
      *
      * @param string $key
      */
     function delete($key){
          unset($_COOKIE[$key]);
          $this->set($key, time() - 3600);
     }
}
