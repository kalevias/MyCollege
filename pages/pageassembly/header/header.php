<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/4/2018
 * Time: 2:39 PM
 */
?>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $controller->getHomeDir() . Controller::MODULE_DIR; ?>pageassembly/header/css/header.min.css" type="text/css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="<?php echo $controller->getHomeDir(); ?>resources/common.js"></script>
    <script src="<?php echo $controller->getHomeDir() . Controller::MODULE_DIR; ?>pageassembly/header/javascript/header.js"></script>
    <div id="siteHeader">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#siteNav">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo $controller->getHomeDir(); ?>">MyCollege</a>
                </div>
                <div class="collapse navbar-collapse" id="siteNav">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="<?php echo $controller->getHomeDir() . Controller::MODULE_DIR; ?>search/search.php">Schools</a>
                        </li>
                        <li>
                            <a href="#">Scholarships</a>
                        </li>
                        <li>
                            <a href="#">Events</a>
                        </li>
                        <li>
                            <a href="#">More</a>
                        </li>
                        <li>
                            <a href="#myModal" data-toggle="modal" data-target="#myModal">
                                <span class="glyphicon glyphicon-search"></span>
                            </a>
                        </li>
                    </ul>
                    <?php
                    if ($controller::isUserLoggedIn()) {
                        ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <div class="dropdown">
                                    <button class="navbar-nav navbar-default dropdown-toggle" id="accountmenu" type="button" data-toggle="dropdown">
                                        My Account
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="<?php echo $controller->getHomeDir() . Controller::MODULE_DIR; ?>userprofile/profile.php">Profile</a>
                                        </li>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="" id="logoutButton">Log Out</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        <?php
                    } else {
                        ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="<?php echo $controller->getHomeDir() . Controller::MODULE_DIR; ?>login/login.php">Login</a>
                            </li>
                            <li>
                                <div class="dropdown">
                                    <button class="navbar-nav navbar-default dropdown-toggle" id="registermenu" type="button" data-toggle="dropdown">
                                        Register
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="registermenu">
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="<?php echo $controller->getHomeDir() . Controller::MODULE_DIR; ?>register/registers.php">Students</a>
                                        </li>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="<?php echo $controller->getHomeDir() . Controller::MODULE_DIR; ?>register/registercr.php">College
                                                Reps</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </nav>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal" role="document">
                <div class="modal-content">
                    <form action="<?php echo $controller->getHomeDir() . Controller::MODULE_DIR; ?>search/search.php" class="form-horizontal" role="form">
                        <div class="modal-header light-blue darken-3 white-text">
                            <h4 class="title"><i class="fa fa-search"></i>Search</h4>
                            <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
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
            </div>
        </div>
    </div>
<?php include $controller->getHomeDir() . Controller::MODULE_DIR . "pageassembly/alerts/alerts.php"; ?>