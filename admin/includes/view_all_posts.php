<?php
include(dirname(__FILE__) . "/delete_modal.php");
$posts = findViewAllPosts();

if (isset($_POST['checkBoxArray'])) {
    $checkBoxArray = force_1_dimension_array($_POST['checkBoxArray']);
    $bulk_options = forceString('bulk_options');

    foreach ($checkBoxArray as $postValueId) {
        switch ($bulk_options) {
            case 'published':
            case 'draft':
                $args = [
                    'post_status' => $bulk_options,
                    'post_id' => $postValueId,
                ];
                updatePost($args);
                break;
            case 'delete':
                deleteById('posts', 'post_id', $postValueId);
                break;
            case 'clone':
                $row = findAllById('posts', 'post_id', $postValueId);
                createPost($row);
                break;
        }
    }
    redirect("/cms/admin/posts.php");
}
if (isset($_POST['delete_post_id'])) {
    $delete_post_id = forceString('delete_post_id');
    deleteById('posts', 'post_id', $delete_post_id);
    redirect("/cms/admin/posts.php");

}
if (isset($_GET['reset'])) {
    $post_id = forceString('reset');
    $args = [
        'post_views_count' => "0",
        'post_id' => $post_id,
    ];
    updatePost($args);
    redirect("/cms/admin/posts.php");
}
?>
<form action="/cms/admin/posts.php" method="post">
    <table class="table table-bordered table-hover">
        <div id="bulkOptionsContainer" class="col-xs-4">
            <select class="form-control" name="bulk_options">
                <option value="">
                    Select Options
                </option>
                <option value="published">
                    Published
                </option>
                <option value="draft">
                    Draft
                </option>
                <option value="delete">
                    Delete
                </option>
                <option value="clone">
                    Clone
                </option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="/cms/admin/posts.php?source=add_post">Add New</a>
        </div>
        <thead>
        <tr>
            <th>
                <input id="selectAllBoxes"
                       value="1"
                       type="checkbox">
            </th>
            <th>ID</th>
            <th>Users</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Date</th>
            <th>Comments</th>
            <th>View Post</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>View Count</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post) : ?>
                <tr>
                    <td>
                        <input class='checkboxes'
                               type='checkbox'
                               name='checkBoxArray[]'
                               value='<?php echo h($post['post_id']); ?>'>
                    </td>
                    <td><?php echo h($post['post_id']); ?></td>
                    <td><?php echo h($post['post_user']); ?></td>
                    <td><?php echo h($post['post_title']); ?></td>
                    <td><?php echo h($post['cat_title']); ?></td>
                    <td><?php echo h($post['post_status']); ?></td>
                    <td>
                        <img class='img-responsive'
                         src='../images/<?php echo h($post['post_image']); ?>'
                         width='200px'>
                    </td>
                    <td><?php echo !empty($post['post_tags']) ? h($post['post_tags']) : '未分類'; ?></td>
                    <?php
                    $count_comments = countById('comments', 'comment_post_id', $post['post_id'])
                    ?>
                    <td><?php echo !empty($post['post_date']) ? h($post['post_date']) : ''; ?></td>
                    <td>
                        <a href='/cms/admin/post_comments.php?id=<?php echo h($post['post_id']); ?>'>
                            <?php echo h($count_comments); ?>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-primary" href='/cms/post.php?p_id=<?php echo h($post['post_id']); ?>'>
                            個別投稿ページへ
                        </a>
                    </td>
                    <td>
                        <a href='/cms/admin/posts.php?source=edit_post&p_id=<?php echo h($post['post_id']); ?>'
                            class="btn btn-info">
                            編集
                        </a>
                    </td>
                    <td>
                        <button type="button"
                                class="btn btn-danger btn-delete"
                                data-toggle="modal"
                                data-target="#deleteModal"
                                name="delete_post_id"
                                value="<?php echo h($post['post_id']); ?>">
                            削除
                        </button>
                    </td>
                    <td>
                        <a href='/cms/admin/posts.php?reset=<?php echo h($post['post_id']); ?>'>
                            <?php echo h($post['post_views_count']); ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</form>
<script>
    $('.btn-delete').on('click', function() {
        var id = $(this).val();
        $('#modal_delete_btn').val(id);
    });
</script>