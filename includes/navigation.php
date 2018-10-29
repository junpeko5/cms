<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/cms/index.php">CMS TOP</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                $query = "SELECT * FROM categories";
                $select_all_categories_query = confirmQuery($query);
                while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    echo "<li><a href='/cms/category.php?category=$cat_id'>{$cat_title}</a></li>";
                }
                ?>
                <li>
                    <a href="/cms/admin">Admin</a>
                </li>
                <li>
                    <a href="/cms/registration.php">Registration</a>
                </li>
                <li>
                    <a href="/cms/contact.php">Contact</a>
                </li>
                <?php
                if (isset($_SESSION['user_role'])) {
                    if (isset($_GET['p_id'])) {
                        $the_post_id = escape($_GET['p_id']);
                        echo "<li><a href='/cms/admin/posts.php?source=edit_post&p_id=$the_post_id'>Edit Post</a></li>";
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</nav>