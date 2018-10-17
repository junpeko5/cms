<?php
if (isset($_POST['create_post'])) {

    $post_author = $_POST['post_author'];
    $post_title = $_POST['post_title'];
    $post_category_id = $_POST['post_category_id'];
    $post_status = $_POST['post_status'];
    $post_image = $_FILES['post_image']['name'];
    $post_image_tmp = $_FILES['post_image']['tmp_name'];
    $post_content = mysqli_real_escape_string($connection, $_POST['post_content']);
    $post_tags = $_POST['post_tags'];
    $post_comment_count = 0;
    $post_date = date('d-m-y');
    move_uploaded_file($post_image_tmp, "../images/$post_image");

    $query = "
        INSERT INTO
            posts
        (
            post_category_id, 
            post_title, 
            post_author, 
            post_date, 
            post_image, 
            post_content, 
            post_tags, 
            post_comment_count,
            post_status
        )
        VALUES
        (
            {$post_category_id},
            '{$post_title}',
            '{$post_author}',
            now(),
            '{$post_image}',
            '{$post_content}',
            '{$post_tags}',
            {$post_comment_count},
            '{$post_status}'
        )   
    ";
    confirmQuery($query);
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input id="post_title" type="text" name="post_title" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_author">Post Author</label>
        <input id="post_author" type="text" name="post_author" class="form-control">
    </div>
    <label for="post_category_id">Post Category</label>
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
        <label for="post_status">Post Status</label>
        <select name="post_status" id="post_status">
            <option value="draft" class="">draft</option>
            <option value="published" class="">published</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input id="post_image" type="file" name="post_image" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input id="post_tags" type="text" name="post_tags" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea id="post_content" name="post_content" class="form-control" rows="5"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" name="create_post" value="Create Posts" class="btn btn-primary">
    </div>
</form>