<?php

class Test
{
  private $name;
  private $slug;
  private $desc;
  private $category_id;
  private $id;
  private $error;

  public function __construct($name, $slug, $category_id, $desc = null)
  {
    $this->setCategoryId($category_id);
    $this->setName($name);
    $this->setSlug($slug);
    $this->setDesc($desc);
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

  private function setDesc($value) {
    if (empty($value)) {
      $this->setError("all_fields_are_required");
    }
    $this->desc = $value;
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
      "description" => $this->desc,
      "category_id" => $this->category_id,
    );
    $db->insert("tests", $data);
    $this->setId($db->lastInsertedId());
  }

  public function edit() {
    global $db;
    $params = array(":id" => $this->id);
    $data = array(
      "name" => $this->name,
      "slug" => $this->slug,
      "description" => $this->desc,
      "category_id" => $this->category_id,
    );
    $db->update("tests", $data, $params);
  }

  public function getItem($id) {
    global $db;
    $params = array(":id" => $id);
    $items = $db->select("SELECT * FROM tests WHERE id = :id;", $params);
    return $items[0];
  }

  public function getItems() {
    global $db;
    $items = $db->select("SELECT * FROM tests;");
    return $items;
  }
}
