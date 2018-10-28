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
            if (isset($_POST['submit'])) {
                $search = escape($_POST['search']);
                $query = "SELECT * FROM posts WHERE post_tags LIKE '%{$search}%' ";
                $search_query = confirmQuery($query);
                $count = mysqli_num_rows($search_query);
                if ($count == 0) {
                    echo "<h1>No Result</h1>";
                } else {
                    while ($row = mysqli_fetch_assoc($search_query)) {
                        $post_title = $row['post_title'];
                        $post_user = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                    }
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
</div>
<?php include(dirname(__FILE__) . "/includes/footer.php"); ?>

