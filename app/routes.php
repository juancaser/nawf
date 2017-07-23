<?php
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * Router
 */

Route::domain('test.nawf.dev', function(){
	Route::get('/about', function(){
		 return view('about');
	});
});

 
Route::get('/', function(){
	 return view('home');
});



Route::error(function($err_code){
	 if($err_code == 404){
		  header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');		  
		  exit(view('error/notfound'));
	 }
});