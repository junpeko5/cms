<?php include('includes/db.php'); ?>
<?php include(dirname(__FILE__) . '/admin/functions.php'); ?>
<?php include('includes/header.php'); ?>
<?php include('includes/navigation.php'); ?>
<?php
if (isset($_POST['create_comment'])) {
    $the_post_id = $_POST['p_id'];
    $comment_author = $_POST['comment_author'];
    $comment_email = $_POST['comment_email'];
    $comment_content = $_POST['comment_content'];
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
        header("location /cms/post.php?p_id=$the_post_id");
    }
}
?>
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>
            <?php
            if (isset($_GET['p_id'])) {
                $the_post_id = $_GET['p_id'];

                $query = "
                    UPDATE
                        posts
                    SET
                        post_views_count = post_views_count + 1
                    WHERE
                        post_id = $the_post_id
                ";
                confirmQuery($query);

                $query = "SELECT * FROM posts WHERE post_id = {$the_post_id}";
                $select_all_posts_query = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_user = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];

            ?>
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_user; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>

                <hr>
                <?php
                }
            } else {
                header("Location: /cms/index.php");
                exit;
            }
            ?>

            <div class="well">
                <h4>Leave a Comment:</h4>
                <form role="form" action="/cms/post.php?p_id=<?php echo $the_post_id; ?>" method="post">
                    <input type="hidden" name="p_id" value="<?php echo $the_post_id; ?>">
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
            $select_comments_query = mysqli_query($connection, $query);
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
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>
            <?php
            }
            ?>

        <!-- Pager -->
        <ul class="pager">
            <li class="previous">
                <a href="#">&larr; Older</a>
            </li>
            <li class="next">
                <a href="#">Newer &rarr;</a>
            </li>
        </ul>

        </div>

        <?php include('includes/sidebar.php'); ?>
    </div>

    <!-- /.row -->
    <hr>
    <?php include('includes/footer.php') ?>


