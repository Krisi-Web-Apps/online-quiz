<?php

$response = new Response();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  require "middlewares/is-authenticated.php";

  $jsonData = file_get_contents("php://input");
  $data = json_decode($jsonData, true);

  if (
    isset($data["name"]) == FALSE ||
    isset($data["slug"]) == FALSE ||
    isset($data["lang"]) == FALSE ||
    isset($data["description"]) == FALSE ||
    isset($data["category_id"]) == FALSE
  ) {
    $response->sendError("all_fields_is_required", 400);
  }

  if (empty($data["id"])) {
    $test = new Test(
      $data["name"],
      $data["slug"],
      $data["category_id"],
      $data["lang"],
      json_encode($data["description"])
    );

    if (empty($test->getError()) == FALSE) {
      $response->sendError($test->getError());
    }

    $test->create();
  } else {
    $test = new Test(
      $data["name"],
      $data["slug"],
      $data["category_id"],
      $data["lang"],
      json_encode($data["description"])
    );

    if (empty($test->getError()) == FALSE) {
      $response->sendError($test->getError());
    }

    $test->setId($data["id"]);

    $test->edit();
  }

  $item = $test->getItem($test->getId());

  $item["description"] = json_decode($item["description"]);

  $response->setData($item);
  if (empty($data["id"]))
    $response->setStatusCode(Response::HTTP_CREATED);
  else
    $response->setStatusCode(Response::HTTP_OK);
  $response->sendJson();
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {

  if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $item = Test::getItem($id);
    
    $item["description"] = json_decode($item["description"]);

    if ($item) {
      $response->setData($item);
      $response->sendJson();
    } else {
      $response->sendError("invalid_id", Response::HTTP_NOT_FOUND);
    }
  }

  $items = Test::getItems();

  $response->setData($items);
  $response->sendJson();
}
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {

  if (empty($_GET["id"])) {
    $response->sendError("invalid_id", Response::HTTP_BAD_REQUEST);
  }

  $id = $_GET["id"];

  Test::deleteItem($id);

  $response->sendJson();
} else {
  $response->sendError("Method Not Allowed", Response::HTTP_METHOD_NOT_ALLOWED);
}
