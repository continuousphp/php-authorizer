<?php
/**
 * @author Matt Berg, 2014
 */

namespace Berg\Authorizer;

use Illuminate\Support\ServiceProvider;

class AuthorizerServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('Authorizer', function($app){
            $logger = new LaravelLogger();
            $config = new LaravelConfig();
            return new Authorizer($logger, $config);
        });
   }
}