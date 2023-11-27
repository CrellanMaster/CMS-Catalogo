<?php

require_once "./vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router("https://localhost");

$router->namespace("Crellan\\App\\App\\Controllers\\Admin\\Auth")->group("admin/auth");
$router->get("/home", "AuthController:index");

$router->namespace("Crellan\\App\\App\\Controllers\\Admin\\Panel")->group("admin/panel");
$router->get("/", "ProfileController:index");

$router->dispatch();


if ($router->error()) {
    $router->redirect("/error/{$router->error()}");
}
