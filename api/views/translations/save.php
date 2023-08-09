<?php

require "middlewares/is-authenticated.php";

$response = new Response();
global $db;

if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
  
  $jsonData = file_get_contents("php://input");
  $data = json_decode($jsonData, true);

  if (isset($data["name"]) == FALSE || isset($data["text"]) == FALSE || isset($data["lang"]) == FALSE) {
    $response->sendError("all_fields_is_required", 400);
  }

  $name = htmlspecialchars($data["name"]);
  $text = htmlspecialchars($data["text"]);
  $lang = htmlspecialchars($data["lang"]);

  if (empty($name) || empty($text) || empty($lang)) {
    $response->sendError("all_fields_is_required", 400);
  }

  if (isset($data["id"]) == FALSE) {
    $data = array(
      "name" => $name,
      "text" => $text,
      "lang" => $lang,
    );
    try {
      $db->insert("translations", $data);
    } catch(\Exception $ex) {
      $response->sendError($ex->getMessage(), $ex->getCode());
    }

    $id = $db->lastInsertedId();

    $response->setData(array_merge(
      array("id" => $id),
      $data,
    ));
    unset($data);
    $response->setStatusCode(201);
    $response->sendJson();
  }

  $id = $data["id"];
  $params = array(":id" => $id);
  $translation = $db->select("SELECT * FROM translations WHERE id = :id;", $params);

  if ($translation == FALSE) {
    $response->sendError("invalid_id", 400);
  }

  $data = array(
    "name" => $name,
    "text" => $text,
    "lang" => $lang,
  );
  $db->update("translations", $data, "id = $id");

  $data = array(
    "id" => $id,
    "name" => $name,
    "text" => $text,
    "lang" => $lang,
  );
  $response->setStatusCode(200);
  $response->setData($data);
  $response->sendJson();
}