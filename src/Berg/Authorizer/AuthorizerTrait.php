<?php namespace Berg\Authorizer;

trait AuthorizerTrait {
    public function is($role)
    {
        return $this->authorizer->is($role);
    }

    public function addRole($role)
    {
        return $this->authorizer->addRole($role);
    }

    public function removeRole($role)
    {
        return $this->authorizer->removeRole($role);
    }

    public function authorizeModel($model, $modelId)
    {
        return $this->authorizer->authorizeModel($model, $modelId);
    }
}