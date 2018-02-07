<?php

include "../../autoload.php";

$controller = $_SESSION["controller"] = new Controller("ResetPassword");
$controller->initModuleDir();
$controller->processREQUEST();

$resetFail = isset($_SESSION["resetFail"]) ? $_SESSION["resetFail"] : false;

?>
<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="<?php echo $controller->getHomeDir(); ?>pages/login/css/passwordreset.min.css" type="text/css">
    <head>
        <title>Password Reset</title>
    </head>
    <body>
        <?php
        if (isset($resetFail) and $resetFail) {
            ?>
            <div>
                <h2>Password or E-Mail is incorrect. Please try again.</h2>
            </div>
            <?php
        }
        ?>
        <div class="form-wrap">
            <div class="rcorners2">
                <h1>Login</h1>
                <form action="#" method="POST">
                    <input type="password" placeholder="New Password" name="password">
                    <input type="confirmPassword" placeholder="Confirm New Password" name="confirmPassword">
                    <input type="hidden" value="resetPassword" name="requestType">
                    <input type="submit" value="Enter">
                </form>
            </div>
        </div>
    </body>
</html>