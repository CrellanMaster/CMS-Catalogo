<?php

require_once "./vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router("https://localhost");

$router->namespace("Crellan\\App\\App\\Controllers\\Admin\\Auth")->group("admin/auth");
$router->get("/home", "AuthController:authLogin");

$router->namespace("Crellan\\App\\App\\Controllers\\Admin\\Panel")->group("admin/profile");
$router->get("/", "ProfileController:index");

$router->namespace("Crellan\\App\\App\\Controllers\\Admin\\Panel")->group("admin/panel");
$router->get("/", "DashboardController:index");

$router->dispatch();


if ($router->error()) {
    $router->redirect("/error/{$router->error()}");
}
