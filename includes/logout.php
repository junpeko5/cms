<?php
session_start();
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