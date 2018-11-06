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
            $per_page = 2;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = "";
            }
            if ($page === "" || $page == 1) {
                $offset = 0;
            } else {
                $offset = ($page - 1) * $per_page;
            }
            $posts = findTopPagePosts($offset, $per_page);
            $count = ceil(getAllPostCount() / $per_page);
            ?>
            <?php if (empty($posts)) : ?>
                <h2>公開済みの投稿がありません。</h2>
            <?php else : ?>
                <?php foreach ($posts as $post) : ?>
                    <h2>
                        <a href="/cms/post.php?p_id=<?php echo h($post['post_id']); ?>"><?php echo h($post['post_title']); ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="/cms/author_posts.php?author=<?php echo h($post['post_user']); ?>"><?php echo h($post['post_user']); ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo h($post['post_date']); ?></p>
                    <hr>
                    <a href="/cms/post.php?p_id=<?php echo h($post['post_id']); ?>">
                        <img class="img-responsive" src="/cms/images/<?php echo h($post['post_image']); ?>" alt="">
                    </a>
                    <hr>
                    <p><?php echo mb_substr($post['post_content'], 0, 100); ?></p>
                    <a class="btn btn-primary"
                       href="/cms/post.php?p_id=<?php echo h($post['post_id']); ?>">
                        Read More
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                    <hr>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php include(dirname(__FILE__) . "/includes/sidebar.php"); ?>
    </div>
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $count; $i++) : ?>
            <?php if ($i == $page) : ?>
                <li class="page-item active">
                    <a class="page-link" href="">
                        <?php echo h($i); ?><span class="sr-only">(current)</span>
                    </a>
                </li>
            <?php else: ?>
                <li class="page-item">
                    <a class="page-link" href="/cms/index.php?page=<?php echo h($i); ?>">
                        <?php echo h($i); ?>
                    </a>
                </li>
            <?php endif; ?>
        <?php endfor; ?>
    </ul>
    <hr>
    <?php include(dirname(__FILE__) . "/includes/footer.php"); ?>

