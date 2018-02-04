<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION["userLoggedIn"])) {
    $loggedIn = true;
} else {
    $loggedIn = false;
}
if (isset($_POST["requestType"]) && $_POST["requestType"] == "logout") {
    $loggedIn = false;
    unset($_SESSION["userPermission"]);
    unset($_SESSION["userLoggedIn"]);
}
?>

<!DOCTYPE html>
<html>
<title>MyCollege</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/index.min.css" type="text/css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
    body, h1, h2, h3, h4, h5, h6 {
        font-family: "Lato", sans-serif
    }

    .w3-bar, h1, button {
        font-family: "Montserrat", sans-serif
    }

    .fa-anchor, .fa-coffee {
        font-size: 150px
    }
</style>

<body>

<!-- Navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="#" class="navbar-nav navbar-default">MyCollege</a></li>
                <li>  <a href="/MyCollege/pages/Search/SearchResults.php" class="navbar-nav navbar-default">Schools</a></li>
                <li> <a href="#" class="navbar-nav navbar-default">Scholarships</a></li>
                <li> <a href="#" class="navbar-nav navbar-default">Events</a></li>
                <li>  <a href="#" class="navbar-nav navbar-default">More</a></li>

            <?php
            if ($loggedIn) {
                ?>

                <form action="" method="POST">
                    <input type="hidden" value="logout" name="requestType">
                    <input type="submit" class="navbar-nav navbar-default"
                           value="Log Out">
                </form>

                <li><a href="#myModal" data-toggle="modal" data-target="#myModal"><span
                                class="glyphicon glyphicon-search"></span></a></li>

                <?php
            } else {
                ?>

               <li> <a href="/mycollege/pages/Login/login.php"
                       class="navbar-nav navbar-default">Login</a></li>



                <li><span class="navbar-nav navbar-default dropdown">
                    <button class="navbar-nav navbar-default dropdown-toggle" id="registermenu" type="button" data-toggle="dropdown">
                        Register
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="registermenu">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="/mycollege/pages/Register/signup.php">Students</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="/mycollege/pages/Register/signup.php">College Reps</a></li>
                    </ul>
                    </span></li>

                <li><a href="#myModal" data-toggle="modal" data-target="#myModal"><span
                                class="glyphicon glyphicon-search"></span></a></li>

            </ul>



                <?php
            }
            ?>


        </div>

</nav>

<div class="container">


    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <br>

                <form action="/MyCollege/pages/Search/SearchResults.php" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="inputEmail3">Search</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control"
                                   id="inputEmail3" placeholder="Enter Text Here"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Enter">
                    </div>
            </div>

        </div>
    </div>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Header -->


    <div class="container-fluid">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
                <li data-target="#myCarousel" data-slide-to="3"></li>
                <li data-target="#myCarousel" data-slide-to="4"></li>
                <li data-target="#myCarousel" data-slide-to="5"></li>
                <li data-target="#myCarousel" data-slide-to="6"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <img src="/mycollege/pages/homepage/images/NWUni.jpg" alt="Los Angeles" style="width:100%;">
                    <div class="carousel-caption">
                        <h3>Northwestern University</h3>

                    </div>
                </div>

                <div class="item">
                    <img src="/mycollege/pages/homepage/images/IndianaUni.jpg" alt="Chicago" style="width:100%;">
                    <div class="carousel-caption">
                        <h3>Indiana University</h3>

                    </div>
                </div>

                <div class="item">
                    <img src="/mycollege/pages/homepage/images/WashUni.jpg" alt="New york" style="width:100%;">
                    <div class="carousel-caption">
                        <h3>Washington University</h3>

                    </div>
                </div>

                <div class="item">
                    <img src="/mycollege/pages/homepage/images/BrynMawrCollege.jpg" alt="New york" style="width:100%;">
                    <div class="carousel-caption">
                        <h3>Bryn Mawr College</h3>

                    </div>
                </div>


                <div class="item">
                    <img src="/mycollege/pages/homepage/images/UniOfChi.jpg" alt="New york" style="width:100%;">
                    <div class="carousel-caption">
                        <h3>University Of Chicago</h3>

                    </div>
                </div>

                <div class="item">
                    <img src="/mycollege/pages/homepage/images/WellesleyCollege.jpg" alt="New york" style="width:100%;">
                    <div class="carousel-caption">
                        <h3>Wellesley College</h3>

                    </div>
                </div>


            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <!-- First Grid -->
    <div class="w3-row-padding w3-padding-64 w3-container">
        <div class="w3-content">
            <div class="w3-twothird">
                <h1>About MyCollege</h1>
                <h5 class="w3-padding-32"></h5>

                <p class="w3-text-grey">MyCollege is your one stop shop for all your college information. We care about
                    your education and hope to match you with the college of your dreams. Whether you need information
                    about what a school has to offer, or their scholarship opportunities – MyCollege provides all that
                    information for you in a nice simple way. </p>
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
                <h1>Features We Offer</h1>

                <ul>
                    <li> Account/profile management</li>
                    <li> College browsing & searching</li>
                    <li> College matching & ranking</li>
                    <li> College Event Management</li>
                    <li>Notifications Management</li>
                </ul>

            </div>
        </div>
    </div>

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










