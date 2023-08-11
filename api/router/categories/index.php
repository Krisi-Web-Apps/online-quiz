<?php

$router->addRoute("/categories", function () {
  view("categories/index");
});

$router->addRoute("/categories/:id", function ($params) {
  $_SESSION["params"] = $params;
  view("categories/get-item");
});