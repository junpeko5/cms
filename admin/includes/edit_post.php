<?php

if (isset($_POST['update_post'])) {
    $edit_id = escape($_POST['p_id']);
    $post_user = escape($_POST['post_user']);
    $post_title = escape($_POST['post_title']);
    $post_category_id = escape((int)$_POST['post_category_id']);
    $post_status = escape($_POST['post_status']);
    $post_image = escape($_FILES['post_image']['name']);
    $post_image_tmp = escape($_FILES['post_image']['tmp_name']);
    $post_content = escape($_POST['post_content']);
    $post_tags = escape($_POST['post_tags']);

    move_uploaded_file($post_image_tmp, "../images/$post_image");
    $image_sql = '';
    if (!empty($post_image)) {
        $image_sql = "post_image = '$post_image',";
    }
    $query = "
        UPDATE
            posts
        SET
            post_user = '$post_user',
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
    echo "<p class='bg-success'>Post Updated <a href='/cms/post.php?p_id={$edit_id}'>View post</a> or <a href='/cms/admin/posts.php'>Edit More Posts</a></p>";
}

if (isset($_GET['p_id'])) {
    $edit_id = escape($_GET['p_id']);
    $query = "SELECT * FROM posts WHERE post_id = {$edit_id}";
    $select_post_query = confirmQuery($query);

    while ($row = mysqli_fetch_assoc($select_post_query)) {
        $post_title = $row['post_title'];
        $post_user = $row['post_user'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_content = $row['post_content'];
    }
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="p_id" value="<?php echo h($_GET['p_id']); ?>">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input id="post_title"
               type="text"
               name="post_title"
               class="form-control"
               value="<?php echo h($post_title); ?>">
    </div>
    <label for="post_category_id">Category</label>
    <select name="post_category_id" id="post_category_id" class="form-control">
        <?php
        $query = "
            SELECT 
                * 
            FROM 
                categories
        ";
        $result = confirmQuery($query);

        while ($row = mysqli_fetch_assoc($result)) {
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];
        ?>
            <?php if ($post_category_id === $cat_id) : ?>
            <option value='<?php echo h($cat_id); ?>' selected><?php echo h($cat_title); ?></option>
            <?php else : ?>
            <option value='<?php echo h($cat_id); ?>'><?php echo h($cat_title); ?></option>
        <?php endif; ?>
        <?php
        }
        ?>
    </select>
    <div class="form-group">
        <label for="post_user">Users</label>
        <select name="post_user"
                id="post_user"
                class="form-control">
            <?php
            $query = "SELECT * FROM users";
            $result = confirmQuery($query);
            while ($row = mysqli_fetch_assoc($result)) {
                $user_id = $row['user_id'];
                $username = $row['username'];
                ?>
                <?php if ($username === $post_user) : ?>
                    <option selected value='<?php echo h($username); ?>'>
                        <?php echo h($username); ?>
                    </option>
                <?php else: ?>
                    <option value='<?php echo h($username); ?>'>
                        <?php echo h($username); ?>
                    </option>
                <?php endif; ?>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select id="post_status"
                name="post_status"
                class="form-control">
            <option value="<?php echo h($post_status); ?>">
                <?php echo h($post_status); ?>
            </option>
            <?php if ($post_status === 'published') : ?>
                <option value="draft"
                        class="">
                    draft
                </option>
            <?php else : ?>
                <option value="published"
                        class="">
                    published
                </option>
            <?php endif; ?>
        </select>
    </div>
    <div class="form-group">
        <img width="200px"
             src="../images/<?php echo h($post_image); ?>"
             alt=""
             class="src">
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input id="post_image"
               type="file"
               name="post_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input id="post_tags"
               type="text"
               name="post_tags"
               class="form-control"
               value="<?php echo h($post_tags); ?>">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea id="post_content"
                  name="post_content"
                  class="form-control"
                  rows="5"><?php echo h($post_content); ?></textarea>
    </div>
    <div class="form-group">
        <input type="submit"
               name="update_post"
               value="Update Posts"
               class="btn btn-primary">
    </div>
</form>