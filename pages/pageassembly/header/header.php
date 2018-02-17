<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/4/2018
 * Time: 2:39 PM
 */
?>

<!-- Navbar -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $controller->getHomeDir(); ?>pages/pageassembly/header/css/header.min.css" type="text/css">

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="<?php echo $controller->getHomeDir(); ?>resources/common.js"></script>
<script src="<?php echo $controller->getHomeDir(); ?>pages/pageassembly/header/javascript/header.js"></script>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <ul class="nav navbar-nav navbar-left">
                <li class="navbar-nav navbar-default">
                    <a href="<?php echo $controller->getHomeDir(); ?>">MyCollege</a>
                </li>
                <li class="navbar-nav navbar-default">
                    <a href="<?php echo $controller->getHomeDir(); ?>pages/search/search.php">Schools</a>
                </li>
                <li class="navbar-nav navbar-default">
                    <a href="#">Scholarships</a>
                </li>
                <li class="navbar-nav navbar-default">
                    <a href="#">Events</a>
                </li>
                <li class="navbar-nav navbar-default">
                    <a href="#">More</a>
                </li>
                <?php
                if ($controller::isUserLoggedIn()) {
                    ?>
                    <li class="navbar-nav navbar-default">
                        <div class="dropdown">
                            <button class="navbar-nav navbar-default dropdown-toggle" id="accountmenu" type="button" data-toggle="dropdown">
                                My Account
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $controller->getHomeDir();?>pages/userprofile/profile.php">Profile</a>
                                </li>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="" id="logoutButton">Log Out</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="navbar-nav navbar-default">
                        <a href="#myModal" data-toggle="modal" data-target="#myModal">
                            <span class="glyphicon glyphicon-search"></span>
                        </a>
                    </li>
                    <?php
                } else {
                    ?>
                    <li class="navbar-nav navbar-default">
                        <a href="<?php echo $controller->getHomeDir(); ?>pages/login/login.php">Login</a>
                    </li>
                    <li class="navbar-nav navbar-default">
                        <div class="dropdown">
                            <button class="navbar-nav navbar-default dropdown-toggle" id="registermenu" type="button" data-toggle="dropdown">
                                Register
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="registermenu">
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $controller->getHomeDir(); ?>pages/register/registers.php">Students</a>
                                </li>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $controller->getHomeDir(); ?>pages/register/registercr.php">College
                                        Reps</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#myModal" data-toggle="modal" data-target="#myModal">
                            <span class="glyphicon glyphicon-search"></span>
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<?php include $controller->getHomeDir() . "pages/pageassembly/alerts/alerts.php"; ?>

<!--Modal: Subscription From-->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog cascading-modal" role="document">
        <!--Content-->
        <div class="modal-content">
            <form action="<?php echo $controller->getHomeDir(); ?>pages/search/search.php" class="form-horizontal" role="form">
                <!--Header-->
                <div class="modal-header light-blue darken-3 white-text">
                    <h4 class="title"><i class="fa fa-search"></i>Search</h4>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body mb-0">
                    <div class="md-form form-sm">
                        <input type="text" id="form27" class="form-control">
                    </div>
                    <div class="text-center mt-1-half">
                        <button class="btn btn-info mb-1">Submit <i class="fa fa-check ml-1"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <!--/.Content-->
    </div>
</div>
<!--Modal: Subscription From-->