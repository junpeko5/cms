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
    <tr>
        <?php
        $query = "SELECT * FROM comments";
        $select_comments = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_comments)) {
            $comment_id = $row['comment_id'];
            $comment_post_id = $row['comment_post_id'];
            $comment_author = $row['comment_author'];
            $comment_content = $row['comment_content'];
            $comment_email = $row['comment_email'];
            $comment_status = $row['comment_status'];
            $comment_date = $row['comment_date'];
            echo '<tr>';
            echo "<td>$comment_id</td>";
            echo "<td>$comment_author</td>";
            echo "<td>$comment_content</td>";
            echo "<td>$comment_email</td>";
            echo "<td>$comment_status</td>";
            $query = "
                SELECT
                    *
                FROM
                  posts
                WHERE
                    post_id = $comment_post_id
            ";
            $select_post_id_query = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($select_post_id_query)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                echo "<td><a href='/cms/post.php?p_id=$post_id'>$post_title</a></td>";

            }
            echo "<td>$comment_date</td>";
            echo "<td><a href='/cms/admin/comments.php?approved={$comment_id}'>Approved</a></td>";
            echo "<td><a href='/cms/admin/comments.php?unapproved={$comment_id}'>Unapproved</a></td>";
            echo "<td><a href='/cms/admin/comments.php?delete={$comment_id}'>Delete</a></td>";
            echo '</tr>';
        }
        ?>

        <?php
        if (isset($_GET['approved'])) {
            $approve_comment_id = $_GET['approved'];
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
        }
        ?>

        <?php
        if (isset($_GET['unapproved'])) {
            $unapproved_comment_id = $_GET['unapproved'];
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
        ?>

        <?php
        if (isset($_GET['delete'])) {
            $delete_comment_id = $_GET['delete'];
            $query = "DELETE FROM comments WHERE comment_id = $delete_comment_id";
            confirmQuery($query);
            header("Location: /cms/admin/comments.php");
        }
        ?>
    </tr>
    </tbody>
</table>