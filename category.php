<?php
include(dirname(__FILE__) . "/includes/header.php");
include(dirname(__FILE__) . "/includes/navigation.php");

if (isset($_GET['category'])) {

    // ログイン済みかつadminユーザーの場合
    if (isAdminUser()) {
        $args = [
            'post_category_id' => $_GET['category'],
        ];
        $args = force_1_dimension_array($args);
        $rows = findByMultiple('posts', $args);
    }
    // ログインしていない、またはsubscriberユーザーの場合
    else {
        $args = [
            'post_category_id' => $_GET['category'],
            'post_status' => 'published',
        ];
        $args = force_1_dimension_array($args);
        $rows = findByMultiple('posts', $args);
    }
?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>
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
                        <img class="img-responsive" src="/cms/images/<?php echo h($row['post_image']); ?>" alt="">
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

