<?php

include "../../autoload.php";

$controller = $_SESSION["controller"] = new Controller("login");

$controller->initModuleDir();
$controller->processREQUEST();
$loginFail = isset($_SESSION["loginFail"]) ? $_SESSION["loginFail"] : false;
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="<?php echo $controller->getHomeDir(); ?>pages/login/css/login.min.css" type="text/css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="javascript/login.js"></script>
        <title>Login</title>
    </head>
    <body>
        <?php
        if (isset($loginFail) and $loginFail) {
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
                <input title="Please enter a valid email address" type="text" placeholder="E-Mail" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                <input type="password" placeholder="Password" name="password" id="password">
                <input type="hidden" value="login" name="requestType" id="requestType">
                <input type="button" name="login" id="login" value="Enter">
                <input type="button" name="reset" id="reset" value="Forgot Password?">
            </div>
        </div>
    </body>
</html>