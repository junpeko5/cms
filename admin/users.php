<?php
include(dirname(__FILE__) . "/includes/admin_header.php");
if (!isAdminUser()) {
    header("Location: /cms/admin/index.php");
    exit;
}
?>
<div id="wrapper">
    <?php include(dirname(__FILE__) . "/includes/navigation.php"); ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Users
                        <small></small>
                    </h1>
                    <?php
                    if (isset($_GET['source'])) {
                        $source = escape($_GET['source']);
                    } else {
                        $source = '';
                    }
                    switch ($source) {
                        case 'add_user':
                            include("includes/add_user.php");
                            break;
                        case 'edit_user':
                            include("includes/edit_user.php");
                            break;
                        default:
                            include("includes/view_all_users.php");
                            break;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include(dirname(__FILE__) . "/includes/admin_footer.php"); ?>