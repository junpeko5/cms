<?php

/********************************** MySQLiのラッパー関数 *********************************/

function query($query, $params = []) {
    global $connection;
    if (!$connection) {
        include (dirname(__FILE__) . "/../includes/db.php");
    }

    $stmt = $connection->prepare($query);
    execute($stmt, $params);
    return $stmt;
}

function _create_bind_param_args($params){
    $args = array("");
    foreach($params as $key => $param){
        if(is_int($param)){
            $args[0] .= "i";
        } elseif(is_double($param)){
            $args[0] .= "d";
        } else {
            if(strpos($param, "\0") === false){
                $args[0] .= "s";
                $param = (string) $param;
            } else {
                $args[0] .= "b";
            }
        }
        $args[] = $param;
    }
    return $args;
}


function execute($stmt, $args = []) {

    if (!empty($args)) {
        $args = _create_bind_param_args($args);

        // 変数のバインド
        call_user_func_array([$stmt, 'bind_param'], refValues($args));
    }
    $stmt->execute();
}


/**
 * 配列の参照渡し用関数
 * @param $arr
 * @return array
 */
function refValues($arr){
    // 自然順での文字列比較・php5.3以上の場合、call_user_func_arrayの第２引数を参照渡しする
    if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+
    {
        $refs = [];
        foreach($arr as $key => $value) {
            $refs[$key] = &$arr[$key];
        }
        return $refs;
    }
    return $arr;
}

function fetch($stmt) {
    if ($stmt instanceof mysqli_stmt) {
        $stmt->store_result();
        $params = [];

        $meta = $stmt->result_metadata();

        while ($field = $meta->fetch_field()) {
            $params[] = &$row[$field->name];
        }

        call_user_func_array([$stmt, 'bind_result'], $params);
        $result = [];
        while ($stmt->fetch()) {
            foreach($row as $key => $val) {
                $c[$key] = $val;
            }
            $result[] = $c;
        }
        return $result;
    }
}

function CountNumRows($query, $args = []) {
    $stmt = query($query, $args);
    fetch($stmt);
    $record_count = $stmt->num_rows();
    $stmt->close();
    return $record_count;
}

/********************************** MySQLiのラッパー関数 *********************************/


/********************************** ユーティリティー *********************************/

function h($in) {
    return htmlspecialchars($in, ENT_QUOTES, 'UTF-8');
}


function redirect($location) {
    header("Location: " . $location);
    exit;
}

function isPost() {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        return true;
    }
    return false;
}

function isGet() {
    if ($_SERVER['REQUEST_METHOD'] === "GET") {
        return true;
    }
    return false;
}

/**
 * デバッグ用関数
 * @param $val
 */
function d($val) {
    echo '<pre>';
    var_dump($val);
    echo '</pre>';
}

function findAll($table) {
    $query = "
        SELECT 
            * 
        FROM 
            $table
        ";
    $stmt = query($query);
    $rows = fetch($stmt);
    $stmt->close();
    return $rows;
}

function recordCount($table) {
    $query = "
        SELECT * FROM $table
    ";

    return CountNumRows($query);
}

function forceString($variable_name) {
    if (isPost()) {
        return (string)filter_input(INPUT_POST, $variable_name);
    } elseif (isGet()) {
        return (string)filter_input(INPUT_GET, $variable_name);
    } else {
        echo 'error';
        exit;
    }

}

function force_1_dimension_array($params) {
    $params = isset($params) ? (array)$params : [];
    return array_filter($params, 'is_string');
}

function findAllById($table, $column, $id) {
    $query = "
        SELECT 
            * 
        FROM 
            $table
        WHERE
            $column = ?
    ";
    $args = [
        $id
    ];

    $stmt = query($query, $args);
    $rows = fetch($stmt);
    $stmt->close();
    if (empty($rows)) {
        return $rows;
    }
    return $rows[0];
}

