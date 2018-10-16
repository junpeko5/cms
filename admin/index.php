<?php include("includes/admin_header.php"); ?>
    <div id="wrapper">
        <?php include("includes/navigation.php"); ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small><?php echo $_SESSION['username']; ?></small>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include("includes/admin_footer.php"); ?>

