<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/21/2018
 * Time: 4:15 PM
 */

include "../../autoload.php";

$controller = $_SESSION["controller"] = new Controller("MyCollege");
$controller->initModuleDir();
$controller->processREQUEST();
$controller->checkPermissions($controller->userHasAccess());
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>MyCollege</title>

        <link rel="stylesheet" href="<?php echo $controller->getHomeDir(); ?>resources/jslib/chosen/chosen.min.css" type="text/css">
        <link rel="stylesheet" href="css/profile.min.css" type="text/css">
    </head>
    <body>
        <?php include $controller->getHomeDir() . Controller::MODULE_DIR . "/pageassembly/header/header.php"; ?>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <script src="<?php echo $controller->getHomeDir(); ?>resources/jslib/chosen/chosen.jquery.min.js"></script>
        <script src="<?php echo $controller->getHomeDir(); ?>resources/cleverMask.js"></script>
        <script src="javascript/eduprofile.js"></script>
        <div class="container">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <h2>College Preferences</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?php include $controller->getHomeDir() . Controller::MODULE_DIR . "pageassembly/profilenav/profilenav.php"; ?>
                </div>
                <div class="col-md-4">
                    <form class="form-horizontal">
                        <div>
                            Todo: add in questions and whatnot here!
                            <div class="form-group">
                                <div>
                                    <a href="#" class="btn btn-success" id="updateEduProfile">
                                        <span class="glyphicon glyphicon-thumbs-up"></span>
                                        Update
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>