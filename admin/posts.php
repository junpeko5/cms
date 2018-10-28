<?php include(dirname(__FILE__) . "/includes/admin_header.php"); ?>
<div id="wrapper">
        <?php include(dirname(__FILE__) . "/includes/navigation.php"); ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Posts
                        <small>Author</small>
                    </h1>
                    <?php
                    if (isset($_GET['source'])) {
                        $source = escape($_GET['source']);
                    } else {
                        $source = '';
                    }
                    switch ($source) {
                        case 'add_post':
                            include("includes/add_post.php");
                            break;
                        case 'edit_post':
                            include("includes/edit_post.php");
                            break;
                        default:
                            include("includes/view_all_posts.php");
                            break;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include(dirname(__FILE__) . "/includes/admin_footer.php"); ?>