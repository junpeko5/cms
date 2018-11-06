
<div class="col-md-4">
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="get">
            <div class="input-group">
                <input type="text" name="search" class="form-control" value="">
                <span class="input-group-btn">
                <button class="btn btn-default" type="submit" name="search" value="search">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
            </div>
        </form>
    </div>

    <div class="well">
        <?php if (isset($_SESSION['user_role'])) : ?>
            <h4><?php echo $_SESSION['username']; ?>としてログイン中</h4>
            <a href="/cms/includes/logout.php" class="btn btn-primary">ログアウト</a>
        <?php else: ?>
            <h4>ログイン</h4>
            <form action="/cms/login.php" method="post">
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
            <a href="/cms/forgot.php">パスワードを忘れた方はコチラ</a>
        <?php endif; ?>
    </div>
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    $categories = findAll('categories');
                    ?>
                    <?php foreach ($categories as $category) : ?>
                        <li>
                            <a href="/cms/category.php?category=<?php echo h($category['cat_id']); ?>">
                                <?php echo h($category['cat_title']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php include("widget.php"); ?>
</div>