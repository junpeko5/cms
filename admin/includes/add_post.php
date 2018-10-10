<?php
if (isset($_POST['create_post'])) {

    $post_author = $_POST['post_author'];
    $post_title = $_POST['post_title'];
    $post_category_id = $_POST['post_category_id'];
    $post_status = $_POST['status'];
    $post_image = $_FILES['image']['name'];
    $post_image_tmp = $_FILES['image']['tmp_name'];
    $post_content = $_POST['post_content'];
    $post_tags = $_POST['post_tags'];
    $post_comment_count = 4;
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
            '$post_category_id',
            '$post_title',
            '$post_author',
            now(),
            '$post_image',
            '$post_content',
            '$post_tags',
            '$post_comment_count',
            '$post_status'
        )   
    ";
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
    <div class="form-group">
        <label for="post_category_id">Post Category</label>
        <input id="post_category_id" type="text" name="post_category_id" class="form-control">
    </div>
    <div class="form-group">
        <label for="title">Post Status</label>
        <input id="title" type="text" name="post_status" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input id="post_image" type="file" name="post_image" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <input id="post_content" type="text" name="post_content" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input id="post_tags" type="text" name="post_tags" class="form-control">
    </div>
    <div class="form-group">
        <input type="submit" name="create_post" value="Create Posts" class="btn btn-primary">
    </div>
</form>