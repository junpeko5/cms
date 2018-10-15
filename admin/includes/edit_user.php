<?php
if (isset($_GET['u_id'])) {
    $the_user_id = $_GET['u_id'];
    $query = "
        SELECT 
            *
        FROM
            users
        WHERE
            user_id = $the_user_id
    ";
    $select_user = confirmQuery($query);
    while($row = mysqli_fetch_assoc($select_user)) {
        $user_id = $row['user_id'];
        $user_first_name = $row['user_firstname'];
        $user_last_name = $row['user_lastname'];
        $username = $row['username'];
        $user_email = $row['user_email'];
        $user_password = $row['user_password'];
        $user_role = $row['user_role'];
    }
}

if (isset($_POST['edit_user'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $user_first_name = $_POST['user_firstname'];
    $user_last_name = $_POST['user_lastname'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $user_role = $_POST['user_role'];

    $query = "
        UPDATE
            users
        SET
            username = '$username',
            user_firstname = '$user_first_name', 
            user_lastname = '$user_last_name', 
            user_email = '$user_email', 
            user_password = '$user_password', 
            user_role = '$user_role'
        WHERE user_id = $user_id
    ";
    confirmQuery($query);
    header("Location: /cms/admin/users.php?source=edit_user&u_id=$the_user_id");
    exit;
}
?>
<form action="/cms/admin/users.php?source=edit_user&u_id=<?php echo $the_user_id; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="user_id" value="<?php echo $the_user_id; ?>">
    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input id="user_firstname" type="text" name="user_firstname" class="form-control" value="<?php echo $user_first_name; ?>">
    </div>
    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input id="user_lastname" type="text" name="user_lastname" class="form-control" value="<?php echo $user_last_name; ?>">
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input id="username" type="text" name="username" class="form-control" value="<?php echo $username; ?>">
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input id="user_email" type="email" name="user_email" class="form-control" value="<?php echo $user_email; ?>">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input id="user_password" type="password" name="user_password" class="form-control" value="<?php echo $user_password; ?>">
    </div>
    <div class="form-group">
        <label for="user_role">Role</label>
        <select id="user_role" name="user_role" class="form-control">
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
               name="edit_user"
               value="Create User"
               class="btn btn-primary">
    </div>
</form>