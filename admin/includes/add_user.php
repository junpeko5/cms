<?php
if (isset($_POST['create_user'])) {

    $username = $_POST['username'];
    $user_first_name = $_POST['user_firstname'];
    $user_last_name = $_POST['user_lastname'];
    $user_email = $_POST['user_email'];
    $user_password = password_hash($_POST['user_password'], PASSWORD_BCRYPT);
    $user_role = $_POST['user_role'];

    $query = "
        INSERT INTO
            users
        (
            username, 
            user_firstname, 
            user_lastname, 
            user_email, 
            user_password, 
            user_role
        )
        VALUES
        (
            '{$username}',
            '{$user_first_name}',
            '{$user_last_name}',
            '{$user_email}',
            '{$user_password}',
            '{$user_role}'
        )   
    ";
    confirmQuery($query);
    echo "User Created: " . " " . "<a href='users.php'>View Users</a>";
}
?>
<form action="/cms/admin/users.php?source=add_user" method="post" enctype="multipart/form-data">

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
               value="Create User"
               class="btn btn-primary">
    </div>
</form>