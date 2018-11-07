<?php
include(dirname(__FILE__) . "/includes/header.php");
include(dirname(__FILE__) . "/includes/navigation.php");

// Getで送られてきた時にパラメータが空の場合
if (isGet() && empty($_GET['forgot'])) {
    redirect('/cms/index');
}
if (isPost()) {
    if (isset($_POST['email'])) {
        $email = forceString('email');
        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));
        if (email_exists($email)) {
            $args = [
                'token' => $token
            ];
            $args2 = [
                'user_email' => $email
            ];
            $args = force_1_dimension_array($args);
            $args2 = force_1_dimension_array($args2);
            updateUser($args, $args2);
        } else {
            echo 'wrong';
        }
    }
}
?>
<div class="container">
    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">
                                    <form id="register-form"
                                          role="form"
                                          autocomplete="off"
                                          class="form"
                                          method="post">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-envelope color-blue"></i>
                                                </span>
                                                <input id="email"
                                                       name="email"
                                                       placeholder="email address"
                                                       class="form-control"
                                                       type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit"
                                                   class="btn btn-lg btn-primary btn-block"
                                                   value="Reset Password"
                                                   type="submit">
                                        </div>
                                        <input type="hidden"
                                               class="hide"
                                               name="token"
                                               id="token"
                                               value="">
                                    </form>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <?php include(dirname(__FILE__) . "/includes/footer.php"); ?>
</div>

