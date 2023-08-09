<?php

$router->addRoute("/translations", function () {
  view("translations/save");
});

$router->addRoute("/translations/all", function () {
  view("translations/all");
});
