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
                $post_category_id = (int)$_GET['category'];

                // ログイン済みかつadminユーザーの場合
                if (isAdminUser()) {
                    $query = "
                        SELECT 
                            post_id,
                            post_title,
                            post_user,
                            post_date,
                            post_image,
                            post_content 
                        FROM 
                            posts 
                        WHERE 
                            post_category_id = ?
                    ";
                    $stmt = mysqli_prepare($connection, $query);
                    $args = [
                        $post_category_id
                    ];
                    mysqli_stmt_bind_param($stmt, "i", $args);
               }
                // ログインしていない、またはsubscriberユーザーの場合
                else {
                    $query = "
                        SELECT 
                            post_id,
                            post_title,
                            post_user,
                            post_date,
                            post_image,
                            post_content 
                        FROM 
                            posts 
                        WHERE 
                            post_category_id = ?
                            AND post_status = ?
                    ";
                    $post_status = 'published';
                    // 実行するための SQL ステートメントを準備する
                    $args = [
                        $post_category_id,
                        $post_status
                    ];
                    $stmt = mysqli_prepare($connection, $query);
                    execute($stmt, $args);
                }
                $rows = fetch($stmt);

                ?>
                <?php if (empty($rows)) : ?>
                <h2>公開済みの投稿がありません。</h2>
                <?php else: ?>
                    <?php foreach ($rows as $row) : ?>
                        <h2>
                            <a href="#"><?php echo h($row['post_title']); ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="index.php"><?php echo h($row['post_user']); ?></a>
                        </p>
                        <p>
                            <span class="glyphicon glyphicon-time"></span> <?php echo h($row['post_date']); ?>
                        </p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo h($row['post_image']); ?>" alt="">
                        <hr>
                        <p><?php echo h($row['post_content']); ?></p>
                        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                        <hr>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php
            } else {
                redirect("/cms/index.php");
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

