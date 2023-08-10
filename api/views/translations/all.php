<?php

$response = new Response();
global $db;

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