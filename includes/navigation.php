<?php
if (isset($_GET['p_id'])) {
    $post_id = forceString('p_id');
}
?>
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
                $rows = findAll('categories');
                $pageName = basename($_SERVER['PHP_SELF']);
                ?>
                <?php foreach ($rows as $row) : ?>
                <li class="<?php if ($pageName === 'category.php' && isset($_GET['category']) && $_GET['category'] == $row['cat_id']): ?>active<?php endif; ?>">
                    <a href='/cms/category.php?category=<?php echo h($row['cat_id']); ?>'>
                        <?php echo h($row['cat_title']); ?>
                    </a>
                </li>
                <?php endforeach; ?>

                <li class="<?php if ($pageName === 'registration.php'): ?>active<?php endif; ?>">
                    <a href="/cms/registration.php">Registration</a>
                </li>
                <li class="<?php if ($pageName === 'contact.php'): ?>active<?php endif; ?>">
                    <a href="/cms/contact.php">Contact</a>
                </li>
                <?php if (isset($_SESSION['user_role'])) : ?>
                    <li><a href='/cms/admin/posts.php?source=edit_post&p_id=<?php echo h($post_id); ?>'>Edit Post</a></li>
                <?php endif; ?>
                <li>
                    <a href="/cms/admin">Admin</a>
                </li>
            </ul>
        </div>
    </div>
</nav>