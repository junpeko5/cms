<?php

if (isset($_POST['update_post'])) {
    $args = [
        'post_user' => $_POST['post_user'],
        'post_title' => $_POST['post_title'],
        'post_category_id' => $_POST['post_category_id'],
        'post_status' => $_POST['post_status'],
        'post_image' => $_FILES['post_image']['name'],
        'post_content' => $_POST['post_content'],
        'post_tags' => $_POST['post_tags'],
        'post_id' => $_POST['p_id'],
    ];
    $args = force_1_dimension_array($args);
    $edit_id = updatePost($args, $_FILES['post_image']);

    echo "<p class='bg-success'>投稿が更新されました<a href='/cms/post.php?p_id={$edit_id}'>View post</a> or <a href='/cms/admin/posts.php'>Edit More Posts</a></p>";
}

if (isset($_GET['p_id'])) {
    $post = findAllById('posts', 'post_id', $_GET['p_id']);
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="p_id" value="<?php echo h($post['post_id']); ?>">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input id="post_title"
               type="text"
               name="post_title"
               class="form-control"
               value="<?php echo h($post['post_title']); ?>">
    </div>
    <label for="post_category_id">Category</label>
    <select name="post_category_id" id="post_category_id" class="form-control">
        <?php
        $categories = findAll('categories');
        ?>
        <?php foreach ($categories as $category) : ?>
            <?php if ($post['post_category_id'] === $category['cat_id']) : ?>
                <option value='<?php echo h($category['cat_id']); ?>' selected>
                    <?php echo h($category['cat_title']); ?>
                </option>
            <?php else : ?>
                <option value='<?php echo h($category['cat_id']); ?>'>
                    <?php echo h($category['cat_title']); ?>
                </option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
    <div class="form-group">
        <label for="post_user">Users</label>
        <select name="post_user"
                id="post_user"
                class="form-control">
            <?php
            $rows = findAll('users');
            ?>
            <?php foreach ($rows as $row) : ?>
                <?php if ($row['username'] === $post['post_user']) : ?>
                    <option selected value='<?php echo h($row['username']); ?>'>
                        <?php echo h($row['username']); ?>
                    </option>
                <?php else: ?>
                    <option value='<?php echo h($row['username']); ?>'>
                        <?php echo h($row['username']); ?>
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select id="post_status"
                name="post_status"
                class="form-control">
            <option value="<?php echo h($post['post_status']); ?>">
                <?php echo h($post['post_status']); ?>
            </option>
            <?php if ($post['post_status'] === 'published') : ?>
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
        <label for="post_image">Post Image</label>
        <input id="post_image"
               type="file"
               name="post_image">
        <img width="200px"
             src="../images/<?php echo h($post['post_image']); ?>"
             alt=""
             class="src">

    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input id="post_tags"
               type="text"
               name="post_tags"
               class="form-control"
               value="<?php echo h($post['post_tags']); ?>">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea id="post_content"
                  name="post_content"
                  class="form-control"
                  rows="5"><?php echo $post['post_content']; ?></textarea>
    </div>
    <div class="form-group">
        <input type="submit"
               name="update_post"
               value="更新する"
               class="btn btn-primary">
    </div>
</form>