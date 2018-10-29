<?php
include(dirname(__FILE__) . "/delete_modal.php");
if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $postValueId) {
        $bulk_options = escape($_POST['bulk_options']);
        switch ($bulk_options) {
            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
                $update_to_published_status = confirmQuery($query);
                break;
            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
                $update_to_draft_status = confirmQuery($query);
                break;
            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = {$postValueId}";
                $update_to_delete_status = confirmQuery($query);
                break;
            case 'clone':
                $query = "SELECT * FROM posts WHERE post_id = {$postValueId}";
                $select_post_query = confirmQuery($query);
                while ($row = mysqli_fetch_array($select_post_query)) {
                    $post_id = $row['post_id'];
                    $post_user = $row['post_user'];
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_content = escape($row['post_content']);
                    $post_tags = $row['post_tags'];
                    $post_comment_count = $row['post_comment_count'];
                    $post_date = $row['post_date'];
                }
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
                break;
        }

    }
}
if (isset($_GET['delete'])) {
    $delete_post_id = escape($_GET['delete']);
    $query = "DELETE FROM posts WHERE post_id = $delete_post_id";
    confirmQuery($query);
    header("Location: /cms/admin/posts.php");
    exit;
}
if (isset($_GET['reset'])) {
    $the_post_id = escape($_GET['reset']);
    $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = $the_post_id";
    confirmQuery($query);
    header("Location: /cms/admin/posts.php");
    exit;
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
            <th><input id="selectAllBoxes" value="<?php echo h($post_id) ?>" type="checkbox"></th>
            <th>ID</th>
            <th>Users</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>View Post</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>View Count</th>
        </tr>
        </thead>
        <tbody>
            <?php
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
            $select_posts = confirmQuery($query);

            while ($row = mysqli_fetch_assoc($select_posts)) {
                $post_id = $row['post_id'];
                $post_user = $row['post_user'];
                $post_user = $row['post_user'];
                $post_title = $row['post_title'];
                $post_category_id = $row['post_category_id'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_comment_count = $row['post_comment_count'];
                $post_date = $row['post_date'];
                $post_views_count = $row['post_views_count'];
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                if (empty($post_tags)) {
                    $post_tags = "未分類";
                }
            ?>
            <tr>
                <td><input class='checkboxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>
                <td><?php echo h($post_id); ?></td>
                <td><?php echo h($post_user); ?></td>
                <td><?php echo h($post_title); ?></td>
                <td><?php echo h($cat_title); ?></td>
                <td><?php echo h($post_status); ?></td>
                <td>
                    <img class='img-responsive'
                     src='../images/<?php echo h($post_image); ?>'
                     width='200px'>
                </td>
                <td><?php echo h($post_tags); ?></td>
                <?php
                $count_comments = countById('comments', 'comment_post_id', $post_id)
                ?>
                <td><a href='/cms/admin/post_comments.php?id=<?php echo h($post_id); ?>'><?php echo h($count_comments); ?></a></td>
                <td><a href='/cms/post.php?p_id=<?php echo h($post_id); ?>'>View Post</a></td>
                <td><a href='/cms/admin/posts.php?source=edit_post&p_id=<?php echo h($post_id); ?>'>Edit</a></td>
                <td>
                    <a href='javascript:void(0)'
                       rel = "<?php echo h($post_id); ?>"
                       class="delete-link"
                       data-toggle="modal"
                       data-target="#deleteModal">
                        Delete
                    </a>
                </td>
                <td><a href='/cms/admin/posts.php?reset=<?php echo h($post_id); ?>'><?php echo h($post_views_count); ?></a></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</form>
<script>
    $(function() {
        $(".delete-link").on('click' , function() {
            var id = $(this).attr("rel"),
                delete_url = "/cms/admin/posts.php?delete=" + id,
                $delete_btn = $("#delete_btn");
            $delete_btn.attr("href", delete_url);
        });
    });
</script>