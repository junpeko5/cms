<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/cms/admin/index.php">CMS Admin</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li><a href="../index.php">Users Online: <span class="users_online"></span></a></li>
        <li><a href="../index.php">HOME SITE</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-user"></i>
                <?php if (isset($_SESSION['username'])) : ?>
                <?php echo h($_SESSION['username']); ?>
                <?php endif; ?>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="/cms/includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li>
                <a href="/cms/admin/index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="posts_dropdown" class="collapse">
                    <li>
                        <a href="/cms/admin/posts.php">View All Posts</a>
                    </li>
                    <li>
                        <a href="/cms/admin/posts.php?source=add_post">Add Post</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="/cms/admin/categories.php"><i class="fa fa-fw fa-dashboard"></i> Categories</a>
            </li>
            <li class="">
                <a href="/cms/admin/comments.php"><i class="fa fa-fw fa-file"></i> Comments</a>
            </li>
            <?php if (isAdminUser()) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#users_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="users_dropdown" class="collapse">
                    <li>
                        <a href="/cms/admin/user/users.php">View All users</a>
                    </li>
                    <li>
                        <a href="/cms/admin/user/add_user.php">Add User</a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>
            <?php if (!isAdminUser()) : ?>
            <li class="active">
                <a href="/cms/admin/profile.php"><i class="fa fa-fw fa-file"></i> Profile</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>