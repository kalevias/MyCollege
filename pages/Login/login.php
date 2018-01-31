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
        body{background: #c1c1c1; font-family: sans-serif;}

        
        input{width: 100%; background: none; border: 1px solid #fff; border-radius: 3px; padding: 6px 15px; box-sizing: border-box; margin-bottom: 20px; font-size: 16px; color: #fff;}
        
        input[type="button"]{ background: #b3fce5; border: 0; cursor: pointer; color: #3e3d3d;}
        input[type="button"]:hover{ background: #b3fce5; transition: .6s;}
        
        ::placeholder{color: #b3fce5;}


        .rcorners2 {
            border-radius: 25px;
            border: 2px solid #73AD21;
            padding: 40px;
            width: 200px;
            height: 250px;
            position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%);
        }

    
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
            <div class="rcorners2"
            <form action="login.php" method="POST">
                <h1>Login</h1>
                <input type="text" placeholder="E-Mail" name="email">
                <input type="password" placeholder="Password" name="password">
                <input type="hidden" value="login" name="requestType">
                <input type="submit" value="Enter">
                <input type="button" value="Forgot Password?">
            </form>
        </div>
    </div>
    </body>
</html>