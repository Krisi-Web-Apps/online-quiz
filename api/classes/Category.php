<?php

class Category {
  private $id;
  private $name;
  private $slug;
  private $desc;
  private $lang;
  private $error;

  public function __construct($name, $slug, $desc = null, $lang = null) {
    $this->setName($name);
    $this->setSlug($slug);
    $this->lang = $lang;
    $this->desc = $desc;
  }

  private function setName($value) {
    if (empty($value)) {
      $this->setError("all_fields_with_a_star_are_required");
      return;
    }
    $this->name = $value;
    $this->setError(null);
  }

  private function setSlug($value) {
    if (empty($value)) {
      $this->setError("all_fields_with_a_star_are_required");
      return;
    }
    $this->slug = $value;
    $this->setError(null);
  }
  
  private function setError($error) {
    $this->error = $error;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getError() {
    return $this->error;
  }

  public function getItem() {
    global $db;
    $params = array(":id" => $this->id);
    $items = $db->select("SELECT * FROM categories WHERE id = :id;", $params);
    return $items[0];
  }
  
  public function create() {
    global $db;
    $data = array(
      "name" => $this->name,
      "slug" => $this->slug,
      "description" => $this->desc,
      "lang" => $this->lang,
    );
    $db->insert("categories", $data);
    $this->id = $db->lastInsertedId();
  }

  public function edit() {
    global $db;
    $data = array(
      "name" => $this->name,
      "slug" => $this->slug,
      "description" => $this->desc,
      "lang" => $this->lang,
    );
    $id = $this->id;
    $db->update("categories", $data, "id = $id;");
  }
}
