<?php
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * Router
 */

Route::get('/', function(){
	return View::display('home');
});

Route::get('about', function(){
	return View::display('about');
});



Route::error(function($err_code){
	 if($err_code == 404){
		  header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');		  
		  //exit(view('error/notfound'));
	 }
});