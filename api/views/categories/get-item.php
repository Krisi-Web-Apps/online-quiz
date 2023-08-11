<?php

$response = new Response();

if ($_SERVER["REQUEST_METHOD"] == "GET") {

  if (isset($_SESSION["params"]) == FALSE || isset($_SESSION["params"]["id"]) == FALSE) {
    $response->sendError("invalid_id", Response::HTTP_BAD_REQUEST);
  }

  $id = $_SESSION["params"]["id"];
  $category = Category::getItem($id);

  $response->setData($category);
  $response->sendJson();
} else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {

  if (isset($_SESSION["params"]) == FALSE || isset($_SESSION["params"]["id"]) == FALSE) {
    $response->sendError("invalid_id", Response::HTTP_BAD_REQUEST);
  }

  $id = $_SESSION["params"]["id"];
  Category::deleteItem($id);

  $response->setStatusCode(Response::HTTP_OK);
  $response->sendJson();
} else {
  $response->sendError("Method not allowed", Response::HTTP_METHOD_NOT_ALLOWED);
}