function findByMultiple($table, $params, $orderColumn = '') {
    $where = "1 = 1";
    $order = '';
    if (!empty($order)) {
        $order = "ORDER BY " . $orderColumn ." DESC";
    }
    foreach ($params as $key => $val) {
        $where .= " AND " . $key . " = ?";
        $args[$key] = $val;
    }

    $query = "
        SELECT 
            * 
        FROM 
            $table
        WHERE
            $where
            $order
    ";

    $stmt = query($query, $args);
    $rows = fetch($stmt);
    $stmt->close();
    return $rows;
}



function checkStatus($table, $column, $status) {
    $query = "
        SELECT 
            * 
        FROM 
            $table
        WHERE
            $column = ?
    ";
    $args = [
        $status
    ];

    return CountNumRows($query, $args);
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
    return CountNumRows($query);
}

function create($table, $params) {
    // アップデートする項目のみ変数に格納する
    $fields = '';
    $values = '';
    foreach ($params as $key => $val) {
        if (isset($val) && $val !== '') {
            $args[$key] = $val;
            $fields .= $key . ",";
            $values .= "?,";
        }
    }
    $fields = trim($fields, ',');
    $values = trim($values, ',');

    $query = "
        INSERT INTO 
            $table 
        (
            $fields
        ) 
        VALUES 
        ( 
            $values
        )
    ";
    $stmt = query($query, $args);
    $stmt->close();
}

function deleteById($table, $column, $id) {
    $query = "
        DELETE FROM
            $table
        WHERE
            $column = ?
    ";
    $args = [$id];
    $stmt = query($query, $args);
    $stmt->close();
}

function fileUpload($files) {
    // 添付ファイルが送信された場合はファイルアップロードを行う
    if (!empty($files['tmp_name'])) {
        $post_image = $files['name'];
        move_uploaded_file($files['tmp_name'], "../images/$post_image");
    }
}


/********************************** ユーティリティー *********************************/


/********************************** posts *********************************/

function findViewAllPosts() {
    $query = "
        SELECT 
            posts.post_id,
            posts.post_user,
            posts.post_title,
            posts.post_category_id,
            posts.post_status,
            posts.post_image,
            posts.post_tags,
            posts.post_comment_count,
            posts.post_date,
            posts.post_views_count,
            categories.cat_id,
            categories.cat_title
        FROM 
            posts 
            LEFT JOIN
                categories
                ON
                    posts.post_category_id = categories.cat_id         
        ORDER BY post_id DESC
    ";

    $stmt = query($query);
    $rows = fetch($stmt);
    $stmt->close();
    return $rows;
}

function findTopPagePosts($offset, $per_page) {
    // ログイン済みかつadminユーザーの場合
    if (isAdminUser()) {
        $query = "
            SELECT 
                * 
            FROM 
                posts 
            ORDER BY post_id DESC 
            LIMIT $offset, $per_page
        ";
    }
    // ログインしていない、またはsubscriberユーザーの場合
    else {
        $query = "
            SELECT 
                * 
            FROM 
                posts 
            WHERE 
                post_status = 'published'
            ORDER BY post_id DESC 
            LIMIT $offset, $per_page
        ";
    }
    $stmt = query($query);
    $rows = fetch($stmt);
    $stmt->close();
    return $rows;
}

function findPostTags($params) {
    $query = "
        SELECT
            *
        FROM
            posts
        WHERE
            post_tags LIKE ?
            AND post_status = 'published'
    ";
    $stmt = query($query, $params);
    $rows = fetch($stmt);
    $stmt->close();
    return $rows;
}


function createPost($params, $files = []) {

    // アップデートする項目のみ変数に格納する
    $fields = '';
    $values = '';
    foreach ($params as $key => $val) {
        if (isset($val) && $val !== '') {
            $args[$key] = $val;
            $fields .= $key . ",";
            $values .= "?,";
        }
    }
    $fields = trim($fields, ',');
    $values = trim($values, ',');

    fileUpload($files);

    $query = "
        INSERT INTO
            posts
        (
            $fields
        )
        VALUES
        (
            $values
        )   
    ";

    $stmt = query($query, $args);
    $insert_id = $stmt->insert_id;
    $stmt->close();
    return $insert_id;
}

