<?php
/**
 * This is where you do any initialization before route gets executed
 */

Middleware::func('view.display', function($path, $content){
     Cache::path(config('app.path.cache'));
     Cache::name('view_'.sha1($path.'@nawcf_cache'));
     Cache::age(config('cache.max_age',7200));
     return Cache::render($content);    
});