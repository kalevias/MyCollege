<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$homedir = "../../";
include_once $homedir."classes/UserRegister.php";
include_once $homedir."classes/UserLoginLogout.php";
//check if $_POST is empty
if (!empty($_POST)) {
    //checks if the request type is login
    if (isset($_POST["requestType"]) && $_POST["requestType"] == "register") {
        if ($_POST["password"] == $_POST["passwordconfirm"]) {
            //register user
            $result = UserRegister::register($_POST["firstName"], $_POST["lastName"], $_POST["email"], $_POST["streetAddress"], $_POST["city"], null, $_POST["zip"], $_POST["phoneNumber"], $_POST["gradYear"], $_POST["password"]);
            if ($result) {
                UserLoginLogout::userLogin($_POST["email"], $_POST["password"]);
            } else {
                $registerFail = true;
            }
        } else {
            //password does not match
            $registerFail = true;
        }
        if (isset($_SESSION["userLoggedIn"])) {
            header("Location: ../../index.php");
        } else {
            $registerFail = true;
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Student Sign Up</title>
        <link rel="stylesheet" href="css/register.min.css" type="text/css">
    </head>
    <body>
        <div>
            <?php
            if (isset($registerFail)) {
                ?>
                <h2>Some value is incorrect or invalid. Please try again.</h2>
                <?php
            }
            ?>
        </div>
        <div class="rcorners2">
            <form action="" method="POST">
                <h1>Student Sign Up</h1>
                <input type="text" placeholder="First Name" name="firstName">
                <input type="text" placeholder="Last Name" name="lastName">
                <input title="Please enter a valid email address using the '@' symbol" type="email" placeholder="Email Address" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                <input type="text" placeholder="Street Address" name="streetAddress">
                <input type="text" placeholder="City" name="city">
                <input type="text" placeholder="Zip" name="zip">
                <input title="Please enter a phone number in the form: XXX-XXX-XXXX" type="text" placeholder="Phone Number" name="phoneNumber" required pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                <input type="number" min="1900" max="2100" placeholder="Graduation Year" name="gradYear">
                <input title="Password must contain at least 6 characters, including UPPER/lowercase and numbers" type="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" placeholder="Password" name="password">
                <input type="password" placeholder="Confirm Password" name="passwordconfirm">
                <input type="hidden" value="register" name="requestType">
                <input type="submit" value="Sign Up">
            </form>
        </div>
    </body>
</html>