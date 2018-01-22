<?php
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    include_once "../../classes/UserRegister.php";
    include_once "../../classes/UserLoginLogout.php";
    //check if $_POST is empty
    if(!empty($_POST)){
        //checks if the request type is login
        if(isset($_POST["requestType"]) && $_POST["requestType"] == "register"){
            if($_POST["password"] == $_POST["passwordconfirm"]){
                //register user
                $result = UserRegister::register($_POST["firstName"], $_POST["lastName"], $_POST["email"], $_POST["streetAddress"], $_POST["city"], null, $_POST["zip"], $_POST["phoneNumber"], $_POST["gradYear"], $_POST["password"]);
                if($result){
                   UserLoginLogout::userLogin($_POST["email"], $_POST["password"]);
                }else{
                    $registerFail = true;
                }
            }else{
                //password does not match
                $registerFail = true;
            }
            if(isset($_SESSION["userLoggedIn"])){
                header("Location: ../index.php");
            }else{
                $registerFail = true;
            }
        }
    }
?>
<!DOCTYPE html>
<html>

    
    <head>
        <title>Sign Up</title>
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
            if(isset($registerFail)){
                ?>
                <h2>Some value is incorrect or invalid. Please try again.</h2>
                <?php
            }
            ?>
        </div>
        <div class="form-wrap">
            <form action="" method="POST">
                <h1>Sign Up</h1>
                <input type="text" placeholder="First Name" name="firstName">
                <input type="text" placeholder="Last Name" name="lastName">
                <input type="email" placeholder="Email Address"name="email">
                <input type="text" placeholder="Street Address" name="streetAddress">
                <input type="text" placeholder="City" name="city">
                <input type="text" placeholder="Zip" name="zip">
                <input type="text" placeholder="Phone Number" name="phoneNumber">
                <input type="number" min="1900" max="2100" placeholder="Graduation Year" name="gradYear">
                <input type="password" placeholder="Password" name="password">
                <input type="password" placeholder="Confirm Password" name="passwordconfirm">
                <input type="hidden" value="register" name="requestType">
                <input type="submit" value="Sign Up">
            </form>
        </div>
    </body>



</html>