<?php include(dirname(__FILE__) . "/includes/admin_header.php"); ?>
<div id="wrapper">
    <?php include(dirname(__FILE__) . "/includes/navigation.php"); ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Category
                        <small>Author</small>
                    </h1>
                    <div class="col-xs-6">
                        <?php
                        insert_categories();
                        ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="cat-title">Add Category</label>
                                <input id="cat-title" type="text" name="cat_title" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" value="Add Category" class="btn btn-primary">
                            </div>
                        </form>
                        <?php
                        $cat_title = getCategoryTitle();
                        ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="cat-title">Edit Category</label>
                                <?php
                                if (isset($_GET['edit'])) {
                                    $cat_id = escape($_GET['edit']);
                                    updateCategories($cat_id);
                                }
                                ?>
                                    <input type="text"
                                           name="update_category"
                                           class="form-control"
                                            value="<?php
                                            if (isset($cat_title)) {
                                                echo h($cat_title);
                                            }
                                            ?>">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="update" value="Update Category" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Title</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Find All categories query
                                findAllCategories();
                                ?>
                                <?php
                                // カテゴリー削除処理
                                delete_categories();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include(dirname(__FILE__) . "/includes/admin_footer.php"); ?>
