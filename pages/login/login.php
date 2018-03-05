<?php

include "../../autoload.php";

$controller = $_SESSION["controller"] = new Controller("MyCollege");
$controller->initModuleDir();
$controller->processREQUEST();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>MyCollege</title>
        <link rel="stylesheet" href="css/login.min.css" type="text/css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="<?php echo $controller->getHomeDir(); ?>resources/common.js"></script>
        <script src="javascript/login.js"></script>
    </head>
    <body>
    <img class="bg-image" src="css/IndianaUni.jpg">

        <?php
        include $controller->getHomeDir() . Controller::MODULE_DIR . "/pageassembly/alerts/alerts.php";
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