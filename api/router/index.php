<?php

$router = new Router();

$router->addRoute("/", function () {
  view("home");
});

require "home/index.php";
require "users/index.php";
require "translations/index.php";
require "categories/index.php";
require "tests/index.php";
require "questions/index.php";

$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->handleRequest($currentPath);