function updatePost($params, $files = []) {
    // アップデートする項目のみ変数に格納する
    $fields = '';
    $where = '';

    foreach ($params as $key => $val) {
        if ($key === 'post_id') {
            $where .= $key . " = ?";
        } elseif (isset($val) && $val !== '') {
            $fields .= $key . " = ?,";
            $args[$key] = $val;
        }
    }
    $args['post_id'] = $params['post_id'];
    $fields = trim($fields, ',');

    // 添付ファイルが送信された場合はファイルアップロードを行う
    fileUpload($files);

    $query = "
        UPDATE
            posts
        SET
            $fields
        WHERE
            $where
    ";
    $stmt = query($query, $args);
    $stmt->close();
    return $args['post_id'];
}

function updatePostViewsCount($post_id) {
    // アップデートする項目のみ変数に格納する
    $query = "
        UPDATE
            posts
        SET
            post_views_count = post_views_count + 1
        WHERE
            post_id = ?
    ";
    $args = [$post_id];
    $stmt = query($query, $args);
    $stmt->close();
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
                post_status = ?
        ";
        $post_status = 'published';
        $args = [$post_status];

        return CountNumRows($query, $args);
    }
}

/********************************** posts *********************************/

/********************************** users *********************************/
function createUser($params) {

    // アップデートする項目のみ変数に格納する
    $fields = '';
    $values = '';
    foreach ($params as $key => $val) {
        if (isset($val) && $val !== '') {
            $fields .= $key . ",";
            $values .= "?,";
            if ($key === 'user_password') {
                $args[$key] = password_hash($params['user_password'], PASSWORD_BCRYPT);
            } else {
                $args[$key] = $val;
            }
        }
    }
    $fields = trim($fields, ',');
    $values = trim($values, ',');

    $query = "
        INSERT INTO
            users
        (
            $fields
        )
        VALUES
        (
            $values
        )   
    ";

    $stmt = query($query, $args);
    $insert_id = $stmt->insert_id;
    $stmt->close();
    return $insert_id;
}

function updateUser($params) {
    // アップデートする項目のみ変数に格納する
    $fields = '';
    $where = '';
    foreach ($params as $key => $val) {
        if ($key === 'user_id') {
            $where .= $key . " = ?";
        } elseif ($key === 'user_password') {
            $fields .= $key . " = ?,";
            $args[$key] = password_hash($params['user_password'], PASSWORD_BCRYPT);
        } elseif (isset($val) && $val !== '') {
            $fields .= $key . " = ?,";
            $args[$key] = $val;
        }
    }
    $args['user_id'] = $params['user_id'];
    $fields = trim($fields, ',');

    $query = "
        UPDATE
            users
        SET
            $fields
        WHERE
            $where
    ";

    $stmt = query($query, $args);
    $stmt->close();
    return $args['user_id'];
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

function validateUser($username, $email, $password) {
    $username = trim($username);
    $email = trim($email);
    $password = trim($password);
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
    $username = trim($username);
    $password = trim($password);
    $query = "
        SELECT
            *
        FROM
            users
        WHERE
            username = ?
    ";

    $args = [
        $username,
    ];
    $stmt = query($query, $args);
    $rows = fetch($stmt);
    $stmt->close();

    $db_id = $rows[0]['user_id'];
    $db_username = $rows[0]['username'];
    $db_user_first_name = $rows[0]['user_firstname'];
    $db_user_last_name = $rows[0]['user_lastname'];
    $db_password = $rows[0]['user_password'];
    $db_user_role = $rows[0]['user_role'];

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
    $username = trim($username);
    $email = trim($email);
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
            ?,
            ?,
            ?,
            ?
        )
    ";
    $args = [
        $username,
        $email,
        $password,
        $user_role,
    ];
    $stmt = query($query, $args);
    $stmt->close();
}

function logoutUser() {
    $session_id = session_id();

    deleteUsersOnline($session_id);

    // セッション変数を全て解除する
    $_SESSION = array();

    // セッションを切断するにはセッションクッキーも削除する。
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    // 最終的に、セッションを破壊する
    session_destroy();
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
          user_id = ?
    ";
    $args = [$user_id];
    $stmt = query($query, $args);
    $rows = fetch($stmt);
    $stmt->close();

    if (!$rows) return false;
    $user_role = $rows[0]['user_role'];
    if ($user_role === 'admin') {
        return true;
    }
    return false;
}


