<?php namespace Berg\Authorizer;

use User;
use Berg\Authorizer\RolesException;

class Authorizer {

    protected $config;
    protected $log;
    protected $user;

    public function __construct(LoggerInterface $log, ConfigInterface $config)
    {
        $this->log = $log;
        $this->config = $config;
    }

    public function init(User $user)
    {
        $this->user = $user;
    }

    /**
     * Set role for user
     *
     * @param string, get role for name from config file
     */
    public function addRole($role)
    {
        $this->doesRoleExist($role);
        $this->user->roles()->attach($this->config->get('authorizer.' . $role, false));
    }

    /**
     * Removes role for user
     *
     * @param string
     */
    public function removeRole($role)
    {
        $this->doesRoleExist($role);
        $this->user->roles()->detach($this->config->get('authorizer.' . $role, false));
    }

    /**
     * Checks to see if user has role
     *
     * @param string
     * @return boolean
     */
    public function is($role)
    {
        $this->doesRoleExist($role);
        $roles = $this->user->roles()->get();
        return in_array($role, $this->arrayFetch($roles->toArray(), 'name'));
    }

    /**
     * Calls on the authorize method in a model to check to see if a user has access to that instance of the model
     *
     * @param object
     * @param int
     * @return boolean
     */
    public function hasAccessTo($model, $id)
    {
        if (!$id || $this->is('admin')) return true;

        return $model->authorize($this->user, $id);
    }

    /**
     * Internal validation that call is for valid role name
     *
     * @param $type
     * @throws \Berg\Authorizer\RolesException
     */
    private function doesRoleExist($type)
    {
        $type = $this->config->get('authorizer.' . $type, false);
        if (!$type) {
            $this->log->logError('Role not found: ' . $type);
            throw new RolesException('Role not found.');
        }
    }

    /**
     * Copied from Laravel source
     * @param $array
     * @param $key
     * @return array
     */
    private function arrayFetch($array, $key)
    {
        foreach (explode('.', $key) as $segment)
        {
            $results = array();

            foreach ($array as $value)
            {
                $value = (array) $value;

                $results[] = $value[$segment];
            }

            $array = array_values($results);
        }

        return array_values($results);
    }
}