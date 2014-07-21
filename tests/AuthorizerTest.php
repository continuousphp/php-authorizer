<?php

use \Mockery as m;
use Berg\Authorizer\Authorizer;
// use Berg\Authorizer\LaravelLogger;
// use Berg\Authorizer\LaravelConfig;

class AuthorizerTest extends PHPUnit_Framework_TestCase {
    protected $logger;
    protected $config;

    public function setUp()
    {
        $this->logger = m::mock('Berg\Authorizer\LaravelLogger');
        $this->config = m::mock('Berg\Authorizer\LaravelConfig');
        $this->user = m::mock('User')->shouldDeferMissing();
        $this->authorizer = new Authorizer($this->logger, $this->config);
    }

    public function tearDown()
    {
        m::close();
    }

    public function testAddRole()
    {
        $this->authorizer->init($this->user);
        $this->user->shouldReceive('roles')->once()->andReturn($this->user);
        $this->user->shouldReceive('attach')->once();
        $this->config->shouldReceive('get')->andReturn(true);
        $this->authorizer->addRole('test');
    }

    public function testAddRoleFails()
    {
        $this->authorizer->init($this->user);
        $this->config->shouldReceive('get')->andReturn(false);
        $this->logger->shouldReceive('logError')->once();

        $this->setExpectedException('Berg\Authorizer\RolesException', 'Role not found.');
        $this->authorizer->addRole('test');
    }

    public function testRemoveRole()
    {
        $this->authorizer->init($this->user);
        $this->user->shouldReceive('roles')->once()->andReturn($this->user);
        $this->user->shouldReceive('detach')->once();
        $this->config->shouldReceive('get')->andReturn(true);
        $this->authorizer->removeRole('test');
    }

    public function testRemoveRoleFail()
    {
        $this->authorizer->init($this->user);
        $this->config->shouldReceive('get')->andReturn(false);
        $this->logger->shouldReceive('logError')->once();

        $this->setExpectedException('Berg\Authorizer\RolesException', 'Role not found.');
        $this->authorizer->removeRole('test');
    }

    public function testIs()
    {
        $roles = array(array('name' => 'test'));

        $this->authorizer->init($this->user);
        $this->user->shouldReceive('roles')->once()->andReturn($this->user);
        $this->user->shouldReceive('toArray')->once()->andReturn($roles);
        $this->config->shouldReceive('get')->andReturn(true);

        $result = $this->authorizer->is('test');
        $this->assertTrue($result);
    }

    public function testIsFails()
    {
        $roles = array(array('name' => 'otherName'));

        $this->authorizer->init($this->user);
        $this->user->shouldReceive('roles')->once()->andReturn($this->user);
        $this->user->shouldReceive('toArray')->once()->andReturn($roles);
        $this->config->shouldReceive('get')->andReturn(true);

        $result = $this->authorizer->is('test');
        $this->assertFalse($result);
    }

    public function testAuthorizeModelAdmin()
    {
        $roles = array(array('name' => 'admin'));
        $this->authorizer->init($this->user);
        $this->user->shouldReceive('roles')->once()->andReturn($this->user);
        $this->user->shouldReceive('toArray')->once()->andReturn($roles);
        $this->config->shouldReceive('get')->andReturn(true);

        $result = $this->authorizer->authorizeModel('modelName', 1);
        $this->assertTrue($result);
    }

    public function testAuthorizeModelNotAdmin()
    {
        $roles = array(array('name' => 'notAdmin'));
        $this->authorizer->init($this->user);
        $this->user->shouldReceive('roles')->once()->andReturn($this->user);
        $this->user->shouldReceive('toArray')->once()->andReturn($roles);
        $this->config->shouldReceive('get')->andReturn(true);

        $testModel = m::mock('testModel');
        $testModel->shouldReceive('authorize')->once()->andReturn(true);

        $result = $this->authorizer->authorizeModel($testModel, 1);
        $this->assertTrue($result);
    }

    public function testAuthorizeModelNotAdminFails()
    {
        $roles = array(array('name' => 'notAdmin'));
        $this->authorizer->init($this->user);
        $this->user->shouldReceive('roles')->once()->andReturn($this->user);
        $this->user->shouldReceive('toArray')->once()->andReturn($roles);
        $this->config->shouldReceive('get')->andReturn(true);

        $testModel = m::mock('testModel');
        $testModel->shouldReceive('authorize')->once()->andReturn(false);

        $result = $this->authorizer->authorizeModel($testModel, 1);
        $this->assertFalse($result);
    }

}