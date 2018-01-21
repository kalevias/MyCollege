<?php
//$homedir = "../../";
?>

<!DOCTYPE html>
<html>
    <title>MyCollege</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body, h1, h2, h3, h4, h5, h6 {
            font-family: "Lato", sans-serif
        }

        .w3-bar, h1, button {
            font-family: "Montserrat", sans-serif
        }

        .fa-anchor, .fa-coffee {
            font-size: 200px
        }
    </style>

    <!-- Navbar -->
    <div class="w3-top">
        <div class="w3-bar w3-red w3-card w3-left-align w3-large">
            <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-red" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
            <a href="#" class="w3-bar-item w3-button w3-padding-large w3-white">Home</a>
            <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Schools</a>
            <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Scholarships</a>
            <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Test Prep</a>
            <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">More</a>
            <p class="navbar-right actions">
                <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;" class="btn btn-default action-button">
                    Login
                </button>
                <button onclick="document.getElementById('id02').style.display='block'" style="width:auto;" class="btn btn-default action-button">
                    Sign Up
                </button>
            </p>
        </div>

        <body>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <style>

                /* Full-width input fields */
                input[type=text], input[type=password] {
                    width: 100%;
                    padding: 12px 20px;
                    margin: 8px 0;
                    display: inline-block;
                    border: 1px solid #ccc;
                    box-sizing: border-box;

                }

                /* Set a style for all buttons */
                button {
                    background-color: #4CAF50;
                    color: white;
                    padding: 14px 20px;
                    margin: 8px 0;
                    border: none;
                    cursor: pointer;
                    width: 20%;
                }

                button:hover {
                    opacity: 0.8;
                }

                /* Extra styles for the cancel button */
                .cancelbtn {
                    width: auto;
                    padding: 10px 18px;
                    background-color: #f44336;
                }

                /* Center the image and position the close button */
                .imgcontainer {
                    text-align: center;
                    margin: 24px 0 12px 0;
                    position: relative;
                }

                avatar {
                    width: 40%;
                    border-radius: 50%;
                }

                .container {
                    padding: 16px;
                }

                span.psw {
                    float: right;
                    padding-top: 16px;
                }

                /* The Modal (background) */
                .modal1 {
                    display: none; /* Hidden by default */
                    position: fixed; /* Stay in place */
                    z-index: 1; /* Sit on top */
                    left: 0;
                    top: 0;
                    width: 100%; /* Full width */
                    height: 100%; /* Full height */
                    overflow: auto; /* Enable scroll if needed */
                    background-color: rgb(0, 0, 0); /* Fallback color */
                    background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
                    padding-top: 60px;
                    padding-right: 80px;
                    padding-left: 80px;
                }

                /* Modal Content/Box */
                .modal1-content {
                    background-color: #fefefe;
                    margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
                    border: 1px solid #888;
                    width: 80%; /* Could be more or less, depending on screen size */
                }

                /* The Close Button (x) */
                .close {
                    position: absolute;
                    right: 25px;
                    top: 0;
                    color: #000;
                    font-size: 35px;
                    font-weight: bold;
                }

                .close:hover,
                .close:focus {
                    color: red;
                    cursor: pointer;
                }

                /* Add Zoom Animation */
                .animate {
                    -webkit-animation: animatezoom 0.6s;
                    animation: animatezoom 0.6s
                }

                @-webkit-keyframes animatezoom {
                    from {
                        -webkit-transform: scale(0)
                    }
                    to {
                        -webkit-transform: scale(1)
                    }
                }

                @keyframes animatezoom {
                    from {
                        transform: scale(0)
                    }
                    to {
                        transform: scale(1)
                    }
                }

                /* Change styles for span and cancel button on extra small screens */
                @media screen and (max-width: 300px) {
                    span.psw {
                        display: block;
                        float: none;
                    }

                    .cancelbtn {
                        width: 100%;
                    }
                }
            </style>
        </body>

        <body>
            <style>
                body {
                    font-family: Arial;
                }

                * {
                    box-sizing: border-box
                }

                /* Full-width input fields */
                input[type=text], input[type=password] {
                    width: 100%;
                    padding: 15px;
                    margin: 5px 0 22px 0;
                    display: inline-block;
                    border: none;
                    background: #f1f1f1;
                }

                /* Add a background color when the inputs get focus */
                input[type=text]:focus, input[type=password]:focus {
                    background-color: #ddd;
                    outline: none;
                }

                /* Set a style for all buttons */
                button {
                    background-color: #4CAF50;
                    color: white;
                    padding: 14px 20px;
                    margin: 8px 0;
                    border: none;
                    cursor: pointer;
                    width: 100%;
                    opacity: 0.9;
                }

                button:hover {
                    opacity: 1;
                }

                /* Extra styles for the cancel button */
                .cancelbtn {
                    padding: 14px 20px;
                    background-color: #f44336;
                }

                /* Float cancel and signup buttons and add an equal width */
                .cancelbtn, .signupbtn {
                    float: left;
                    width: 50%;
                }

                /* Add padding to container elements */
                .container {
                    padding: 16px;
                    width: auto;
                }

                /* The Modal (background) */
                .modal2 {
                    display: none; /* Hidden by default */
                    position: fixed; /* Stay in place */
                    z-index: 1; /* Sit on top */
                    left: 0;
                    top: 0;
                    width: 100%; /* Full width */
                    height: 100%; /* Full height */
                    overflow: auto; /* Enable scroll if needed */
                    background-color: #474e5d;
                    padding-top: 50px;
                    padding-right: 200px;
                    padding-left: 200px;

                }

                /* Modal Content/Box */
                .modal2-content {
                    background-color: #fefefe;
                    margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
                    border: 1px solid #888;
                    width: auto; /* Could be more or less, depending on screen size */
                    height: auto;
                }

                /* Style the horizontal ruler */
                hr {
                    border: 1px solid #f1f1f1;
                    margin-bottom: 25px;
                }

                /* The Close Button (x) */
                .close {
                    position: absolute;
                    right: 35px;
                    top: 15px;
                    font-size: 40px;
                    font-weight: bold;
                    color: #f1f1f1;
                }

                .close:hover,
                .close:focus {
                    color: #f44336;
                    cursor: pointer;
                }

                /* Clear floats */
                .clearfix::after {
                    content: "";
                    clear: both;
                    display: table;
                }

                /* Change styles for cancel button and signup button on extra small screens */
                @media screen and (max-width: 300px) {
                    .cancelbtn, .signupbtn {
                        width: 100%;
                    }
                }
            </style>
        </body>

        <body>
            <div id="id01" class="modal1">
                <form class="modal1-content animate" action="/action_page.php">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal1">&times;</span>
                        <img src="<?php echo $homedir; ?>pages/homepage/images/56-512.png" alt="Avatar" class="avatar">
                    </div>

                    <div class="container">
                        <label><b>Username</b></label>
                        <input type="text" placeholder="Enter Username" name="uname" required>

                        <label><b>Password</b></label>
                        <input type="password" placeholder="Enter Password" name="psw" required>

                        <button type="submit">Login</button>
                        <label>
                            <input type="checkbox" checked="checked"> Remember me
                        </label>
                    </div>

                    <div class="container" style="background-color:#f1f1f1">
                        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">
                            Cancel
                        </button>
                        <span class="psw"><a href="#"> Forgot Password?</a></span>
                    </div>
                </form>
            </div>

            <script>
                // Get the modal
                var modal1 = document.getElementById('id01');

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function (event) {
                    if (event.target == modal1) {
                        modal1.style.display = "none";
                    }
                }
            </script>

            <div id="id02" class="modal2">
                <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal2">&times;</span>
                <form class="modal-content" action="/action_page.php">
                    <div class="container">
                        <h1>Sign Up</h1>
                        <p>Please fill in this form to create an account.</p>
                        <hr>

                        <label><b>Email</b></label>
                        <input type="text" placeholder="Enter Email" name="email" required>

                        <label><b>Password</b></label>
                        <input type="password" placeholder="Enter Password" name="psw" required>

                        <label><b>Repeat Password</b></label>
                        <input type="password" placeholder="Repeat Password" name="psw-repeat" required>

                        <label>
                            <input type="checkbox" checked="checked" style="margin-bottom:15px"> Remember me
                        </label>

                        <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>

                        <div class="clearfix">
                            <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">
                                Cancel
                            </button>
                            <button type="submit" class="signupbtn">Sign Up</button>
                        </div>
                    </div>
                </form>
            </div>

            <script>
                // Get the modal
                var modal1 = document.getElementById('id01');
                var modal2 = document.getElementById('id02');

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function (event) {
                    if (event.target == modal1) {
                        modal1.style.display = "none";
                    }
                    if (event.target == modal2) {
                        modal2.style.display = "none";
                    }
                }
            </script>
        </body>

        <!-- Navbar on small screens -->
        <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium w3-large">
            <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 1</a>
            <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 2</a>
            <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 3</a>
            <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 4</a>
        </div>
    </div>

    <!-- Header -->
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .carousel-inner > .item > img,
        .carousel-inner > .item > a > img {
            width: 100%;
            margin: auto;
        }

        .carousel-inner > .item {
            position: relative;
            max-height: 600px;
        }

        .carousel-caption {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
    </head>
    <body>
        <div class="container">
            <br>
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                    <li data-target="#myCarousel" data-slide-to="3"></li>
                    <li data-target="#myCarousel" data-slide-to="4"></li>
                    <li data-target="#myCarousel" data-slide-to="5"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="<?php echo $homedir; ?>pages/homepage/images/NWUni.jpg" alt="Chania" width="460" height="345">
                        <div class="carousel-caption">
                            <h3>North Western University</h3>
                            <p></p>
                        </div>
                    </div>

                    <div class="item">
                        <img src="<?php echo $homedir; ?>pages/homepage/images/WashUni.jpg" alt="Chania" width="460" height="345">
                        <div class="carousel-caption">
                            <h3>Washington University</h3>
                            <p></p>
                        </div>
                    </div>

                    <div class="item">
                        <img src="<?php echo $homedir; ?>pages/homepage/images/BrynMawrCollege.jpg" alt="Chania" width="460" height="345">
                        <div class="carousel-caption">
                            <h3>Bryn Mawr Collegey</h3>
                            <p></p>
                        </div>
                    </div>

                    <div class="item">
                        <img src="<?php echo $homedir; ?>pages/homepage/images/IndianaUni.jpg" alt="Chania" width="460" height="345">
                        <div class="carousel-caption">
                            <h3>Indiana University</h3>
                            <p></p>
                        </div>
                    </div>

                    <div class="item">
                        <img src="<?php echo $homedir; ?>pages/homepage/images/UniOfChi.jpg" alt="Chania" width="460" height="345">
                        <div class="carousel-caption">
                            <h3>University of Chicago</h3>
                            <p></p>
                        </div>
                    </div>

                    <div class="item">
                        <img src="<?php echo $homedir; ?>pages/homepage/images/WellesleyCollege.jpg" alt="Chania" width="460" height="345">
                        <div class="carousel-caption">
                            <h3>Wellesley College
                                <p></p>
                        </div>
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

        <!-- First Grid -->
        <div class="w3-row-padding w3-padding-64 w3-container">
            <div class="w3-content">
                <div class="w3-twothird">
                    <h1>Lorem Ipsum</h1>
                    <h5 class="w3-padding-32">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</h5>

                    <p class="w3-text-grey">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint
                        occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
                        consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>

                <div class="w3-third w3-center">
                    <i class="fa fa-anchor w3-padding-64 w3-text-red"></i>
                </div>
            </div>
        </div>

        <!-- Second Grid -->
        <div class="w3-row-padding w3-light-grey w3-padding-64 w3-container">
            <div class="w3-content">
                <div class="w3-third w3-center">
                    <i class="fa fa-coffee w3-padding-64 w3-text-red w3-margin-right"></i>
                </div>

                <div class="w3-twothird">
                    <h1>Lorem Ipsum</h1>
                    <h5 class="w3-padding-32">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</h5>

                    <p class="w3-text-grey">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint
                        occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
                        consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
            </div>
        </div>

        <div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
            <h1 class="w3-margin w3-xlarge">Quote of the day: live life</h1>
        </div>

        <!-- Footer -->
        <footer class="w3-container w3-padding-64 w3-center w3-opacity">
            <div class="w3-xlarge w3-padding-32">
                <i class="fa fa-facebook-official w3-hover-opacity"></i>
                <i class="fa fa-instagram w3-hover-opacity"></i>
                <i class="fa fa-snapchat w3-hover-opacity"></i>
                <i class="fa fa-pinterest-p w3-hover-opacity"></i>
                <i class="fa fa-twitter w3-hover-opacity"></i>
                <i class="fa fa-linkedin w3-hover-opacity"></i>
            </div>
            <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
        </footer>

        <script>
            // Used to toggle the menu on small screens when clicking on the menu button
            function myFunction() {
                var x = document.getElementById("navDemo");
                if (x.className.indexOf("w3-show") == -1) {
                    x.className += " w3-show";
                } else {
                    x.className = x.className.replace(" w3-show", "");
                }
            }
        </script>
    </body>
</html>