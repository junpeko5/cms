<?php include('includes/db.php'); ?>
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
            $query = "SELECT * FROM posts";
            $select_all_posts_query = mysqli_query($connection, $query);
            $count_published = 0;
            while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = mb_substr($row['post_content'], 0, 100);
                $post_status = $row['post_status'];
                if ($post_status === 'published') {
                    $count_published++;
                    ?>
                    <h2>
                        <a href="#"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $post_author; ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                    <hr>
                    <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>
                    <?php
                }
            }
            if ($count_published === 0) {
                echo '<h2>No post here sorry</h2>';
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

