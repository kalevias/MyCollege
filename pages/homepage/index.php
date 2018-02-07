<?php
include "autoload.php";

$controller = $_SESSION["controller"] = new Controller("MyCollege");
$controller->initModuleDir();
$controller->processREQUEST();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>MyCollege</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo $controller->getHomeDir(); ?>pages/homepage/css/index.min.css" type="text/css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
    </head>
    <body>
        <?php include $controller->getHomeDir() . "pages/pageassembly/header/header.php"; ?>
        <div class="container">
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
                            <img src="<?php echo $controller->getHomeDir(); ?>pages/homepage/images/NWUni.jpg" alt="Los Angeles" style="width:100%;">
                            <div class="carousel-caption">
                                <h3>Northwestern University</h3>
                            </div>
                        </div>
                        <div class="item">
                            <img src="<?php echo $controller->getHomeDir(); ?>pages/homepage/images/IndianaUni.jpg" alt="Chicago" style="width:100%;">
                            <div class="carousel-caption">
                                <h3>Indiana University</h3>
                            </div>
                        </div>
                        <div class="item">
                            <img src="<?php echo $controller->getHomeDir(); ?>pages/homepage/images/WashUni.jpg" alt="New york" style="width:100%;">
                            <div class="carousel-caption">
                                <h3>Washington University</h3>
                            </div>
                        </div>
                        <div class="item">
                            <img src="<?php echo $controller->getHomeDir(); ?>pages/homepage/images/BrynMawrCollege.jpg" alt="New york" style="width:100%;">
                            <div class="carousel-caption">
                                <h3>Bryn Mawr College</h3>
                            </div>
                        </div>
                        <div class="item">
                            <img src="<?php echo $controller->getHomeDir(); ?>pages/homepage/images/UniOfChi.jpg" alt="New york" style="width:100%;">
                            <div class="carousel-caption">
                                <h3>University Of Chicago</h3>
                            </div>
                        </div>
                        <div class="item">
                            <img src="<?php echo $controller->getHomeDir(); ?>pages/homepage/images/WellesleyCollege.jpg" alt="New york" style="width:100%;">
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
                        <p class="w3-text-grey">
                            MyCollege is your one stop shop for all your college information. We care about your
                            education and hope to match you with the college of your dreams. Whether you need
                            information about what a school has to offer, or their scholarship opportunities – MyCollege
                            provides all that information for you in a nice simple way.
                        </p>
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
        </div>
    </body>
</html>










