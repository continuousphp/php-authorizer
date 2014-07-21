<?php
/**
 * @author Matt Berg, 2014
 */

namespace Berg\Authorizer;

class LaravelConfig implements ConfigInterface {

    public function get($configPath, $default = false)
    {
        return Config::get($configPath, $default);
    }
}