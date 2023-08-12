<?php

class Question {
  private $id;
  private $title;
  private $answers = [];
  private $testId;
  private $lang;
  private $error;

  public function __construct($title, $answers, $testId, $lang) {
    $this->setTitle($title);
    $this->setAnswers($answers);
    $this->setTestId($testId);
    $this->setLang($lang);
  }
  
  private function setTitle($value) {
    if (empty($value)) {
      $this->error = "all_fields_are_required";
      return;
    }
    $this->error = null;
    $this->title = $value;
  }

  private function setAnswers($value) {
    if (empty($value)) {
      $this->error = "all_fields_are_required";
      return;
    }
    $this->error = null;
    $this->answers = $value;
  }

  private function setTestId($value) {
    if (empty($value)) {
      $this->error = "all_fields_are_required";
      return;
    }
    $this->error = null;
    $this->testId = $value;
  }

  private function setLang($value) {
    if (empty($value)) {
      $this->error = "all_fields_are_required";
      return;
    }
    $this->error = null;
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
      "title" => $this->title,
      "answers" => $this->answers,
      "test_id" => $this->testId,
      "lang" => $this->lang,
    );
    $db->insert("questions", $data);
    $this->id = $db->lastInsertedId();
  }

  public function edit() {
    global $db;
    $params = array(":id" => $this->id);
    $data = array(
      "title" => $this->title,
      "answers" => $this->answers,
      "test_id" => $this->testId,
      "lang" => $this->lang,
    );
    $db->update("questions", $data, $params);
  }

  public static function getItem($id) {
    global $db;
    $params = array(":id" => $id);
    $items = $db->select("SELECT * FROM questions WHERE id = :id;", $params);
    if ($items) {
      return $items[0];
    }
  }

  public static function getItems() {
    global $db;
    $items = $db->select("SELECT * FROM questions;");
    return $items;
  }

  public static function deleteItem($id) {
    global $db;
    $params = array(":id" => $id);
    $db->select("DELETE FROM questions WHERE id = :id;", $params);
  }
}
