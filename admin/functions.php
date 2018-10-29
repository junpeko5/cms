<?php

function h($in) {
    return htmlspecialchars($in, ENT_QUOTES, 'UTF-8');
}

function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, trim(strip_tags($string)));
}

// ログインセッション数を取得
users_online();


/**
 * ログインしているユーザー数を表示
 */
function users_online() {
    if (isset($_GET['online_users'])) {
        session_start();
        $session = session_id();
        $now = time();
        $time_out_in_seconds = 30;
        $time_out = $now + $time_out_in_seconds;
        // セッション情報があるかチェック
        $query = "
            SELECT
                *
            FROM
                users_online
            WHERE
                session = '$session'
        ";

        $result = confirmQuery($query);
        $count = mysqli_num_rows($result);
        // セッションが登録されていなければinsert、あればupdate
        if ($count == NULL) {
            // タイムアウト時間を登録
            $query = "
                INSERT INTO
                    users_online 
                (
                    session, 
                    time_out
                )
                VALUES
                (
                    '$session', 
                    $time_out
                )
            ";
            confirmQuery($query);
        } else {
            // タイムアウト時間を更新
            $query = "
            UPDATE
                users_online
            SET
                time_out = $time_out
            WHERE
                session = '$session'
        ";
            confirmQuery($query);
        }
        // タイムアウト時間が現在時間より未来の場合
        $query = "
        SELECT
            *
        FROM
            users_online
        WHERE
            time_out > $now
    ";
        $result = confirmQuery($query);
        $count_user = mysqli_num_rows($result);
        echo $count_user;
    }
}


function confirmQuery($query) {
    global $connection;
    if (!$connection) {
        include (dirname(__FILE__) . "/../includes/db.php");
    }
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("Query Failed " . mysqli_error($connection));
    }
    return $result;
}

function insert_categories() {
    if (isset($_POST['submit'])) {
        $cat_title = escape($_POST['cat_title']);
        if ($cat_title == "" || empty($cat_title)) {
            echo "This field should not be empty";
        } else {
            $query = "
                INSERT INTO 
                  categories 
                  (cat_title) 
                VALUES 
                  ('$cat_title')
            ";
            confirmQuery($query);
        }
    }

}

function findAllCategories() {
    $query = "SELECT * FROM categories";
    $select_all_categories_query = confirmQuery($query);


    while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";
    }
}

function updateCategories($cat_id) {

    if (isset($_POST['update_category'])) {
        $update_cat_title = escape($_POST['update_category']);
        $query = "
        UPDATE
            categories
        SET
            cat_title = '{$update_cat_title}'
        WHERE
            cat_id = {$cat_id}
        ";
        confirmQuery($query);
    }
}

function delete_categories() {

    if (isset($_GET['delete'])) {
        $delete_cat_id = escape($_GET['delete']);
        $query = "
            DELETE FROM
              categories
            WHERE
              cat_id = {$delete_cat_id}
        ";
        confirmQuery($query);
        redirect("/cms/admin/categories.php");
    }
}

function getCategoryTitle() {

    if (isset($_GET['edit'])) {
        $cat_id = escape($_GET['edit']);

        $query = "SELECT * FROM categories WHERE cat_id = {$cat_id}";
        $select_cat_query = confirmQuery($query);

        while ($row = mysqli_fetch_assoc($select_cat_query)) {
            return $row['cat_title'];
        }
    }
    return false;
}

function isAdminUser() {
    if (empty($_SESSION['user_id'])) {
        return false;
    }
    $user_id = $_SESSION['user_id'];
    $query = "
        SELECT
            user_role 
        FROM
          users
        WHERE
          user_id = {$user_id}
    ";
    $select_query = confirmQuery($query);
    while ($row = mysqli_fetch_assoc($select_query)) {
        $user_role = $row['user_role'];
    }
    if ($user_role === 'admin') {
        return true;
    }
    return false;
}

