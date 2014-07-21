<?php
/**
 * @author Matt Berg, 2014
 */

namespace Berg\Authorizer;

interface ConfigInterface {

    public function get($configPath, $default);
}