<?php
if (isset($_POST['create_post'])) {
    $post_title = escape($_POST['post_title']);
    $post_user = escape($_POST['post_user']);
    $post_category_id = escape($_POST['post_category_id']);
    $post_status = escape($_POST['post_status']);
    $post_image = escape($_FILES['post_image']['name']);
    $post_image_tmp = escape($_FILES['post_image']['tmp_name']);
    $post_content = escape($_POST['post_content']);
    $post_tags = escape($_POST['post_tags']);
    $post_comment_count = 0;
    $post_date = date('d-m-y');
    move_uploaded_file($post_image_tmp, "../images/$post_image");

    $query = "
        INSERT INTO
            posts
        (
            post_category_id, 
            post_title, 
            post_user,
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
            '{$post_user}',
            now(),
            '{$post_image}',
            '{$post_content}',
            '{$post_tags}',
            {$post_comment_count},
            '{$post_status}'
        )   
    ";
    confirmQuery($query);
    $the_post_id = mysqli_insert_id($connection);
    echo "<p class='bg-success'>Post Updated <a href='/cms/post.php?p_id={$the_post_id}'>Post Created</a> or <a href='/cms/admin/posts.php'>Edit More Posts</a></p>";
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input id="post_title" type="text" name="post_title" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_category_id">Category</label>
        <select name="post_category_id" id="post_category_id" class="form-control">
            <?php
            $query = "SELECT * FROM categories";
            $result = confirmQuery($query);

            while ($row = mysqli_fetch_assoc($result)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                ?>
                <option value='<?php echo h($cat_id); ?>'><?php echo h($cat_title); ?></option>
            <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_user">Users</label>
        <select name="post_user" id="post_user" class="form-control">
            <?php
            $query = "SELECT * FROM users";
            $result = confirmQuery($query);
            while ($row = mysqli_fetch_assoc($result)) {
                $user_id = $row['user_id'];
                $username = $row['username'];
                ?>
                <option value='<?php echo h($username); ?>'><?php echo h($username); ?></option>
            <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="post_status" id="post_status"  class="form-control">
            <option value="draft" class="">Post Status</option>
            <option value="published" class="">published</option>
            <option value="draft" class="">draft</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input id="post_image" type="file" name="post_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input id="post_tags" type="text" name="post_tags" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content"
                  id="post_content"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" name="create_post" value="Create Posts" class="btn btn-primary">
    </div>
</form>