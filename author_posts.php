<?php
include(dirname(__FILE__) . "/includes/header.php");
include(dirname(__FILE__) . "/includes/navigation.php");
?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>
            <?php
            if (isset($_GET['author'])) {
                $the_post_user = escape($_GET['author']);
                $query = "SELECT * FROM posts WHERE post_user = '{$the_post_user}'";
                $select_all_posts_query = confirmQuery($query);
                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_user = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];
                    ?>
                    <h2>
                        <a href="post.php?p_id=<?php echo h($post_id); ?>">
                            <?php echo h($post_title); ?>
                        </a>
                    </h2>
                    <p class="lead">
                        All Posts by <?php echo h($post_user); ?>
                    </p>
                    <p>
                        <span class="glyphicon glyphicon-time"></span>
                        <?php echo h($post_date); ?>
                    </p>
                    <hr>
                    <img class="img-responsive"
                         src="images/<?php echo h($post_image); ?>"
                         alt="">
                    <hr>
                    <p><?php echo h($post_content); ?></p>

                    <hr>
                    <?php
                }
            }
            ?>
            <?php
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
                    $create_comment_query = confirmQuery($query);
                    $query = "
                        UPDATE 
                            posts 
                        SET 
                            post_comment_count = post_comment_count + 1
                        WHERE 
                            post_id = $the_post_id
                    ";
                    confirmQuery($query);
                } else {
                    echo "<script>alert('Fields cannot be empty');</script>";
                }
            }
            ?>
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <li class="next">
                    <a href="#">Newer &rarr;</a>
                </li>
            </ul>

        </div>

        <?php include(dirname(__FILE__) . "/includes/sidebar.php"); ?>
    </div>
    <hr>
    <?php include(dirname(__FILE__) . "/includes/footer.php"); ?>


