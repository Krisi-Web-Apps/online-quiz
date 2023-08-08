<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

define("HOST", "localhost");
define("DATABASE_USER", "root");
define("DATABASE_PASSWORD", "root");
define("DATABASE_NAME", "online_quiz");
define("CHARSET", "utf8");

$db = new Database(HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME, CHARSET);

session_start();