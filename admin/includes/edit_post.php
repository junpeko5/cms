<?php

if (isset($_POST['update_post'])) {
    $edit_id = $_POST['p_id'];
    $post_author = $_POST['post_author'];
    $post_title = $_POST['post_title'];
    $post_category_id = (int)$_POST['post_category_id'];
    $post_status = $_POST['post_status'];
    $post_image = $_FILES['post_image']['name'];
    $post_image_tmp = $_FILES['post_image']['tmp_name'];
    $post_content = mysqli_real_escape_string($connection, $_POST['post_content']);
    $post_tags = $_POST['post_tags'];

    move_uploaded_file($post_image_tmp, "../images/$post_image");
    $image_sql = '';
    if (!empty($post_image)) {
        $image_sql = "post_image = '$post_image',";
    }
    $query = "
        UPDATE
            posts
        SET
            post_author = '$post_author',
            post_title = '$post_title',
            post_category_id = $post_category_id,
            post_date = now(),
            $image_sql
            post_content = '$post_content',
            post_tags = '$post_tags',
            post_status = '$post_status'
        WHERE
            post_id = $edit_id
    ";
    confirmQuery($query);
    header("Location: /cms/admin/posts.php?source=edit_post&p_id={$edit_id}");
    exit;
}

if (isset($_GET['p_id'])) {
    $edit_id = $_GET['p_id'];
    $query = "SELECT * FROM posts WHERE post_id = {$edit_id}";
    $select_post_query = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_post_query)) {
        $post_title = $row['post_title'];
        $cat_id = $row['post_category_id'];
        $post_author = $row['post_author'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_content = $row['post_content'];
    }
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="p_id" value="<?php echo $_GET['p_id']; ?>">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input id="post_title"
               type="text"
               name="post_title"
               class="form-control"
               value="<?php echo $post_title; ?>">
    </div>
    <label for="post_category_id">post_category_id</label>
    <select name="post_category_id" id="post_category_id">
        <?php
        $query = "SELECT * FROM categories";
        $result = confirmQuery($query);

        while ($row = mysqli_fetch_assoc($result)) {
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];

            echo "<option value='{$cat_id}'>{$cat_title}</option>";
        }
        ?>

    </select>
    <div class="form-group">
        <label for="post_author">Post Author</label>
        <input id="post_author"
               type="text"
               name="post_author"
               class="form-control"
               value="<?php echo $post_author; ?>">
    </div>
    <div class="form-group">
        <label for="title">Post Status</label>
        <input id="title"
               type="text"
               name="post_status"
               class="form-control"
               value="<?php echo $post_status; ?>">
    </div>
    <div class="form-group">
        <img width="200px" src="../images/<?php echo $post_image; ?>" alt="" class="src">
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input id="post_image" type="file" name="post_image" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input id="post_tags"
               type="text"
               name="post_tags"
               class="form-control"
               value="<?php echo $post_tags; ?>">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea id="post_content"
                  name="post_content"
                  class="form-control"
                  rows="5"><?php echo $post_content; ?></textarea>
    </div>
    <div class="form-group">
        <input type="submit"
               name="update_post"
               value="Create Posts"
               class="btn btn-primary">
    </div>
</form>