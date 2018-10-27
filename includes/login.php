<?php
include (dirname(__FILE__) . "/db.php");
include (dirname(__FILE__) . "/../admin/functions.php");
session_start();
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
}

$username = mysqli_real_escape_string($connection, $username);
//$password = mysqli_real_escape_string($connection, $password);

$query = "
    SELECT
        *
    FROM
        users
    WHERE
        username = '$username'
";

$select_user = confirmQuery($query);
while($row = mysqli_fetch_assoc($select_user)) {
    $db_id = $row['user_id'];
    $db_username = $row['username'];
    $db_user_first_name = $row['user_firstname'];
    $db_user_last_name = $row['user_lastname'];
    $db_password = $row['user_password'];
    $db_user_role = $row['user_role'];
}

// 一致した場合
if (password_verify($password, $db_password)) {
    $_SESSION['user_id'] = $db_id;
    $_SESSION['username'] = $db_username;
    $_SESSION['user_firstname'] = $db_user_first_name;
    $_SESSION['user_lastname'] = $db_user_last_name;
    $_SESSION['user_role'] = $db_user_role;

    header("Location: /cms/admin");
    exit;
}

// ログイン情報が一致しない場合
header("Location: /cms/index.php");
exit;


