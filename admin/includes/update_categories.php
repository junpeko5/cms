<?php
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
?>