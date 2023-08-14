<?php

class Question {
  private $id;
  private $title;
  private $answers = [];
  private $fact;
  private $testId;
  private $lang;
  private $error;

  public function __construct($title, $answers, $testId, $lang, $fact) {
    $this->setTitle($title);
    $this->setAnswers($answers);
    $this->setTestId($testId);
    $this->setLang($lang);
    $this->fact = $fact;
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

  public function setId($value) {
    if (empty($value)) {
      $this->error = "invalid_id";
      return;
    }
    $this->error = null;
    $this->id = $value;
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
      "fact" => $this->fact,
      "test_id" => $this->testId,
      "lang" => $this->lang,
    );
    $db->insert("questions", $data);
    $this->id = $db->lastInsertedId();
  }

  public function edit() {
    global $db;
    $data = array(
      "title" => $this->title,
      "answers" => $this->answers,
      "fact" => $this->fact,
      "test_id" => $this->testId,
      "lang" => $this->lang,
    );
    $id = $this->id;
    $db->update("questions", $data, "id = $id;");
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
    $items = $db->select(
      "SELECT
        q.id,
        q.title,
        q.answers,
        t.name AS test_title,
        q.lang,
        q.test_id
      FROM
        questions AS q,
        tests AS t
      WHERE
        q.test_id = t.id;"
    );
    return $items;
  }

  public static function deleteItem($id) {
    global $db;
    $params = array(":id" => $id);
    $db->select("DELETE FROM questions WHERE id = :id;", $params);
  }
}
