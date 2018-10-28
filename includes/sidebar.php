<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <input type="text" name="search" class="form-control" value="">
                <span class="input-group-btn">
                <button class="btn btn-default" type="submit" name="submit">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
            </div>
        </form>
    </div>

    <div class="well">
        <h4>Login</h4>
        <form action="/cms/includes/login.php" method="post">
            <div class="form-group">
                <input type="text" name="username" placeholder="Enter Username" class="form-control" value="">
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Enter Password" class="form-control" value="">
                <span class="input-group-btn">
                    <button class="btn btn-primary"
                            name="login"
                            type="submit">
                        Submit
                    </button>
                </span>
            </div>
        </form>
    </div>
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    $query = "SELECT * FROM categories";
                    $select_all_categories_query = confirmQuery($query);
                    while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];
                        echo "<li><a href='/cms/category.php?category=$cat_id'>{$cat_title}</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <?php include("widget.php"); ?>
</div>