<?php include("includes/admin_header.php"); ?>
<div id="wrapper">
    <?php include("includes/navigation.php"); ?>
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
                        if (isset($_POST['submit'])) {
                            $cat_title = $_POST['cat_title'];
                            if ($cat_title == "" || empty($cat_title)) {
                                echo "This field should not be empty";
                            } else {
                                $query = "
                                    INSERT INTO 
                                      categories 
                                      (cat_title) 
                                    VALUES 
                                      ('$cat_title')
                                ";
                                $create_category_query = mysqli_query($connection, $query);
                                if (!$create_category_query) {
                                    die('QUERY FAILED' . mysqli_error($connection));
                                }
                            }
                        }

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
                    </div>
                    <div class="col-xs-6">
                        <?php
                        $query = "SELECT * FROM categories";
                        $select_all_categories_query = mysqli_query($connection, $query);
                        ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Title</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
                                    $cat_id = $row['cat_id'];
                                    $cat_title = $row['cat_title'];
                                    echo "<tr>";
                                    echo "<td>{$cat_id}</td>";
                                    echo "<td>{$cat_title}</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("includes/admin_footer.php"); ?>

