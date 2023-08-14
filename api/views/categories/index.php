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
    "desc" => json_encode($data["description"]),
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

  $fetchedCategory = Category::getItem($category->getId());

  $fetchedCategory["description"] = json_decode($fetchedCategory["description"]);

  $response->setData($fetchedCategory);
  $response->sendJson();
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {

  // if (isset($_GET["lang"]) == FALSE) {
  //   $response->sendError("invalid_lang_parameter", Response::HTTP_BAD_REQUEST);
  // }

  // $lang = $_GET["lang"];
  $categories = Category::getItems();

  $response->setData($categories);
  $response->sendJson();
} else {
  $response->sendError("Method not allowed", Response::HTTP_METHOD_NOT_ALLOWED);
}
