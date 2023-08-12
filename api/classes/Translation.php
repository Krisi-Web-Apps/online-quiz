<?php

class Translation
{
  private $id;
  private $name;
  private $text;
  private $lang;
  private $error;

  public function __construct($name, $text, $lang)
  {
    $this->setName($name);
    $this->setText($text);
    $this->setLang($lang);
  }

  private function setId($value)
  {
    if (empty($value)) {
      $this->setError("invalid_id");
      return;
    }
    $this->setError(null);
    $this->id = $value;
  }

  private function setName($value)
  {
    if (empty($value)) {
      $this->setError("all_fields_are_required");
      return;
    }
    $this->setError(null);
    $this->name = $value;
  }

  private function setText($value)
  {
    if (empty($value)) {
      $this->setError("all_fields_are_required");
      return;
    }
    $this->setError(null);
    $this->text = $value;
  }

  private function setLang($value)
  {
    if (empty($value)) {
      $this->setError("all_fields_are_required");
      return;
    }
    $this->setError(null);
    $this->lang = $value;
  }
  
  private function setError($value) {
    $this->error = $value;
  }

  public function getError() {
    return $this->error;
  }

  public function getId() {
    return $this->id;
  }

  public function create() {
    global $db;
    $data = array(
      "name" => $this->name,
      "text" => $this->text,
      "lang" => $this->lang,
    );
    $db->insert("translations", $data);
    $this->setId($db->lastInsertedId());
  }

  public function edit() {
    global $db;
    $params = array(":id" => $this->getId());
    $data = array(
      "name" => $this->name,
      "text" => $this->text,
      "lang" => $this->lang,
    );
    $db->update("translations", $data, $params);
  }

  public static function getItem($id) {
    global $db;
    $params = array(":id" => $id);
    $items = $db->select("SELECT * FROM translations WHERE id = :id;", $params);
    if ($items) {
      return $items[0];
    }
  }

  public static function getWithoutLangItems($withoutLang) {
    global $db;
    $params = array(":without_lang" => $withoutLang);
    $items = $db->select("
      SELECT *
      FROM translations AS bg
      WHERE bg.lang = 'bg'
      AND NOT EXISTS (
          SELECT 1
          FROM translations AS en
          WHERE en.name = bg.name AND en.lang = :without_lang
      );
  ", $params);
    return $items;
  }

  public function getItems() {
    global $db;
    $items = $db->select("SELECT * FROM translations WHERE id = :id;");
    return $items;
  }

  public static function deleteItem($id) {
    global $db;
    $params = array(":id" => $id);
    $db->select("DELETE FROM translations WHERE id = :id;", $params);
  }
}
