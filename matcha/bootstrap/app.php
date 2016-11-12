<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

use Respect\Validation\Validator as v;

$app = new \Slim\App([
    'settings' => [
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,

        'db' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'database' => 'matcha',
            'username' => 'root',
            'password' => 'tOnymAck',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]
    ]

]);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
  return $capsule;
};

$container['auth'] = function ($container){
    return new App\Auth\Auth;
};

$container['flash'] = function ($container){
    return new \Slim\Flash\Messages;
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => false,
    ]);

    $view->addExtension(new Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container->auth->check(),
        'user' => $container->auth->user(),
    ]);

    $view->getEnvironment()->addGlobal('flash', $container->flash);

    return $view;
};

$container['validator'] = function ($container){
    return new App\Validation\Validator;
};

$container['HomeController'] = function ($container){
  return new App\Controllers\HomeController($container);
};

$container['AuthController'] = function ($container){
    return new App\Controllers\Auth\AuthController($container);
};

$container['csrf'] = function ($container){
    return new Slim\Csrf\Guard;
};

$container['PasswordController'] = function ($container){
    return new App\Controllers\Auth\PasswordController($container);
};

$container['ProfileController'] = function ($container){
    return new App\Controllers\Auth\ProfileController($container);
};

$container['ChatController'] = function ($container){
    return new App\Controllers\Auth\ChatController($container);
};
//middleware
$app->add(new \App\Middleware\ValidationErrorsM($container));
$app->add(new \App\Middleware\OldInputM($container));
$app->add(new \App\Middleware\CsrfViewMW($container));
//Cross-Site Request Forgery protection
$app->add($container->csrf);

v::with('App\\Validation\\Rules');

require __DIR__ . '/../app/routes.php';
