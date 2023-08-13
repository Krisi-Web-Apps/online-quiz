<?php

class Test
{
  private $name;
  private $slug;
  private $description;
  private $lang;
  private $category_id;
  private $id;
  private $error;

  public function __construct($name, $slug, $category_id, $lang, $description = null)
  {
    $this->setName($name);
    $this->setSlug($slug);
    $this->setCategoryId($category_id);
    $this->setLang($lang);
    $this->setDescription($description);
  }

  private function setName($value) {
    if (empty($value)) {
      $this->setError("all_fields_are_required");
    }
    $this->name = $value;
    $this->setError(null);
  }

  private function setSlug($value) {
    if (empty($value)) {
      $this->setError("all_fields_are_required");
    }
    $this->slug = $value;
    $this->setError(null);
  }

  private function setLang($value) {
    if (empty($value)) {
      $this->setError("all_fields_are_required");
    }
    $this->lang = $value;
    $this->setError(null);
  }

  private function setDescription($value) {
    if (empty($value)) {
      $this->setError("all_fields_are_required");
    }
    $this->description = $value;
    $this->setError(null);
  }

  private function setCategoryId($value) {
    if (empty($value)) {
      $this->setError("invalid_category_id");
    }
    $this->category_id = $value;
    $this->setError(null);
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getId() {
    return $this->id;
  }

  private function setError($error) {
    $this->error = $error;
  }

  public function getError() {
    return $this->error;
  }
  
  public function create() {
    global $db;
    $data = array(
      "name" => $this->name,
      "slug" => $this->slug,
      "description" => $this->description,
      "lang" => $this->lang,
      "category_id" => $this->category_id,
    );
    $db->insert("tests", $data);
    $this->setId($db->lastInsertedId());
  }

  public function edit() {
    global $db;
    $data = array(
      "name" => $this->name,
      "slug" => $this->slug,
      "description" => $this->description,
      "lang" => $this->lang,
      "category_id" => $this->category_id,
    );
    $id = $this->getId();
    $db->update("tests", $data, "id = $id");
  }

  public static function getItem($id) {
    global $db;
    $params = array(":id" => $id);
    $items = $db->select("SELECT * FROM tests WHERE id = :id;", $params);
    if ($items) {
      return $items[0];
    }
  }

  public static function getItems() {
    global $db;
    $items = $db->select("SELECT t.name, t.id, t.lang, COUNT(q.id) AS question_count
                          FROM tests t
                          LEFT JOIN questions q ON t.id = q.test_id
                          GROUP BY t.id, t.name
                          ORDER BY t.id;
    ");
    return $items;
  }

  public static function deleteItem($id) {
    global $db;
    $db->delete("tests", "id = $id");
  }
}
