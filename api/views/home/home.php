<?php

$response = new Response();

$data = array(
  "message" => "Welcome, to online_quiz API!"
);

$response->setData($data);
$response->sendJson();