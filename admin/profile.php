<?php
include(dirname(__FILE__) . "/includes/admin_header.php");

if (isset($_POST['edit_profile'])) {
    $args = [
        'user_id' => $_POST['user_id'],
        'username' => $_POST['username'],
        'user_firstname' => $_POST['user_firstname'],
        'user_lastname' => $_POST['user_lastname'],
        'user_email' => $_POST['user_email'],
        'user_password' => $_POST['user_password'],
    ];
    $args = force_1_dimension_array($args);
    updateUser($args);
    redirect("/cms/admin/profile.php");
}

if (isset($_SESSION['username'])) {
    $user_id = $_SESSION['user_id'];
    $user = findAllById('users', 'user_id', $user_id);
}
?>
<div id="wrapper">
    <?php include(dirname(__FILE__) . "/includes/navigation.php"); ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Profile
                        <small></small>
                    </h1>
                    <form action="/cms/admin/profile.php"
                          method="post"
                          enctype="multipart/form-data">
                        <input type="hidden"
                               name="user_id"
                               value="<?php echo h($user['user_id']); ?>">
                        <div class="form-group">
                            <label for="user_firstname">First Name</label>
                            <input id="user_firstname"
                                   type="text"
                                   name="user_firstname"
                                   class="form-control"
                                   value="<?php echo h($user['user_firstname']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_lastname">Last Name</label>
                            <input id="user_lastname"
                                   type="text"
                                   name="user_lastname"
                                   class="form-control"
                                   value="<?php echo h($user['user_lastname']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input id="username"
                                   type="text"
                                   name="username"
                                   class="form-control"
                                   value="<?php echo h($user['username']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input id="user_email"
                                   type="email"
                                   name="user_email"
                                   class="form-control"
                                   value="<?php echo h($user['user_email']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_password">Password</label>
                            <input id="user_password"
                                   type="password"
                                   name="user_password"
                                   class="form-control"
                                   value="<?php echo h($user['user_password']); ?>">
                        </div>
                        <div class="form-group">
                            <input type="submit"
                                   name="edit_profile"
                                   value="Update Profile"
                                   class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include(dirname(__FILE__) . "/includes/admin_footer.php"); ?>