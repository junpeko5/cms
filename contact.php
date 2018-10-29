<?php
include(dirname(__FILE__) . "/includes/header.php");
include (dirname(__FILE__) . "/includes/navigation.php");

mail("junpeko_0115@yahoo.co.jp", "my subject", "message");

if (isset($_POST['submit'])) {

    if (!empty($_POST['email']) && !empty($_POST['subject']) && !empty($_POST['body'])) {
//        $to = escape($_POST['email']);
        $to = escape('junpeko_0115@yahoo.co.jp');
        $subject = escape($_POST['subject']);
        $body = escape($_POST['body']);
    }
}
?>
<div class="container">
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Contact</h1>
                        <form role="form" action="/cms/contact.php" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div>
                            <div class="form-group">
                                <label for="subject" class="sr-only">件名</label>
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter your subject">
                            </div>
                            <div class="form-group">
                                <label for="body" class="sr-only">メール本文</label>
                                <textarea name="body" id="body" cols="30" rows="10" id="body" class="form-control"></textarea>
                            </div>
                            <input type="submit" name="submit" id="" class="btn btn-custom btn-lg btn-block" value="Submit">
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <hr>
    <?php include(dirname(__FILE__) . "/includes/footer.php"); ?>
