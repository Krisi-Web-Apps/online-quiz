<?php

$response = new Response();
global $db;

if (isset($_GET["lang"])) {

  $lang = $_GET["lang"];

  $params = array(":lang" => $lang);
  $translations = $db->select("SELECT * FROM translations WHERE lang = :lang;", $params);
  
  $response->setData($translations);
  $response->sendJson();
} else if (isset($_GET["without_lang"])) {

  $without_lang = $_GET["without_lang"];

  $params = array(":without_lang" => $without_lang);

  $translations = $db->select("
      SELECT *
      FROM translations AS bg
      WHERE bg.lang = 'bg'
      AND NOT EXISTS (
          SELECT 1
          FROM translations AS en
          WHERE en.name = bg.name AND en.lang = :without_lang
      );
  ", $params);
  
  $response->setData($translations);
  $response->sendJson();
} else {
  $response->sendError("Method not allowed", Response::HTTP_METHOD_NOT_ALLOWED);
}
