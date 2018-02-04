<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/4/2018
 * Time: 2:39 PM
 */
?>

<!-- Navbar -->
<link rel="stylesheet" href="<?php echo $homedir; ?>pages/pageassembly/header/css/header.min.css" type="text/css">
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <a href="<?php echo $homedir; ?>" class="navbar-nav navbar-default">MyCollege</a>
                </li>
                <li>
                    <a href="<?php echo $homedir; ?>pages/search/search.php?q=" class="navbar-nav navbar-default">Schools</a>
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
                if ($loggedIn) {
                    ?>
                    <form action="" method="POST">
                        <input type="hidden" value="logout" name="requestType">
                        <input type="submit" class="navbar-nav navbar-default" value="Log Out">
                    </form>
                    <li>
                        <a href="#myModal" data-toggle="modal" data-target="#myModal">
                            <span class="glyphicon glyphicon-search"></span>
                        </a>
                    </li>
                    <?php
                } else {
                ?>
                <li>
                    <a href="<?php echo $homedir; ?>pages/login/login.php" class="navbar-nav navbar-default">Login</a>
                </li>
                <li>
                    <div class="navbar-nav navbar-default dropdown">
                        <button class="navbar-nav navbar-default dropdown-toggle" id="registermenu" type="button" data-toggle="dropdown">
                            Register
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="registermenu">
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="<?php echo $homedir; ?>pages/register/registers.php">Students</a>
                            </li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="<?php echo $homedir; ?>pages/register/registercr.php">College
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
            </ul>
            <?php
            }
            ?>
        </div>
    </div>
</nav>
<!-- Modal -->
<div class="modal" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal2-content">
            <br>
            <form action="<?php echo $homedir; ?>pages/search/search.php" class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="search">Search</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="search" placeholder="Enter Text Here" name="q">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" value="Enter">
                </div>
        </div>
    </div>
</div>