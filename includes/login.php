<?php
session_start();
require_once dirname(__DIR__) . "/vendor/autoload.php";
$dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load(__DIR__ . '/..');
include (dirname(__FILE__) . "/db.php");
include (dirname(__FILE__) . "/../admin/functions.php");
if (isset($_POST['login'])) {
    loginUser($_POST['username'], $_POST['password']);
}

redirect('/cms/index.php');