/********************************** users *********************************/

/********************************** categories *********************************/


function updateCategory($params) {
    $params = isset($params) ? (array)$params : [];
    $params = array_filter($params, 'is_string');
    // アップデートする項目のみ変数に格納する
    $fields = '';
    $where = '';

    foreach ($params as $key => $val) {
        if ($key === 'cat_id') {
            $where .= $key . " = ?";
        } elseif (isset($val) && $val !== '') {
            $fields .= $key . " = ?,";
            $args[$key] = $val;
        }
    }
    $args['cat_id'] = $params['cat_id'];
    $fields = trim($fields, ',');

    $query = "
        UPDATE
            categories
        SET
            $fields
        WHERE
            $where
    ";

    $stmt = query($query, $args);
    $stmt->close();
}


/********************************** categories *********************************/



/********************************** comments *********************************/

function findViewAllPostComments($comment_post_id) {
    $query = "
        SELECT 
            comments.comment_id,
            comments.comment_post_id,
            comments.comment_author,
            comments.comment_content,
            comments.comment_email,
            comments.comment_status,
            comments.comment_date,
            comments.comment_id,
            posts.post_id,
            posts.post_title
        FROM 
            comments
            INNER JOIN
                posts
                ON
                    comments.comment_post_id = posts.post_id
        WHERE
            comment_post_id = ?
    ";
    $args = [
        $comment_post_id
    ];
    $stmt = query($query, $args);
    $rows = fetch($stmt);
    $stmt->close();
    return $rows;
}

function findComments($params) {

}


function unapproved($params) {

        $query = "
            UPDATE 
                comments 
            SET 
                comment_status = ?
            WHERE
                comment_id = ? 
        ";

        $stmt = query($query, $params);
        $stmt->close();
        return $params['comment_id'];
}

function approved($params) {

    $query = "
        UPDATE 
            comments 
        SET 
            comment_status = ?
        WHERE
            comment_id = ?
    ";

    $stmt = query($query, $params);
    $stmt->close();
    return $params['post_id'];
}


/********************************** comments *********************************/




/********************************** online_users *********************************/

// ログインセッション数を取得
//users_online();
/**
 * ログインしているユーザー数を表示
 */
//function users_online() {
//    if (isset($_GET['online_users'])) {
//        session_start();
//        $session = session_id();
//        $now = time();
//        $time_out_in_seconds = 30;
//        $time_out = $now + $time_out_in_seconds;
//        // セッション情報があるかチェック
//        $query = "
//            SELECT
//                *
//            FROM
//                users_online
//            WHERE
//                session = '$session'
//        ";
//
//        $result = confirmQuery($query);
//        $count = mysqli_num_rows($result);
//        // セッションが登録されていなければinsert、あればupdate
//        if ($count == NULL) {
//            // タイムアウト時間を登録
//            $query = "
//                INSERT INTO
//                    users_online
//                (
//                    session,
//                    time_out
//                )
//                VALUES
//                (
//                    '$session',
//                    $time_out
//                )
//            ";
//            confirmQuery($query);
//        } else {
//            // タイムアウト時間を更新
//            $query = "
//            UPDATE
//                users_online
//            SET
//                time_out = $time_out
//            WHERE
//                session = '$session'
//        ";
//            confirmQuery($query);
//        }
//        // タイムアウト時間が現在時間より未来の場合
//        $query = "
//        SELECT
//            *
//        FROM
//            users_online
//        WHERE
//            time_out > $now
//    ";
//        $result = confirmQuery($query);
//        $count_user = mysqli_num_rows($result);
//        echo $count_user;
//    }
//}

function deleteUsersOnline($session_id) {
    $query = "
        DELETE FROM
            users_online
        WHERE
            session = ?;
    ";
    $args = [
        $session_id
    ];
    $stmt = query($query, $args);
    $stmt->close();
}

/********************************** online_users *********************************/