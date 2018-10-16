<?php include("includes/admin_header.php"); ?>
<?php
if (isset($_SESSION['username'])) {
    $user_name = $_SESSION['username'];
    $query = "
        SELECT
            *
        FROM
            users
        WHERE
            username = '{$user_name}'
    ";
    $select_user_profile_query = confirmQuery($query);
    while($row = mysqli_fetch_assoc($select_user_profile_query)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_first_name = $row['user_firstname'];
        $user_last_name = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_password = $row['user_password'];
        $user_role = $row['user_role'];
    }
}
?>
    <div id="wrapper">
        <?php include("includes/navigation.php"); ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
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
                                   value="<?php echo $the_user_id; ?>">
                            <div class="form-group">
                                <label for="user_firstname">First Name</label>
                                <input id="user_firstname"
                                       type="text"
                                       name="user_firstname"
                                       class="form-control"
                                       value="<?php echo $user_first_name; ?>">
                            </div>
                            <div class="form-group">
                                <label for="user_lastname">Last Name</label>
                                <input id="user_lastname"
                                       type="text"
                                       name="user_lastname"
                                       class="form-control"
                                       value="<?php echo $user_last_name; ?>">
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input id="username"
                                       type="text"
                                       name="username"
                                       class="form-control"
                                       value="<?php echo $username; ?>">
                            </div>

                            <div class="form-group">
                                <label for="user_email">Email</label>
                                <input id="user_email"
                                       type="email"
                                       name="user_email"
                                       class="form-control"
                                       value="<?php echo $user_email; ?>">
                            </div>
                            <div class="form-group">
                                <label for="user_password">Password</label>
                                <input id="user_password"
                                       type="password"
                                       name="user_password"
                                       class="form-control"
                                       value="<?php echo $user_password; ?>">
                            </div>
                            <div class="form-group">
                                <label for="user_role">Role</label>
                                <select id="user_role"
                                        name="user_role"
                                        class="form-control">
                                    <option value="subscriber">subscriber</option>
                                    <?php
                                    if ($user_role === 'admin') {
                                        echo "<option value='admin' selected>admin</option>";
                                    }
                                    ?>
                                </select>
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
<?php include("includes/admin_footer.php"); ?>