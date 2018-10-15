<?php
include (dirname(__FILE__) . "/db.php");
include (dirname(__FILE__) . "/../admin/functions.php");

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
}

$username = mysqli_real_escape_string($connection, $username);
$password = mysqli_real_escape_string($connection, $password);

$query = "
    SELECT
        *
    FROM
        users
    WHERE
        username = '$username'
        AND user_password = '$password'
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

if ($username !== $db_username && $password !== $db_password) {
    header("Location: ../index.php");
    exit;
}

header("Location: ../admin");
exit;