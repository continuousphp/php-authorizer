php-authorizer
================

A basic authorization package for Laravel

This package provides basic role-based authorization.


Installation
------------
Use [Composer](https://packagist.org/packages/berg/authorizer "Composer Link")


Laravel Config
---------------------
If using Laravel, add the following line to the providers array:

    'Berg\Authorizer\AuthorizerServiceProvider',

Create a file named authorizer.php in the app/config folder. The file should return an array of the roles you want to use with the role name as key and the role id as value. For example:

    'role_name' => 'role_id',
    'admin' => 1

In the User model, insert the following code:

    use AuthorizerTrait;
    protected $authorizer

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->authorizer = App::make('Authorizer');
        $this->authorizer->init($this);
    }

Add the use statement for the trait:

    use Berg\Authorizer\AuthorizerTrait;

Finally, the User model must have a roles() method. For example:

    public function roles()
    {
        return $this->belongsToMany('Role', 'users_roles');
    }


Basic Usage
-----------

Example checking role:

    if (Auth::is('admin')) {}

Example adding role:

    $user->addRole('admin');

Example removing role:

    $user->removeRole('admin');


Authorizing Models
------------------

To authorize models, include an authorize method in the model you wish to have authorized. The method should accept the user to be authorized and the model ID and should return a boolean value. For example:


    public function authorize(User $user, $modelId)
    {
        $modelInstance = $this->find($modelId);
        if($modelInstance->user_id == $user->id) return true;
        return false;
    }

Example call:

    if ($user->authorizeModel($exampleModel, 1)) {}