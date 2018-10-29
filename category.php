<?php
include(dirname(__FILE__) . "/includes/header.php");
include(dirname(__FILE__) . "/includes/navigation.php");
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>
            <?php
            if (!empty($_GET['category'])) {
                $post_category = escape($_GET['category']);

                // ログイン済みかつadminユーザーの場合
                if (isAdminUser()) {
                    $query = "
                        SELECT 
                            * 
                        FROM 
                            posts 
                        WHERE 
                            post_category_id = $post_category
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
                            post_category_id = $post_category
                            AND post_status = 'published'
                    ";
                }
                $select_all_posts_query = confirmQuery($query);
                $count_published = mysqli_num_rows($select_all_posts_query);

                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_title = $row['post_title'];
                    $post_user = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];
            ?>
                <h2>
                    <a href="#"><?php echo h($post_title); ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo h($post_user); ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo h($post_date); ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo h($post_image); ?>" alt="">
                <hr>
                <p><?php echo h($post_content); ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
            <?php
                }
            ?>
                <?php if ($count_published === 0) : ?>
                    <h2>公開済みの投稿がありません。</h2>
                <?php endif; ?>
            <?php
            } else {
                header("Location: /cms/index.php");
                exit;
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

