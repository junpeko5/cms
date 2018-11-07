<?php
include(dirname(__FILE__) . "/../includes/admin_header.php");
if (!isAdminUser()) {
    redirect("/cms/admin/index.php");
}


?>

<div id="wrapper">
    <?php include(dirname(__FILE__) . "/../includes/navigation.php"); ?>
    <?php
    if (isset($_POST['create_user'])) {
        $args = [
            'user_firstname' => $_POST['user_firstname'],
            'user_lastname' => $_POST['user_lastname'],
            'username' => $_POST['username'],
            'user_email' => $_POST['user_email'],
            'user_password' => $_POST['user_password'],
            'user_role' => $_POST['user_role'],
        ];
        $args = force_1_dimension_array($args);
        $user_id = createUser($args);
        redirect('/cms/admin/user/users.php');
    }
    ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Users
                        <small></small>
                    </h1>
                    <form action="/cms/admin/user/add_user.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="user_firstname">First Name</label>
                            <input id="user_firstname" type="text" name="user_firstname" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="user_lastname">Last Name</label>
                            <input id="user_lastname" type="text" name="user_lastname" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input id="username" type="text" name="username" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input id="user_email" type="email" name="user_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="user_password">Password</label>
                            <input id="user_password" type="password" name="user_password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="user_role">Role</label>
                            <select id="user_role" name="user_role" class="form-control">
                                <option value="subscriber">Select options</option>
                                <option value="admin">Admin</option>
                                <option value="subscriber">Subscriber</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit"
                                   name="create_user"
                                   value="ユーザー登録"
                                   class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include(dirname(__FILE__) . "/../includes/admin_footer.php"); ?>