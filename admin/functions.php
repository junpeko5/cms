<?php
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
    global $connection;
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
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
            $create_category_query = mysqli_query($connection, $query);
            if (!$create_category_query) {
                die('QUERY FAILED' . mysqli_error($connection));
            }
        }
    }

}

function findAllCategories() {
    global $connection;
    $query = "SELECT * FROM categories";
    $select_all_categories_query = mysqli_query($connection, $query);


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
    global $connection;

    if (isset($_POST['update_category'])) {
        $update_cat_title = $_POST['update_category'];
        $query = "
        UPDATE
            categories
        SET
            cat_title = '{$update_cat_title}'
        WHERE
            cat_id = {$cat_id}
    ";
        $update_query = mysqli_query($connection, $query);
        if (!$update_query) {
            die("Query failed" . mysqli_error($connection));
        }
    }
}

function delete_categories() {
    global $connection;

    if (isset($_GET['delete'])) {
        $delete_cat_id = $_GET['delete'];
        $query = "
            DELETE FROM
              categories
            WHERE
              cat_id = {$delete_cat_id}
        ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php");
    }
}

function getCategoryTitle() {
    global $connection;

    if (isset($_GET['edit'])) {
        $cat_id = $_GET['edit'];

        $query = "SELECT * FROM categories WHERE cat_id = {$cat_id}";
        $select_cat_query = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_cat_query)) {
            return $row['cat_title'];
        }
    }
    return false;
}

function isAdminUser() {
    global $connection;
    $user_id = $_SESSION['user_id'];
    $query = "
            SELECT
                user_role 
            FROM
              users
            WHERE
              user_id = {$user_id}
        ";
    $select_query = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_query)) {
        $user_role = $row['user_role'];
    }
    if ($user_role === 'admin') {
        return true;
    }
    return false;
}