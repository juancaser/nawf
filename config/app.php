<?php
/**
 * Not-Another-Web-Controller
 * @version 2.0
 * @author Juan Caser <caserjan@gmail.com>
 *
 * Main app config file
 */

return [
    /**
     * Sitename
     */
    'name'    => 'Not Another Web Controller',
    
    /**
     * Site domain
     */
    'domain'    => env('APP_DOMAIN', str_replace(['http://','https://','www.'],'', $_SERVER['HTTP_HOST'])),
    
    /**
     * Set to true if you are using HTTPS
     */
    'https'    => env('APP_HTTPS', false),
    
    /**
     * Set to true if you want to force the use of www
     */
    'force_www'    => env('APP_FORCE_WWW', false),
    
    /**
     * If installed as sub-directory, specify the path
     */
    'subdir'  => env('APP_SUBDIR', '/'),
    
    /**
     * Class aliases, this will be loaded during boot
     */
    'autoload'   =>  [
        'Route'     => \Core\Support\Facades\Route::class,
        'View'      => \Core\Support\Facades\View::class,
        'Request'   => \Core\Support\Facades\Request::class
    ]
];