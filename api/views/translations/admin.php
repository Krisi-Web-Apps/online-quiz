<?php

$response = new Response();
global $db;

if (isset($_GET["lang"])) {

  $lang = $_GET["lang"];

  $params = array(":lang" => $lang);
  $translations = $db->select("SELECT * FROM translations WHERE lang = :lang;", $params);
  
  $response->setData($translations);
  $response->sendJson();
} else {
  $response->sendError("Method not allowed", 405);
}
