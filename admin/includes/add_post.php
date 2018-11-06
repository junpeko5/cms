<?php
if (isset($_POST['create_post'])) {
    $args = [
        'post_title' => $_POST['post_title'],
        'post_category_id' => $_POST['post_category_id'],
        'post_user' => $_POST['post_user'],
        'post_date' => date("Y-m-d"),
        'post_image' => $_FILES['post_image']['name'],
        'post_status' => $_POST['post_status'],
        'post_tags' => $_POST['post_tags'],
        'post_content' => $_POST['post_content'],
        'post_comment_count' => "0",
    ];
    $args = force_1_dimension_array($args);
    $insert_id = createPost($args, $_FILES['post_image']);
    echo "<p class='bg-success'>Post Updated <a href='/cms/post.php?p_id={$insert_id}'>Post Created</a> or <a href='/cms/admin/posts.php'>Edit More Posts</a></p>";
}
?>
<form action="/cms/admin/posts.php?source=add_post" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input id="post_title" type="text" name="post_title" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_category_id">Category</label>
        <select name="post_category_id" id="post_category_id" class="form-control">
            <?php
            $rows = findAll('categories');
            ?>
            <?php foreach ($rows as $row) : ?>
            <option value='<?php echo h($row['cat_id']); ?>'><?php echo h($row['cat_title']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_user">Users</label>
        <select name="post_user" id="post_user" class="form-control">
            <?php $rows = findAll('users'); ?>
            <?php foreach ($rows as $row) : ?>
                <option value='<?php echo h($row['username']); ?>'>
                    <?php echo h($row['username']); ?>
                </option>
            <?php endforeach; ?>
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
        <input type="submit" name="create_post" value="新規登録" class="btn btn-primary">
    </div>
</form>