<?php include('includes/db.php'); ?>
<?php include(dirname(__FILE__) . '/admin/functions.php'); ?>
<?php include('includes/header.php'); ?>
<?php include('includes/navigation.php'); ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
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
                $page_1 = 0;
            } else {
                $page_1 = ($page - 1) * $per_page;
            }
            $query = "SELECT * FROM posts WHERE post_status = 'published'";
            $result = confirmQuery($query);
            $count = mysqli_num_rows($result);
            $count = ceil($count / $per_page);

            $query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC LIMIT {$page_1}, $per_page ";
            $select_all_posts_query = mysqli_query($connection, $query);
            $count_published = 0;
            while ($row = mysqli_fetch_array($select_all_posts_query)) {
                $post_id = $row['post_id'];
                echo $post_id;
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = mb_substr($row['post_content'], 0, 100);
                $post_status = $row['post_status'];
                $count_published++;
                ?>
                <h2>
                    <a href="/cms/post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="/cms/author_posts.php?author=<?php echo $post_author; ?>"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                <hr>
                <a href="/cms/post.php?p_id=<?php echo $post_id; ?>">
                    <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                </a>
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="/cms/post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
                <?php
            }
            if ($count_published === 0) {
                echo '<h2>No post here sorry</h2>';
            }
            ?>

        </div>

        <?php include('includes/sidebar.php'); ?>
    </div>
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $count; $i++) : ?>
            <?php if ($i == $page) : ?>
                <li class="page-item active">
                    <a class="page-link" href="">
                        <?php echo $i; ?><span class="sr-only">(current)</span>
                    </a>
                </li>
            <?php else: ?>
                <li class="page-item">
                    <a class="page-link" href="/cms/index.php?page=<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endif; ?>
        <?php endfor; ?>
    </ul>
    <!-- /.row -->
    <hr>
    <?php include('includes/footer.php') ?>

