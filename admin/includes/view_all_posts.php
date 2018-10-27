<?php
if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $postValueId) {
        $bulk_options = $_POST['bulk_options'];
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
                    $post_author = $row['post_author'];
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_content = mysqli_real_escape_string($connection, $row['post_content']);
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
                break;
        }

    }
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
            <th><input id="selectAllBoxes" value="<?php echo $post_id; ?>" type="checkbox"></th>
            <th>ID</th>
            <th>Author</th>
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
        <tr>
            <?php
            $query = "SELECT * FROM posts ORDER BY post_id DESC";
            $select_posts = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_posts)) {
                $post_id = $row['post_id'];
                $post_author = $row['post_author'];
                $post_title = $row['post_title'];
                $post_category_id = $row['post_category_id'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_comment_count = $row['post_comment_count'];
                $post_date = $row['post_date'];
                $post_views_count = $row['post_views_count'];
                echo '<tr>';
                ?>
                <td><input class='checkboxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>
                <?php
                echo "<td>$post_id</td>";
                echo "<td>$post_author</td>";
                echo "<td>$post_title</td>";
                $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
                $select_categories = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($select_categories)) {
                    $category = $row['cat_title'];
                }
                echo "<td>$category</td>";
                echo "<td>$post_status</td>";
                echo "<td>
                    <img class='img-responsive' 
                         src='../images/$post_image'
                         width='200px'>
                 </td>";
                echo "<td>$post_tags</td>";

                $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                $result = confirmQuery($query);
                $row = mysqli_fetch_array($result);
                $comment_id = $row['comment_id'];
                $count_comments = mysqli_num_rows($result);

                echo "<td><a href='/cms/admin/post_comments.php?id=$post_id'>$count_comments</a></td>";
                echo "<td><a href='/cms/post.php?p_id={$post_id}'>View Post</a></td>";
                echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                echo "<td><a onClick=\"javascript: return confirm('削除しても良いですか？')\" href='posts.php?delete={$post_id}'>Delete</a></td>";
                echo "<td><a href='/cms/admin/posts.php?reset={$post_id}'>$post_views_count</a></td>";
                echo '</tr>';
            }
            ?>
            <?php
            if (isset($_GET['delete'])) {
                $delete_post_id = $_GET['delete'];
                $query = "DELETE FROM posts WHERE post_id = $delete_post_id";
                confirmQuery($query);
                header("Location: /cms/admin/posts.php");
                exit;
            }
            if (isset($_GET['reset'])) {
                $the_post_id = mysqli_real_escape_string($connection, $_GET['reset']);
                $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = $the_post_id";
                confirmQuery($query);
                header("Location: /cms/admin/posts.php");
                exit;
            }
            ?>
        </tr>
        </tbody>
    </table>
</form>