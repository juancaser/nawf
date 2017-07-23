<?php namespace Core\Support\Facades;
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * Cache Facade class
 */

use Core\Support\Facade;

class Middleware extends Facade{     
     static function getClass(){
          return 'Core\Kernel\Middleware';
     }     
}