function getAllPostCount() {
    if (isAdminUser()) {
        return recordCount('posts');
    } else {
        $query = "
            SELECT 
                * 
            FROM 
                posts 
            WHERE 
                post_status = 'published'
        ";
        $result = confirmQuery($query);
        return mysqli_num_rows($result);
    }

}

function unapproved() {
    if (isset($_GET['unapproved'])) {
        $unapproved_comment_id = escape($_GET['unapproved']);
        $query = "
                UPDATE 
                    comments 
                SET 
                    comment_status = 'unapproved'
                WHERE
                    comment_id = $unapproved_comment_id 
                ";
        confirmQuery($query);
        redirect("/cms/admin/comments.php");
    }
}

function approved() {
    if (isset($_GET['approved'])) {
        $approve_comment_id = escape($_GET['approved']);
        $query = "
                UPDATE 
                    comments 
                SET 
                    comment_status = 'approved'
                WHERE
                    comment_id = $approve_comment_id 
                ";
        confirmQuery($query);
        redirect("/cms/admin/comments.php");
    }
}

function recordCount($table) {
    $query = "
        SELECT * FROM $table
    ";
    $result = confirmQuery($query);
    return mysqli_num_rows($result);
}

function checkStatus($table, $column, $status) {
    $query = "
                SELECT 
                    * 
                FROM 
                    $table
                WHERE
                    $column = '$status'
            ";
    $result = confirmQuery($query);
    return mysqli_num_rows($result);
}

function countById($table, $column, $id) {
    $query = "
                SELECT 
                    * 
                FROM 
                    $table
                WHERE
                    $column = $id
            ";
    $result = confirmQuery($query);
    return mysqli_num_rows($result);
}

function username_exists($username) {
    $count = checkStatus('users', 'username', $username);
    if ($count > 0) {
        return true;
    }
    return false;
}

function email_exists($email) {
    $count = checkStatus('users', 'user_email', $email);
    if ($count > 0) {
        return true;
    }
    return false;
}

function redirect($location) {
    header("Location: " . $location);
    exit;
}

function validateUser($username, $email, $password) {
    $username = escape(trim($username));
    $email = escape(trim($email));
    $password = escape(trim($password));
    $errors= [];

    if (strlen($username) < 4) {
        $errors['username'] = 'ユーザー名は４文字以上で入力してください。';
    }
    if (empty($username)) {
        $errors['username'] = 'ユーザーを入力してください。';
    }
    if (username_exists($username)) {
        $errors['username'] = 'ユーザー名はすでに登録されています。';
    }
    if (empty($email)) {
        $errors['email'] = 'メールアドレスを入力してください。';
    }
    if (email_exists($email)) {
        $errors['email'] = "メールアドレスはすでに登録されています。<a href='/cms/index.php'>ログインしてください</a>";
    }

    if (empty($password)) {
        $errors['password'] = "パスワードを入力してください。";
    }

    if (empty($errors['username']) && empty($errors['email']) && empty($errors['password'])) {
        unset($errors);
        $errors = [];
    }
    return $errors;
}

function loginUser($username, $password) {
    $username = escape(trim($username));
    $password = escape(trim($password));
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

        redirect("/cms/admin");
    }

    // ログイン情報が一致しない場合
    redirect("/cms/index.php");
}

function registerUser($username, $email, $password) {
    $username = escape(trim($username));
    $email = escape(trim($email));
    $password = password_hash($password, PASSWORD_BCRYPT);
    $user_role = 'subscriber';
    $query = "
            INSERT INTO
                users
            (
                username, 
                user_email, 
                user_password, 
                user_role
            )
            VALUES 
            (
                '$username',
                '$email',
                '$password',
                '$user_role'
            )
        ";
    confirmQuery($query);
}

function logoutUser() {
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
    confirmQuery($query);
}


function isPost() {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        return true;
    }
    return false;
}