<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/19/2018
 * Time: 12:13 PM
 */
include "../../autoload.php";

$controller = $_SESSION["controller"] = new Controller("MyCollege");
$controller->initModuleDir();
$controller->processREQUEST();
$controller->checkPermissions($controller->userHasAccess([Permission::PERMISSION_STUDENT]));
/**
 * @var $student Student
 */
$student = Controller::getLoggedInUser();
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
                    <h2>Education</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?php include $controller->getHomeDir() . Controller::MODULE_DIR . "pageassembly/profilenav/profilenav.php"; ?>
                </div>
                <div class="col-md-4">
                    <form class="form-horizontal">
                        <div>
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-mortar-board"></i>
                                        </div>
                                        <input id="gpa" type="number" value="<?php echo Controller::getLoggedInUser()->getGPA(); ?>" placeholder="GPA" class="form-control input-md">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-mortar-board"></i>
                                        </div>
                                        <input id="act" type="number" value="<?php echo Controller::getLoggedInUser()->getACT(); ?>" placeholder="ACT composite score" class="form-control input-md">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-mortar-board"></i>
                                        </div>
                                        <input id="sat" type="number" value="<?php echo Controller::getLoggedInUser()->getSAT(); ?>" placeholder="SAT score" class="form-control input-md">
                                    </div>
                                </div>
                            </div>
                            <h5 style="text-align: center;">Did you take AP classes?</h5>
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-mortar-board"></i>
                                        </div>
                                        <input id="ap" type="checkbox" <?php if(Controller::getLoggedInUser()->isAP()) echo "checked"; ?> class="form-control input-md">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-money"></i>
                                        </div>
                                        <input id="income" type="number" value="<?php echo Controller::getLoggedInUser()->getHouseholdIncome(); ?>" placeholder="Household Income" class="form-control input-md">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input id="entry" type="number" value="<?php echo Controller::getLoggedInUser()->getDesiredCollegeEntry()->format("Y"); ?>" placeholder="What year would you like to start college?" class="form-control input-md">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input id="length" type="number" value="<?php echo Controller::getLoggedInUser()->getDesiredCollegeLength()->format("%y"); ?>" placeholder="Max years desired to be in college" class="form-control input-md">
                                    </div>
                                </div>
                            </div>
                            <h5 style="text-align: center;">Desired major</h5>
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-book"></i>
                                        </div>
                                        <select id="desiredMajor" class="chosen-ones">
                                            <?php
                                            $dbc = new DatabaseConnection();
                                            $majors = $dbc->query("select multiple", "SELECT pkmajorid, nmname FROM tblmajor WHERE 1 ORDER BY nmname ASC");
                                            //Could potentially instantiate a bunch of Major objects here, but with exception handling,
                                            //this slows the webpage down a _crazy_ amount (like by 3 seconds of load time; it's nuts, I know)
                                            $studentMajor = $student->getDesiredMajor()->getPkID();
                                            foreach ($majors as $major) {
                                                if ($studentMajor === $major["pkmajorid"]) {
                                                    $selected = " selected";
                                                    $savedMajor = $major["pkmajorid"];
                                                } else {
                                                    $selected = "";
                                                }
                                                ?>
                                                <option value="<?php echo $major["pkmajorid"]; ?>"<?php echo $selected; ?>><?php echo $major["nmname"]; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <h5 style="text-align: center;">Other preferred areas of study</h5>
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-book"></i>
                                        </div>
                                        <select id="preferredMajors" class="chosen-ones" multiple>
                                            <?php
                                            $preferredMajors = array_map(function($obj){ return $obj->getPkID(); },$student->getPreferredMajors());
                                            foreach ($majors as $major) {
                                                if (in_array($major["pkmajorid"],$preferredMajors)) {
                                                    $selected = " selected";
                                                } else {
                                                    $selected = "";
                                                }
                                                ?>
                                                <option value="<?php echo $major["pkmajorid"]; ?>"<?php echo $selected; ?>><?php echo $major["nmname"]; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
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