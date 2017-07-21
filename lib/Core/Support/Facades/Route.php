<?php namespace Core\Support\Facades;
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * Router facade class
 */

use Core\Support\Facade;

class Route extends Facade{     
     static function getClass(){
          return 'Core\Kernel\Router';
     }     
}