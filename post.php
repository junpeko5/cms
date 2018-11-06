<?php
include(dirname(__FILE__) . "/includes/header.php");
include(dirname(__FILE__) . "/includes/navigation.php");
if (isset($_POST['create_comment'])) {
    $args = [
        'comment_post_id' => $_POST['p_id'],
        'comment_author' => $_POST['comment_author'],
        'comment_email' => $_POST['comment_email'],
        'comment_content' => $_POST['comment_content'],
        'comment_status' => 'unapproved',
        'comment_date' => date('Y-m-d'),
    ];
    $args = force_1_dimension_array($args);

    if (!empty($_POST['comment_author']) && !empty($_POST['comment_email']) && $_POST['comment_content']) {
        create('comments', $args);
        $post_id = $args['comment_post_id'];
        redirect("/cms/post.php?p_id=$post_id");
    }
}
?>
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <h1 class="page-header">
                Posts
                <small>Secondary Text</small>
            </h1>
            <?php
            if (isset($_GET['p_id'])) {
                $post_id = forceString('p_id');
                // Viewをカウントする
                updatePostViewsCount($post_id);

                // ログイン済みかつadminユーザーの場合
                if (isAdminUser()) {
                    $args = [
                        'post_id' => $post_id,
                    ];
                    $args = force_1_dimension_array($args);
                    $rows = findByMultiple('posts', $args);
                } // ログインしていない、またはsubscriberユーザーの場合
                else {
                    $args = [
                        'post_id' => $post_id,
                        'post_status' => 'published',
                    ];
                    $args = force_1_dimension_array($args);
                    $rows = findByMultiple('posts', $args);
                }
            }
            ?>
            <?php if (empty($rows)) : ?>
                <h2>公開済みの投稿がありません。</h2>
            <?php else : ?>
                <?php foreach ($rows as $row) : ?>
                    <h2>
                        <a href="post.php?p_id=<?php echo h($row['post_id']); ?>"><?php echo h($row['post_title']); ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo h($row['post_user']); ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo h($row['post_date']); ?></p>
                    <hr>
                    <img class="img-responsive" src="images/<?php echo h($row['post_image']); ?>" alt="">
                    <hr>
                    <p><?php echo $row['post_content']; ?></p>
                    <hr>
                    <div class="well">
                        <h4>Leave a Comment:</h4>
                        <form role="form" action="/cms/post.php?p_id=<?php echo h($row['post_id']); ?>" method="post">
                            <input type="hidden" name="p_id" value="<?php echo h($row['post_id']); ?>">
                            <label for="author">Author</label>
                            <div class="form-group">
                                <input id="author" type="text" class="form-control" name="comment_author">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control" name="comment_email">
                            </div>
                            <div class="form-group">
                                <label for="comment">Comment</label>
                                <textarea id="comment" name="comment_content" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" name="create_comment" value="create" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                    <hr>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php
            $args = [
                'comment_post_id' => $post_id,
                'comment_status' => 'approved',
            ];
            $args = force_1_dimension_array($args);
            $comments = findByMultiple('comments', $args, 'comment_id');
            ?>
            <?php foreach ($comments as $comment) : ?>
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo h($comment['comment_author']); ?>
                        <small><?php echo h($comment['comment_date']); ?></small>
                    </h4>
                    <?php echo h($comment['comment_content']); ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php include(dirname(__FILE__) . "/includes/sidebar.php"); ?>
    </div>
    <hr>
    <?php include(dirname(__FILE__) . "/includes/footer.php"); ?>