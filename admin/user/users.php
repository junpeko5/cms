<?php
include(dirname(__FILE__) . "/../includes/admin_header.php");
if (!isAdminUser()) {
    redirect("/cms/admin/index.php");
}
?>
<div id="wrapper">
    <?php include(dirname(__FILE__) . "/../includes/navigation.php"); ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Users
                        <small></small>
                    </h1>
                    <?php
                    $rows = findAll('users');

                    if (isAdminUser()) {
                        if (isset ($_GET['delete'])) {
                            $user_id = forceString('delete');
                            deleteById('users', 'user_id', $user_id);
                            redirect("/cms/admin/user/users.php");
                        }

                        if (isset($_GET['admin_user_id'])) {
                            $args = [
                                'user_role' => 'admin',
                            ];
                            $args2 = [
                                'user_id' => $_GET['admin_user_id'],
                            ];
                            $args2 = force_1_dimension_array($args2);
                            updateUser($args, $args2);
                            redirect("/cms/admin/user/users.php");
                        }

                        if (isset($_GET['sub_user_id'])) {
                            $args = [
                                'user_role' => 'subscriber',
                            ];
                            $args2 = [
                                'user_id' => $_GET['sub_user_id'],
                            ];
                            $args2 = force_1_dimension_array($args2);

                            updateUser($args, $args2);
                            redirect("/cms/admin/user/users.php");
                        }
                    }
                    ?>
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>LastName</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Admin</th>
                            <th>Subscriber</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($rows as $row) : ?>
                            <tr>
                                <td><?php echo h($row['user_id']); ?></td>
                                <td><?php echo h($row['username']); ?></td>
                                <td><?php echo h($row['user_firstname']); ?></td>
                                <td><?php echo h($row['user_lastname']); ?></td>
                                <td><?php echo h($row['user_email']); ?></td>
                                <td><?php echo h($row['user_role']); ?></td>
                                <td><a href='/cms/admin/user/users.php?admin_user_id=<?php echo h($row['user_id']); ?>&admin='>Admin</a></td>
                                <td><a href='/cms/admin/user/users.php?sub_user_id=<?php echo h($row['user_id']); ?>'>Subscriber</a></td>
                                <td><a href='/cms/admin/user/edit_user.php?user_id=<?php echo h($row['user_id']); ?>'>Edit</a></td>
                                <td><a href='/cms/admin/user/users.php?delete=<?php echo h($row['user_id']); ?>'>Delete</a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include(dirname(__FILE__) . "/../includes/admin_footer.php"); ?>

