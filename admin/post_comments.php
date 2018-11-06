<?php include(dirname(__FILE__) . "/includes/admin_header.php"); ?>
<div id="wrapper">
    <?php include(dirname(__FILE__) . "/includes/navigation.php"); ?>
    <?php
    if (isset($_GET['approved'])) {
        $args = [
            'comment_status' => 'approved',
            'comment_id' => forceString('approved'),
        ];
        $comment_id = approved($args);
        $post_id = forceString('id');
        redirect("/cms/admin/post_comments.php?id=$post_id");
    }

    if (isset($_GET['unapproved'])) {
        $args = [
            'comment_status' => 'unapproved',
            'comment_id' => forceString('unapproved'),
        ];
        $comment_id = unapproved($args);
        $post_id = forceString('id');
        redirect("/cms/admin/post_comments.php?id=$post_id");
    }

    if (isset($_GET['delete'])) {
        $delete_comment_id = forceString('delete');
        $post_id = forceString('id');
        deleteById('comments', 'comment_id', $delete_comment_id);
        redirect("/cms/admin/post_comments.php?id=$post_id");
    }
    ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Comments
                        <small></small>
                    </h1>
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
                            $comment_post_id = forceString('id');
                            $comments = findViewAllPostComments($comment_post_id);
                            ?>
                            <?php foreach ($comments as $comment) : ?>
                                <tr>
                                    <td><?php echo h($comment['comment_id']); ?></td>
                                    <td><?php echo h($comment['comment_author']); ?></td>
                                    <td><?php echo h($comment['comment_content']); ?></td>
                                    <td><?php echo h($comment['comment_email']); ?></td>
                                    <td><?php echo h($comment['comment_status']); ?></td>
                                    <td>
                                        <a href="/cms/post.php?p_id=<?php echo h($comment['post_id']); ?>"><?php echo h($comment['post_title']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo h($comment['comment_date']); ?></td>
                                    <td>
                                        <a href="/cms/admin/post_comments.php?approved=<?php echo h($comment['comment_id']); ?>&id=<?php echo h($comment['post_id']); ?>">
                                            Approved
                                        </a>
                                    </td>
                                    <td>
                                        <a href='/cms/admin/post_comments.php?unapproved=<?php echo h($comment['comment_id']); ?>&id=<?php echo h($comment['post_id']); ?>'>
                                            Unapproved
                                        </a>
                                    </td>
                                    <td>
                                        <a href='/cms/admin/post_comments.php?delete=<?php echo h($comment['comment_id']); ?>&id=<?php echo h($comment['post_id']); ?>'>
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include(dirname(__FILE__) . "/includes/admin_footer.php"); ?>