<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/4/2018
 * Time: 2:39 PM
 */
?>

<!-- Navbar -->
<link rel="stylesheet" href="<?php echo $controller->getHomeDir(); ?>pages/pageassembly/header/css/header.min.css" type="text/css">
<script src="<?php echo $controller->getHomeDir(); ?>resources/common.js"></script>
<script src="<?php echo $controller->getHomeDir(); ?>pages/pageassembly/header/javascript/header.js"></script>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <a href="<?php echo $controller->getHomeDir(); ?>" class="navbar-nav navbar-default">MyCollege</a>
                </li>
                <li>
                    <a href="<?php echo $controller->getHomeDir(); ?>pages/search/search.php" class="navbar-nav navbar-default">Schools</a>
                </li>
                <li>
                    <a href="#" class="navbar-nav navbar-default">Scholarships</a>
                </li>
                <li>
                    <a href="#" class="navbar-nav navbar-default">Events</a>
                </li>
                <li>
                    <a href="#" class="navbar-nav navbar-default">More</a>
                </li>
                <?php
                if ($controller::isUserLoggedIn()) {
                    ?>
                    <li>
                        <input type="button" class="navbar-nav navbar-default" value="Log Out" id="logoutButton">
                    </li>
                    <li>
                        <a href="#myModal" data-toggle="modal" data-target="#myModal">
                            <span class="glyphicon glyphicon-search"></span>
                        </a>
                    </li>
                    <?php
                } else {
                    ?>
                    <li>
                        <a href="<?php echo $controller->getHomeDir(); ?>pages/login/login.php" class="navbar-nav navbar-default">Login</a>
                    </li>
                    <li>
                        <div class="navbar-nav navbar-default dropdown">
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