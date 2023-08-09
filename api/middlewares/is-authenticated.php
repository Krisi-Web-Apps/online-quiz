<?php

$response = new Response();
global $db;
$krisi_jwt = new KrisiJWT(SECRET_JWT);

if (isset($_SERVER["HTTP_AUTHORIZATION"]) && empty($_SERVER["HTTP_AUTHORIZATION"]) == FALSE) {

  $full_token = $_SERVER["HTTP_AUTHORIZATION"];
  $token = explode(" ", $full_token)[1];

  try {
    $decoded = $krisi_jwt->decode($token);

    $params = array(":id" => $decoded["id"]);
    $user = $db->select("SELECT id, password FROM users WHERE id = :id", $params);

    if ($user) {
      $user = $user[0];
      if ($decoded["password"] != $user["password"]) {
        $response->sendError("Not Authorized", 403);
      }
    } else {
      $response->sendError("Not Found", 404);
    }
  } catch (\Exception $ex) {
    $response->sendError($ex->getMessage(), $ex->getCode());
  }
} else {
  $response->sendError("Not Authrized", 403);
}
