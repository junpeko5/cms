<?php
include(dirname(__FILE__) . "/includes/header.php");
include (dirname(__FILE__) . "/includes/navigation.php");
$errors = [];
if (isPost()) {
    $username = forceString('username');
    $email = forceString('email');
    $password = forceString('password');
    $errors = validateUser(
        $username,
        $email,
        $password
    );
    $args = [
        'username' => $username,
        'user_email' => $email,
        'user_password' => $password
    ];
    createUser($args);
    logoutUser();
    loginUser($username, $password);
}
?>
<div class="container">
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form"
                          action="registration.php"
                          method="post"
                          id="login-form"
                          autocomplete="off">
                        <?php foreach($errors as $error) : ?>
                        <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text"
                                   name="username"
                                   id="username"
                                   class="form-control"
                                   placeholder="Enter Desired Username"
                                   value="<?php echo isset($_POST['username']) ? h($_POST['username']) : ''; ?>"
                                   autocomplete="on">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control"
                                   placeholder="somebody@example.com"
                                   value="<?php echo isset($_POST['email']) ? h($_POST['email']) : ''; ?>"
                                   autocomplete="on">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password"
                                   name="password"
                                   id="key"
                                   class="form-control"
                                   placeholder="Password">
                        </div>
                
                        <input type="submit"
                               name="register"
                               id="btn-login"
                               class="btn btn-primary btn-lg btn-block"
                               value="Register">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<hr>
<?php include(dirname(__FILE__) . "/includes/footer.php"); ?>
