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

    
    <head>
        <title>Login</title>
    </head>
    
    <style>
    
        *{margin: 0; padding: 0;}
        body{background: #ecf1f4; font-family: sans-serif;}
        
        .form-wrap{ width: 320px; background: #3e3d3d; padding: 40px 20px; box-sizing: border-box; position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%);}
        h1{text-align: center; color: #fff; font-weight: normal; margin-bottom: 20px;}
        
        input{width: 100%; background: none; border: 1px solid #fff; border-radius: 3px; padding: 6px 15px; box-sizing: border-box; margin-bottom: 20px; font-size: 16px; color: #fff;}
        
        input[type="button"]{ background: #bac675; border: 0; cursor: pointer; color: #3e3d3d;}
        input[type="button"]:hover{ background: #a4b15c; transition: .6s;}
        
        ::placeholder{color: #fff;}
    
    </style>

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
            <form action="login.php" method="POST">
                <h1>Login</h1>
                <input type="text" placeholder="E-Mail" name="email">
                <input type="password" placeholder="Password" name="password">
                <input type="hidden" value="login" name="requestType">
                <input type="submit" value="Enter">
                <input type="button" value="Forgot Password?">
            </form>
        </div>
    </body>
</html>