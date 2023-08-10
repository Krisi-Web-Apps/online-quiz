<?php

$response = new Response();
global $db;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $jsonData = file_get_contents("php://input");
  $data = json_decode($jsonData, true);

  if (!isset($data["name"]) || !isset($data["slug"])) {
    $response->sendError("all_fields_with_a_star_are_required", Response::HTTP_BAD_REQUEST);
  }

  $dataToInsert = array(
    "name" => $data["name"],
    "slug" => $data["slug"],
    "desc" => isset($data["desc"]) ? $data["desc"] : null,
    "lang" => isset($data["lang"]) ? $data["lang"] : null
  );

  if (isset($data["id"]) == FALSE) {
    $category = new Category(...$dataToInsert);
  
    if ($category->getError()) {
      $response->sendError($category->getError(), Response::HTTP_BAD_REQUEST);
    }
  
    $category->create();
  } else {
    $category = new Category(...$dataToInsert);
    $category->setId($data["id"]);

    if ($category->getError()) {
      $response->sendError($category->getError(), Response::HTTP_BAD_REQUEST);
    }

    $category->edit();
  }

  $fetchedCategory = $category->getItem();

  $response->setData($fetchedCategory);
  $response->sendJson();
} else {
  $response->sendError("Method not allowed", Response::HTTP_METHOD_NOT_ALLOWED);
}
