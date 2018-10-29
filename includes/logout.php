<?php
session_start();
require_once dirname(__DIR__) . "/vendor/autoload.php";
$dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load(__DIR__ . '/..');
include (dirname(__FILE__) . "/db.php");
include (dirname(__FILE__) . "/../admin/functions.php");
$session_id = session_id();
$_SESSION['user_id'] = null;
$_SESSION['username'] = null;
$_SESSION['user_firstname'] = null;
$_SESSION['user_lastname'] = null;
$_SESSION['user_role'] = null;

$query = "
    DELETE FROM
        users_online
    WHERE
        session = '$session_id';
";
$result = confirmQuery($query);

header("Location: /cms/index.php");
exit;