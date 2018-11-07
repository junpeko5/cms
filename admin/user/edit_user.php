<?php
include(dirname(__FILE__) . "/../includes/admin_header.php");
if (!isAdminUser()) {
    redirect("/cms/admin/index.php");
}

if (isset($_POST['edit_user'])) {
    $args = [
        'user_firstname' => $_POST['user_firstname'],
        'user_lastname' => $_POST['user_lastname'],
        'username' => $_POST['username'],
        'user_email' => $_POST['user_email'],
        'user_password' => $_POST['user_password'],
        'user_role' => $_POST['user_role'],
    ];
    $args = force_1_dimension_array($args);
    $args2 = [
        'user_id' => $_POST['user_id'],
    ];
    $args2 = force_1_dimension_array($args2);
    updateUser($args, $args2);
    redirect("/cms/admin/user/users.php");
}
if (!empty($_GET['u_id'])) {
    $user_id = forceString('u_id');
    $users = findAllById('users', 'user_id', $user_id);
} else {
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
                    <form action="/cms/admin/user/edit_user.php?u_id=<?php echo h($users['user_id']); ?>"
                          method="post"
                          enctype="multipart/form-data">
                        <input type="hidden"
                               name="user_id"
                               value="<?php echo h($users['user_id']); ?>">
                        <div class="form-group">
                            <label for="user_firstname">First Name</label>
                            <input id="user_firstname"
                                   type="text"
                                   name="user_firstname"
                                   class="form-control"
                                   value="<?php echo h($users['user_firstname']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_lastname">Last Name</label>
                            <input id="user_lastname"
                                   type="text"
                                   name="user_lastname"
                                   class="form-control"
                                   value="<?php echo h($users['user_lastname']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input id="username"
                                   type="text"
                                   name="username"
                                   class="form-control"
                                   value="<?php echo h($users['username']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input id="user_email"
                                   type="email"
                                   name="user_email"
                                   class="form-control"
                                   value="<?php echo h($users['user_email']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_password">Password</label>
                            <input id="user_password"
                                   type="password"
                                   name="user_password"
                                   class="form-control"
                                   value="<?php echo h($users['user_password']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_role">Role</label>
                            <select id="user_role"
                                    name="user_role"
                                    class="form-control">
                                <option value='subscriber'
                                    <?php if ($users['user_role'] === 'subscriber') : ?>
                                        selected
                                    <?php endif; ?>>
                                    subscriber
                                </option>
                                <option value='admin'
                                    <?php if ($users['user_role'] === 'admin') : ?>
                                        selected
                                    <?php endif; ?>>
                                    admin
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit"
                                   name="edit_user"
                                   value="更新する"
                                   class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include(dirname(__FILE__) . "/../includes/admin_footer.php"); ?>