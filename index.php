<?php

require_once "./vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router("https://localhost");

$router->namespace("Crellan\\App\\App\\Controllers\\Admin\\Auth")->group("admin/auth");
$router->get("/login", "AuthController:authLogin");

$router->namespace("Crellan\\App\\App\\Controllers\\Admin\\Panel")->group("admin/profile");
$router->get("/", "ProfileController:index");

$router->namespace("Crellan\\App\\App\\Controllers\\Admin\\Panel")->group("admin/panel");
$router->get("/", "DashboardController:index");

$router->namespace("Crellan\\App\\App\\Controllers\\Admin\\Login")->group("admin");
$router->get("/login", "LoginController:index");
$router->get("/register", "LoginController:registerUser");
$router->get("/forgotpassword", "LoginController:forgotPassword");
$router->post("/forgotpassword/email", "LoginController:sendToken");
$router->get("/forgotpassword/{token}", "LoginController:redefinePassword");

$router->dispatch();


if ($router->error()) {
    $router->redirect("/error/{$router->error()}");
}
