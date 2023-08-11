<?php

$router->addRoute("/tests", function () {
  view("tests/post");
});

$router->addRoute("/tests/:id", function ($params) {
  $_SESSION["params"] = $params;
  view("tests/get");
});