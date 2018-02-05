<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$homedir = "../../";
include $homedir . "classes/Authenticator.php";
//check if $_POST is empty
if (isset($_POST["requestType"]) && $_POST["requestType"] == "login") {
    Authenticator::login($_POST["email"], $_POST["password"]);
    if ($_SESSION["userLoggedIn"] != true) {
        $loginFail = true;
    }
}
?>
<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="<?php echo $homedir; ?>pages/login/css/login.min.css" type="text/css">
    <head>
        <title>Login</title>
    </head>
    <body>
        <?php
        if (isset($loginFail)) {
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
                    <input title="Please enter a valid email address" type="text" placeholder="E-Mail" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                    <input type="password" placeholder="Password" name="password">
                    <input type="hidden" value="login" name="requestType">
                    <input type="submit" value="Enter">
                </form>
                <input type="button" value="Forgot Password?">
            </div>
        </div>
    </body>
</html>