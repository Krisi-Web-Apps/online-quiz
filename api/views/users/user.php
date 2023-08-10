<?php

require "middlewares/is-authenticated.php";
global $db;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $params = array(":id" => $decoded["id"]);
  $user = $db->select("SELECT * FROM users WHERE id = :id", $params);
  if ($user) {
    $user = $user[0];
    unset($user["password"]);
    $response->setStatusCode(200);
    $response->setData($user);
    $response->sendJson();
  } else {
    $response->sendError("Not Found", 404);
  }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $jsonData = file_get_contents('php://input');
  $data = json_decode($jsonData, true);

  $fullname = htmlspecialchars($data["fullname"]);
  $lang = htmlspecialchars($data["lang"]);
  $id = $data["id"];

  $data = array(
    "fullname" => $fullname,
    "lang" => $lang,
  );
  global $db;
  $db->update("users", $data, "id = $id;");

  $params = array(":id" => $id);
  $user = $db->select("SELECT * FROM users WHERE id = :id", $params);
  if ($user) {
    $user = $user[0];
    unset($user["password"]);
    $response->setStatusCode(200);
    $response->setData($user);
    $response->sendJson();
  } else {
    $response->sendError("Not Found", 404);
  }
} else {
  $response->sendError("Method not allowed", 405);
}