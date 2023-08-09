<?php

$response = new Response();
global $db;

$lang = $_GET["lang"];

$params = array(":lang" => $lang);
$translations = $db->select("SELECT * FROM translations WHERE lang = :lang;", $params);

$transformedTranslations = [];

foreach ($translations as $translation) {
  $transformedTranslations[$translation['name']] = $translation['text'];
}

$response->setData($transformedTranslations);
$response->sendJson();