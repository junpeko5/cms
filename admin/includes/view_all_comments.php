<?php
if (isset($_GET['approved'])) {
    $approve_comment_id = escape($_GET['approved']);
    $query = "
                UPDATE 
                    comments 
                SET 
                    comment_status = 'approved'
                WHERE
                    comment_id = $approve_comment_id 
                ";
    confirmQuery($query);
    header("Location: /cms/admin/comments.php");
    exit;
}

if (isset($_GET['unapproved'])) {
    $unapproved_comment_id = escape($_GET['unapproved']);
    $query = "
                UPDATE 
                    comments 
                SET 
                    comment_status = 'unapproved'
                WHERE
                    comment_id = $unapproved_comment_id 
                ";
    confirmQuery($query);
    header("Location: /cms/admin/comments.php");
}

if (isset($_GET['delete'])) {
    $delete_comment_id = escape($_GET['delete']);
    $query = "DELETE FROM comments WHERE comment_id = $delete_comment_id";
    confirmQuery($query);
    header("Location: /cms/admin/comments.php");
}
?>
<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>ID</th>
        <th>Author</th>
        <th>Comment</th>
        <th>Email</th>
        <th>Status</th>
        <th>In Response to</th>
        <th>Date</th>
        <th>Approved</th>
        <th>Unapproved</th>
        <th>Delete</th>
    </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM comments";
        $select_comments = confirmQuery($query);

        while ($row = mysqli_fetch_assoc($select_comments)) {
            $comment_id = $row['comment_id'];
            $comment_post_id = $row['comment_post_id'];
            $comment_author = $row['comment_author'];
            $comment_content = $row['comment_content'];
            $comment_email = $row['comment_email'];
            $comment_status = $row['comment_status'];
            $comment_date = $row['comment_date'];
        ?>
            <tr>
                <td><?php echo h($comment_id); ?></td>
                <td><?php echo h($comment_author); ?></td>
                <td><?php echo h($comment_content); ?></td>
                <td><?php echo h($comment_email); ?></td>
                <td><?php echo h($comment_status); ?></td>
        <?php
            $query = "
                SELECT
                    *
                FROM
                  posts
                WHERE
                    post_id = $comment_post_id
            ";
            $select_post_id_query = confirmQuery($query);
            while($row = mysqli_fetch_assoc($select_post_id_query)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                ?>
                <td><a href='/cms/post.php?p_id=<?php echo h($post_id); ?>'>$post_title</a></td>
                <?php
            }
            ?>
            <td><?php echo h($comment_date); ?></td>
            <td><a href='/cms/admin/comments.php?approved=<?php echo h($comment_id); ?>'>Approved</a></td>
            <td><a href='/cms/admin/comments.php?unapproved=<?php echo h($comment_id); ?>'>Unapproved</a></td>
            <td><a href='/cms/admin/comments.php?delete=<?php echo h($comment_id); ?>'>Delete</a></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>