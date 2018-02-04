<?php
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    include "../../classes/UserLoginLogout.php";
    //check if $_POST is empty
    if(!empty($_POST)){
        //checks if the request type is login
        if(isset($_POST["requestType"]) && $_POST["requestType"] == "login"){
            UserLoginLogout::userLogin($_POST["email"], $_POST["password"]);
            if($_SESSION["userLoggedIn"] == true){
				header("Location: ../../index.php");
            }else{
                $loginFail = true;
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="css/login.css" type="text/css">
    
    <head>
        <title>Login</title>
    </head>
    

    <body>
        <div>
            <?php
                if(isset($loginFail)){
            ?>
                <h2>Password or E-Mail is incorrect. Please try again.</h2>
            <?php
                }
            ?>
        </div>
        <div class="form-wrap">
            <div class="rcorners2"
            <form action="login.php" method="POST">
                <h1>Login</h1>
                <input title="Please enter a valid email address" type="text" placeholder="E-Mail" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                <input type="password" placeholder="Password" name="password">
                <input type="hidden" value="login" name="requestType">
                <input type="submit" value="Enter">
                <input type="button" value="Forgot Password?">
            </form>
        </div>
    </div>
    </body>
</html>