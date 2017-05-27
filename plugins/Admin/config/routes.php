<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Admin',
    ['path' => '/admin'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);

Router::scope('/', function (RouteBuilder $routes) {
    $routes->connect('admin/login', ['plugin' => 'Admin', 'controller' => 'Auths', 'action' => 'login']);
    $routes->connect('admin/logout', ['plugin' => 'Admin', 'controller' => 'Auths', 'action' => 'logout']);
    $routes->connect('admin/forgot-password', ['plugin' => 'Admin', 'controller' => 'Auths', 'action' => 'forgotPassword']);
    $routes->connect('admin/reset-password', ['plugin' => 'Admin', 'controller' => 'Auths', 'action' => 'resetPassword']);
    $routes->connect('admin/dashboard', ['plugin' => 'Admin', 'controller' => 'Analytics', 'action' => 'dashboard']);
    $routes->connect('admin/save-settings/*', ['plugin' => 'Admin', 'controller' => 'Settings', 'action' => 'saveSetting']);
    $routes->connect('admin/profile', ['plugin' => 'Admin', 'controller' => 'Settings', 'action' => 'profile']);
});