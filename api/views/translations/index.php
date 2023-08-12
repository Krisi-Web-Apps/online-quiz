<?php

$response = new Response();
global $db;

if (
  $_SERVER["REQUEST_METHOD"] == "GET"
  && isset($_GET["as_key_value_pairs"])
) {

  $translations = $db->select("SELECT * FROM translations;");

  $transformedTranslations = [];

  foreach ($translations as $translation) {
    $locale = $translation['lang'];

    if (!isset($transformedTranslations[$locale])) {
      $transformedTranslations[$locale] = [];
    }

    $transformedTranslations[$locale][$translation['name']] = $translation['text'];
  }

  $response->setData($transformedTranslations);
  $response->sendJson();

} else if (
  $_SERVER["REQUEST_METHOD"] == "GET"
  && isset($_GET["all"])
) {

  $translations = $db->select("SELECT * FROM translations;");

  $response->setData($translations);
  $response->sendJson();

} else if (
  $_SERVER["REQUEST_METHOD"] == "GET"
  && isset($_GET["lang"])
) {

  $lang = $_GET["lang"];

  $params = array(":lang" => $lang);
  $translations = $db->select("SELECT * FROM translations WHERE lang = :lang;", $params);

  $response->setData($translations);
  $response->sendJson();

} else if (
  $_SERVER["REQUEST_METHOD"] == "GET"
  && isset($_GET["without_lang"])
) {

  $lang = $_GET["without_lang"];
  
  $items = Translation::getWithoutLangItems($lang);

  $response->setData($items);
  $response->sendJson();

} else if (
  isset($_POST)
  && $_SERVER["REQUEST_METHOD"] == "POST"
) {

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

  // CREATE TRANSLATION

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
  
  // UPDATE TRANSLATION

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

} else if (
  $_SERVER["REQUEST_METHOD"] == "DELETE"
  && isset($_GET["id"])
) {

  $id = $_GET["id"];

  if (empty($id)) {
    $response->sendError("invalid_id", Response::HTTP_BAD_REQUEST);
  }

  $item = Translation::getItem($id);

  if ($item) {
    Translation::deleteItem($id);
    $response->setStatusCode(Response::HTTP_NO_CONTENT);
    $response->sendJson();
  }
  
  $response->sendError("Not Found", Response::HTTP_NOT_FOUND);
} else {
  $response->sendError("Method Not Allowed", Response::HTTP_METHOD_NOT_ALLOWED);
}
