<?php namespace Core\Support\Facades;
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * View Facade class
 */

use Core\Support\Facade;

class View extends Facade{     
     static function getClass(){
          return 'Core\Http\View';
     }     
}