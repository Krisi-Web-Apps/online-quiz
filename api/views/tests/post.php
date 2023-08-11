<?php

require "middlewares/is-authenticated.php";

$response = new Response();

if ($_SERVER["REQUEST_METHOD"] = "POST") {

  $jsonData = file_get_contents("php://input");
  $data = json_decode($jsonData, true);

  if (isset($data["name"]) == FALSE || isset($data["slug"]) == FALSE || isset($data["desc"]) == FALSE || isset($data["category_id"]) == FALSE) {
    $response->sendError("all_fields_is_required", 400);
  }
  
  if (empty($data["id"])) {
    $test = new Test($data["name"], $data["slug"], $data["category_id"], $data["desc"]);
  
    if (empty($test->getError()) == FALSE) {
      $response->sendError($test->getError());
    }
  
    $test->create();
  } else {
    $test = new Test($data["name"], $data["slug"], $data["category_id"], $data["desc"]);

    if (empty($test->getError()) == FALSE) {
      $response->sendError($test->getError());
    }

    $test->setId($data["id"]);

    $test->edit();
  }
  
  $item = $test->getItem($test->getId());

  $response->setData($item);
  if (empty($data["id"])) $response->setStatusCode(Response::HTTP_CREATED);
  else $response->setStatusCode(Response::HTTP_OK);
  $response->sendJson();
}