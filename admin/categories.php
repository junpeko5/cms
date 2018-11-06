<?php include(dirname(__FILE__) . "/includes/admin_header.php"); ?>
<div id="wrapper">
    <?php include(dirname(__FILE__) . "/includes/navigation.php"); ?>
    <?php
    // カテゴリー更新処理
    if (isset($_POST['update'])) {
        $args = [
            'cat_title' => $_POST['cat_title'],
            'cat_id' => $_POST['cat_id'],
        ];
        $args = force_1_dimension_array($args);
        updateCategory($args);
    }

    // カテゴリー削除処理
    if (isset($_GET['delete'])) {
        $id = forceString('delete');
        deleteById('categories', 'cat_id', $id);
        redirect("/cms/admin/categories.php");
    }

    // 初期表示処理
    if (isset($_GET['edit'])) {
        $cat_id = forceString('edit');
        $row = findAllById('categories', 'cat_id', $cat_id);
    }

    // カテゴリー登録処理
    if (isset($_POST['insert'])) {
        $args = [
            'cat_title' => forceString('cat_title'),
        ];
        $args = force_1_dimension_array($args);
        create('category', $args);
        redirect("/cms/admin/categories.php");
    }

    ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Category
                        <small>Author</small>
                    </h1>
                    <div class="col-xs-6">
                        <form action="/cms/admin/categories.php" method="post">
                            <div class="form-group">
                                <label for="cat-title">Add Category</label>
                                <input id="cat-title" type="text" name="cat_title" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="insert" value="Add Category" class="btn btn-primary">
                            </div>
                        </form>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="cat-title">Edit Category</label>
                                <input type="hidden"
                                       name="cat_id"
                                       value="<?php echo isset($row['cat_id']) ? h($row['cat_id']) : '';?>">
                                <input type="text"
                                       name="cat_title"
                                       class="form-control"
                                       value="<?php echo isset($row['cat_title']) ? h($row['cat_title']) : '';?>">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="update" value="カテゴリーを更新" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Title</th>
                                    <th>削除</th>
                                    <th>編集</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rows = findAll('categories');
                                ?>
                                <?php foreach ($rows as $row) : ?>
                                <tr>
                                    <td><?php echo h($row['cat_id']); ?></td>
                                    <td><?php echo h($row['cat_title']); ?></td>
                                    <td><a href="categories.php?delete=<?php echo h($row['cat_id']); ?>">Delete</a></td>
                                    <td><a href="categories.php?edit=<?php echo h($row['cat_id']); ?>">Edit</a></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include(dirname(__FILE__) . "/includes/admin_footer.php"); ?>
