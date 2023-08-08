<?php

$router = new Router();

$router->addRoute("/", function () {
  view("home");
});

require "home/index.php";
require "users/index.php";

$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->handleRequest($currentPath);
