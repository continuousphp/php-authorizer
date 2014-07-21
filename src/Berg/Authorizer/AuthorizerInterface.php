<?php
/**
 * @author Matt Berg, 2014
 */
namespace Berg\Authorizer;

use User;

interface AuthorizerInterface {
    public function init(User $user);
    public function addRole($typeString);
    public function removeRole($typeString);
    public function is($typeString);
    public function hasAccessTo($modelName, $modelId);
}