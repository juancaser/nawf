<?php namespace Core\Support\Facades;
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * Request facade class
 */

use Core\Support\Facade;

class Request extends Facade{     
     static function getClass(){
          return 'Core\Http\Request';
     }     
}