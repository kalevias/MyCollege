<?php
include "../../autoload.php";

$controller = $_SESSION["controller"] = new Controller("MyCollege");
$controller->initModuleDir();
//$controller->processREQUEST();
$controller->checkPermissions(!$controller->userHasAccess()); //checks to see if no user is logged in

//check if $_POST is empty
if (!empty($_POST)) {
    //checks if the request type is login
    if (isset($_POST["requestType"]) && $_POST["requestType"] == "register") {
        if ($_POST["password"] == $_POST["confirmPassword"]) {
            //register user
            $result = Authenticator::registerRepresentative($_POST["firstName"], $_POST["lastName"], $_POST["email"], $_POST["streetAddress"], $_POST["city"], null, $_POST["zip"], $_POST["phoneNumber"], $_POST["gradYear"], $_POST["password"]);
            if ($result) {
                Authenticator::login($_POST["email"], $_POST["password"]);
            } else {
                $registerFail = true;
            }
        } else {
            //password does not match
            $registerFail = true;
        }
        if (isset($_SESSION["userLoggedIn"])) {
            header("Location: " . $controller->getHomeDir());
            exit;
        } else {
            $registerFail = true;
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>MyCollege</title>
        <link rel="stylesheet" href="css/register.min.css" type="text/css">
    </head>
    <body>
        <img class="bg-image" src="css/IndianaUni.jpg">
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
                <h1>College Rep Sign Up</h1>
                <input type="text" placeholder="First Name" name="firstName">
                <input type="text" placeholder="Last Name" name="lastName">
                <input title="Please enter a valid email address using the '@' symbol" type="email" placeholder="Email Address" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                <input title="Please enter a phone number in the form: XXX-XXX-XXXX" type="text" placeholder="Phone Number" name="phoneNumber" required pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                <input title="Password must contain at least 6 characters, including UPPER/lowercase and numbers" type="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" placeholder="Password" name="password">
                <input type="password" placeholder="Confirm Password" name="confirmPassword">
                <input type="hidden" value="registerRepresentative" name="requestType">
                <input type="submit" value="Sign Up">
            </form>
        </div>
    </body>
</html>