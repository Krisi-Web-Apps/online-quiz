<?php

$router->addRoute("/translations", function () {
  view("translations/save");
});

$router->addRoute("/translations/all", function () {
  view("translations/all");
});

$router->addRoute("/translations/admin", function () {
  view("translations/admin");
});
