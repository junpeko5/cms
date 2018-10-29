<?php
include(dirname(__FILE__) . "/includes/header.php");
include(dirname(__FILE__) . "/includes/navigation.php");
if (isset($_POST['create_comment'])) {
    $the_post_id = escape($_POST['p_id']);
    $comment_author = escape($_POST['comment_author']);
    $comment_email = escape($_POST['comment_email']);
    $comment_content = escape($_POST['comment_content']);
    if (!empty($comment_author) && !empty($comment_email) && $comment_content) {
        $query = "
            INSERT INTO
                comments
            (
                comment_post_id, 
                comment_author, 
                comment_email, 
                comment_content, 
                comment_status, 
                comment_date
            ) 
            VALUES
            (
                $the_post_id,
                '$comment_author',
                '$comment_email',
                '$comment_content',
                'unapproved',
                now()
            )
        ";
        confirmQuery($query);
        redirect("/cms/post.php?p_id=$the_post_id");
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
                $the_post_id = escape($_GET['p_id']);

                $query = "
                    UPDATE
                        posts
                    SET
                        post_views_count = post_views_count + 1
                    WHERE
                        post_id = $the_post_id
                ";
                confirmQuery($query);

                // ログイン済みかつadminユーザーの場合
                if (isAdminUser()) {
                    $query = "
                        SELECT 
                            * 
                        FROM 
                            posts 
                        WHERE 
                            post_id = $the_post_id
                    ";
                }
                // ログインしていない、またはsubscriberユーザーの場合
                else {
                    $query = "
                        SELECT 
                            * 
                        FROM 
                            posts 
                        WHERE 
                            post_id = $the_post_id
                            AND post_status = 'published'
                    ";
                }
                $select_all_posts_query = confirmQuery($query);
                $count_published = mysqli_num_rows($select_all_posts_query);


                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_user = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];

            ?>
                <h2>
                    <a href="post.php?p_id=<?php echo h($post_id); ?>"><?php echo h($post_title); ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo h($post_user); ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo h($post_date); ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo h($post_image); ?>" alt="">
                <hr>
                <p><?php echo h($post_content); ?></p>
                <hr>
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="/cms/post.php?p_id=<?php echo h($the_post_id); ?>" method="post">
                        <input type="hidden" name="p_id" value="<?php echo h($the_post_id); ?>">
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
                <?php
                }
                ?>
                <?php if ($count_published === 0) : ?>
                    <h2>公開済みの投稿がありません。</h2>
                <?php endif; ?>
            <?php
            } else {
                redirect("/cms/index.php");
            }

            $query = "
                SELECT
                    *
                FROM
                    comments
                WHERE
                    comment_post_id = $the_post_id
                    AND comment_status = 'approved'
                ORDER BY comment_id DESC
            ";
            $select_comments_query = confirmQuery($query);
            while ($row = mysqli_fetch_assoc($select_comments_query)) {
                $comment_date = $row['comment_date'];
                $comment_content = $row['comment_content'];
                $comment_author = $row['comment_author'];
            ?>
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo h($comment_author); ?>
                        <small><?php echo h($comment_date); ?></small>
                    </h4>
                    <?php echo h($comment_content); ?>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
        <?php include(dirname(__FILE__) . "/includes/sidebar.php"); ?>
    </div>
    <hr>
    <?php include(dirname(__FILE__) . "/includes/footer.php"); ?>


