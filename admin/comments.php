<?php include(dirname(__FILE__) . "/includes/admin_header.php"); ?>
    <div id="wrapper">
        <?php include(dirname(__FILE__) . "/includes/navigation.php"); ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Comments
                            <small></small>
                        </h1>
                        <?php include(dirname(__FILE__) . "/includes/view_all_comments.php"); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include(dirname(__FILE__) . "/includes/admin_footer.php"); ?>