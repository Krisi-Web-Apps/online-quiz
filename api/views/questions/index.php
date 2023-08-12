<?php

$response = new Response();

if (
  $_SERVER["REQUEST_METHOD"] == "GET"
  && isset($_GET["id"])
) {

  $id = $_GET["id"];

  $item = Question::getItem($id);

  if ($item) {
    $response->setData($item);
    $response->sendJson();
  }

  $response->sendError("Not Found", Response::HTTP_NOT_FOUND);
} else if (
  $_SERVER["REQUEST_METHOD"] == "GET"
  && isset($_GET["all"])
) {

  $items = Question::getItems();

  $response->setData($items);
  $response->sendJson();
} else if (
  $_SERVER["REQUEST_METHOD"] == "POST"
) {

  $jsonData = file_get_contents("php://input");
  $data = json_decode($jsonData, true);

  if (
    isset($data["title"]) == FALSE ||
    isset($data["answers"]) == FALSE ||
    isset($data["test_id"]) == FALSE ||
    isset($data["lang"]) == FALSE
  ) {
    $response->sendError("all_fields_is_required", 400);
  }

  $question = new Question(
    $data["title"],
    json_encode($data["answers"]),
    $data["test_id"],
    $data["lang"]
  );

  if (isset($data["id"]) == FALSE)
    $question->create();
  else
    $question->edit();

  $item = Question::getItem($question->getId());

  $item["answers"] = json_decode($item["answers"]);

  $response->setData($item);
  $response->sendJson();
} else {
  $response->sendError("Method Not Allowed", Response::HTTP_METHOD_NOT_ALLOWED);
}
