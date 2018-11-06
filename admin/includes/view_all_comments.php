<?php
if (isset($_GET['approved'])) {
    $args = [
        'comment_status' => 'approved',
        'comment_id' => forceString('approved'),
    ];
    $comment_id = approved($args);
    redirect("/cms/admin/comments.php?id=$comment_id");
}

if (isset($_GET['unapproved'])) {
    $args = [
        'comment_status' => 'unapproved',
        'comment_id' => forceString('unapproved'),
    ];
    $comment_id = unapproved($args);
    redirect("/cms/admin/comments.php?id=$comment_id");
}
if (isset($_GET['delete'])) {
    $delete_comment_id = $_GET['delete'];
    deleteById('comments', 'comment_id', $delete_comment_id);
    redirect("/cms/admin/comments.php");
}
$rows = findAll('comments');
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
    <?php foreach ($rows as $row) : ?>
        <tr>
            <td><?php echo h($row['comment_id']); ?></td>
            <td><?php echo h($row['comment_author']); ?></td>
            <td><?php echo h($row['comment_content']); ?></td>
            <td><?php echo h($row['comment_email']); ?></td>
            <td><?php echo h($row['comment_status']); ?></td>
            <?php
            $post = findAllById('posts', 'post_id', $row['comment_id']);
            ?>
            <td>
                <a href='/cms/post.php?p_id=<?php echo isset($post['post_id']) ? h($post['post_id']) : ''; ?>'>
                    <?php echo isset($post['post_title']) ? h($post['post_title']) : ''; ?>
                </a>
            </td>
            <td><?php echo h($row['comment_date']); ?></td>
            <td>
                <a href='/cms/admin/comments.php?approved=<?php echo h($row['comment_id']); ?>'>
                    Approved
                </a>
            </td>
            <td>
                <a href='/cms/admin/comments.php?unapproved=<?php echo h($row['comment_id']); ?>'>
                    Unapproved
                </a>
            </td>
            <td>
                <a href='/cms/admin/comments.php?delete=<?php echo h($row['comment_id']); ?>'>
                    Delete
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>