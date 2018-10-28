<?php
include(dirname(__FILE__) . "/includes/header.php");
include (dirname(__FILE__) . "/includes/navigation.php");

if (isset($_POST['submit'])) {

    if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        $username = escape($_POST['username']);
        $email = escape($_POST['email']);
        $password = escape($_POST['password']);

        $password = password_hash($password, PASSWORD_BCRYPT);
        $user_role = 'subscriber';
        $query = "
            INSERT INTO
                users
            (
                username, 
                user_email, 
                user_password, 
                user_role
            )
            VALUES 
            (
                '$username',
                '$email',
                '$password',
                '$user_role'
            )
        ";
        $insert_user = confirmQuery($query);
        $message = "ユーザー登録が完了しました。";
    } else {
        $message = "Fields cannot be empty";
    }

}
?>
<!-- Page Content -->
<div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <?php if (isset($message)) : ?>
                        <h6><?php echo h($message); ?></h6>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div>
        </div>
    </div>
</section>
<hr>
<?php include(dirname(__FILE__) . "/includes/footer.php"); ?>
