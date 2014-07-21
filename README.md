php-basecamp
================

A Basecamp package with Quick Setup for Laravel

This package allows for quick and easy integration with the Basecamp API. It includes a service provider and logger implementation for easy setup in a Laravel application but can be easily extended to work in other environments.


Installation
------------
Use [Composer](https://packagist.org/packages/berg/basecamp "Composer Link")


Laravel Config
---------------------
If using Laravel, add the following line to the providers array:

    'Berg\Basecamp\BasecampServiceProvider',
    
Create a file named basecamp.php in the app/config folder. The file should return an array with the following values:

    'id' => '',
    'user_agent' => '',
    'username' => '',
    'password' => '',
    'version' => 'v1'
