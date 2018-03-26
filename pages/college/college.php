<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/21/2018
 * Time: 9:00 PM
 */
include "../../autoload.php";
$controller = $_SESSION["controller"] = new Controller("MyCollege");
$controller->initModuleDir();
$controller->processREQUEST();
//TODO: move this code into the controller class's processGET function
if (isset($_GET["c"]) and is_numeric($_GET["c"])) {
    $college = new College($_GET["c"]);
} else {
    $_SESSION["localErrors"][] = "Error: Unable to query for a college; please try again";
    header("Location: " . $controller->getHomeDir());
    exit;
}
?>
<!DOCTYPE html>
<html>
    <title>MyCollege</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="css/college.min.css">
    <body>
        <img src="/mycollege/files/<?php echo $college->getPkID(); ?>.jpg" id="bg" alt="">
        <?php include $controller->getHomeDir() . Controller::MODULE_DIR . "/pageassembly/header/header.php"; ?>
        <!-- Overlay effect when opening sidebar on small screens -->
        <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu"
             id="myOverlay"></div>

        <!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
        <div class="w3-main" id="main">
            <div class="w3-row w3-padding-64">
                <div class="w3-container">
                    <h1 class="w3-text-teal"><?php echo $college->getName(); ?></h1>
                </div>
                <div>
                    <?php if (Controller::isUserLoggedIn() and get_class(Controller::getLoggedInUser()) == "Student") {
                        if (($rating = $college->getRating(Controller::getLoggedInUser())) === false) {
                            $output = "N/A";
                        } else {
                            $output = ((int)($rating * 100));
                        }
                        switch (true) {
                            case $output <= 12:
                                $ratingStyle = "1";
                                break;
                            case $output <= 25:
                                $ratingStyle = "2";
                                break;
                            case $output <= 37:
                                $ratingStyle = "3";
                                break;
                            case $output <= 50:
                                $ratingStyle = "4";
                                break;
                            case $output <= 62:
                                $ratingStyle = "5";
                                break;
                            case $output <= 75:
                                $ratingStyle = "6";
                                break;
                            case $output <= 87:
                                $ratingStyle = "7";
                                break;
                            case $output <= 100:
                                $ratingStyle = "8";
                                break;
                            default:
                                $ratingStyle = "na";
                        }
                        ?>
                        <div class="cr-<?php echo $ratingStyle; ?>">
                            <div class="collegeRating cr-<?php echo $ratingStyle; ?>" title="See Scorecard" data-id="<?php echo $college->getPkID(); ?>">
                                <a href="#myModal2" data-toggle="modal" data-target="#myModal2">
                                    <?php echo $output; ?>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="w3-container">
                    <table>
                        <tbody>
                        <tr>
                            <td>
                                <i class="fa fa-globe fa-lg"></i> <?php echo $college->getCity() . ", " . $college->getProvince()->getName(); ?>
                            </td>
                            <td><?php echo $college->getType(); ?></td>
                            <td><?php echo $college->getSetting(); ?></td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fa fa-male fa-lg"></i><?php echo (1 - $college->getWomenRatio()) * 100 . "%"; ?>
                                <i class="fa fa-female fa-lg"></i><?php echo ($college->getWomenRatio()) * 100 . "%"; ?>
                            </td>
                            <td>Students: <?php echo $college->getStudentCount(); ?></td>
                            <td><i class="fa fa-money fa-lg"></i> In-State:
                                $<?php echo $college->getTuitionIn(); ?> / year<br>
                                <i class="fa fa-money fa-lg"></i> Out of State:
                                $<?php echo $college->getTuitionOut(); ?> / year
                            </td>
                        </tr>
                        <tr>
                            <td>Acceptance Rate: <?php echo ($college->getAcceptRate()) * 100 . "%"; ?></td>
                            <td><i class="fa fa-medkit fa-lg"></i>
                                Mean Financial Aid: $<?php echo $college->getFinAid(); ?></td>
                            <td>Professors: <?php echo $college->getProfCount(); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="w3-container">
                    <table>
                        <thead>
                        <tr>
                            <th colspan="3">Campus Services</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Health services:
                                <i class="fa <?php echo($college->hasHealthCenter() ? "fa-check-square-o" : "fa-square-o"); ?>"></i>
                            </td>
                            <td>Counseling services:
                                <i class="fa <?php echo($college->hasCounseling() ? "fa-check-square-o" : "fa-square-o"); ?>"></i>
                            </td>
                            <td>Legal services:
                                <i class="fa <?php echo($college->hasLegal() ? "fa-check-square-o" : "fa-square-o"); ?>"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>Library:
                                <i class="fa <?php echo($college->hasLibrary() ? "fa-check-square-o" : "fa-square-o"); ?>"></i>
                            </td>
                            <td>Recreation center:
                                <i class="fa <?php echo($college->hasRecCenter() ? "fa-check-square-o" : "fa-square-o"); ?>"></i>
                            </td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                    <hr style="border-top: none;">
                    <table>
                        <thead>
                        <tr>
                            <th colspan="3">Housing</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>On-campus dorms:
                                <i class="fa <?php echo($college->hasDorms() ? "fa-check-square-o" : "fa-square-o"); ?>"></i>
                            </td>
                            <td>On-campus apartments:
                                <i class="fa <?php echo($college->hasApartments() ? "fa-check-square-o" : "fa-square-o"); ?>"></i>
                            </td>
                            <td>Meal plan:
                                <i class="fa <?php echo($college->hasMealPlan() ? "fa-check-square-o" : "fa-square-o"); ?>"></i>
                            </td>
                        </tr>
                        <tr>
                            <td>Choose roommates:
                                <i class="fa <?php echo($college->hasRoommatesChoosable() ? "fa-check-square-o" : "fa-square-o"); ?>"></i>
                            </td>
                            <td><?php if (!is_null($college->getRoomCost()) or !is_null($college->getBoardCost())) { ?>
                                    Room & board cost: $
                                    <?php echo $college->getRoomCost() + $college->getBoardCost();
                                } ?>
                            </td>
                            <td>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3>Majors</h3>
                            <?php if (count($college->getMajors()) >= 1) { ?>
                                <table class="table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Vocational</th>
                                        <th>Associates'</th>
                                        <th>Bachelors'</th>
                                        <th>Masters'</th>
                                        <th>Doctorates'</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($college->getMajors() as $major) { ?>
                                        <tr>
                                            <td><?php echo $major->getName(); ?></td>
                                            <td>
                                                <i class="fa <?php echo($major->isVocational() ? "fa-check-square-o" : "fa-square-o"); ?>"></i>
                                            </td>
                                            <td>
                                                <i class="fa <?php echo($major->isAssociate() ? "fa-check-square-o" : "fa-square-o"); ?>"></i>
                                            </td>
                                            <td>
                                                <i class="fa <?php echo($major->isBachelor() ? "fa-check-square-o" : "fa-square-o"); ?>"></i>
                                            </td>
                                            <td>
                                                <i class="fa <?php echo($major->isMaster() ? "fa-check-square-o" : "fa-square-o"); ?>"></i>
                                            </td>
                                            <td>
                                                <i class="fa <?php echo($major->isDoctoral() ? "fa-check-square-o" : "fa-square-o"); ?>"></i>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            <?php } else { ?>
                                No majors found
                            <?php } ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3>Sports</h3>
                            <?php if (count($college->getSports()) >= 1) { ?>
                                <table class="table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Club?</th>
                                        <th>Team?</th>
                                        <th>Scholarships?</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($college->getSports() as $sport) { ?>
                                        <tr>
                                            <td><?php echo $sport->getName(); ?></td>
                                            <td><?php echo($sport->isWomen() ? "Women" : "Men"); ?></td>
                                            <td>
                                                <i class="fa <?php echo($sport->isClub() ? "fa-check-square-o" : "fa-square-o"); ?>"></i>
                                            </td>
                                            <td>
                                                <i class="fa <?php echo($sport->isTeam() ? "fa-check-square-o" : "fa-square-o"); ?>"></i>
                                            </td>
                                            <td>
                                                <i class="fa <?php echo($sport->isScholarship() ? "fa-check-square-o" : "fa-square-o"); ?>"></i>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            <?php } else { ?>
                                No sports found
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN -->
        </div>
        <!-- Sidebar -->
        <nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" id="mySidebar">
            <a href="javascript:void(0)" onclick="w3_close()"
               class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
                <i class="fa fa-remove"></i>
            </a>
            <h4 class="w3-bar-item"><b>Helpful Links</b></h4>
            <a class="w3-bar-item w3-button w3-hover-black scholarshipLink" href="<?php echo $controller->getHomeDir() . Controller::MODULE_DIR . "scholarships/scholarships.php?c=" . $college->getPkID(); ?>"><?php echo "Scholarships"; ?></a>
            <?php foreach ($college->getWebsites() as $website) { ?>
                <a class="w3-bar-item w3-button w3-hover-black" href="<?php echo $website->getURL(); ?>"><?php echo $website->getName(); ?></a>
            <?php } ?>
        </nav>
        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal" role="document">
                <div class="modal-content">
                    <h1>Scorecard</h1>
                    <table>
                        <thead>
                        <tr>
                            <th>Max points</th>
                            <th>Real points</th>
                            <th>Reason</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $scorecard = CollegeRanker::scoreCollege($controller::getLoggedInUser(), $college, true);
                        $maxsum = 0;
                        $scoresum = 0;
                        foreach ($scorecard as $score) {
                            $maxsum += $score["max"];
                            $scoresum += $score["score"];
                            ?>
                            <tr>
                                <td><?php echo $score["max"]; ?></td>
                                <td><?php echo $score["score"]; ?></td>
                                <td><?php echo $score["desc"]; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td colspan="3">Totals</td>
                        </tr>
                        <tr>
                            <td><?php echo $maxsum; ?></td>
                            <td><?php echo $scoresum; ?></td>
                            <td><?php echo (int) (($scoresum / ($maxsum * 1.0)) * 100); ?>% - <?php echo (((int) (($scoresum / ($maxsum * 1.0)) * 100)) - ((int) ($college->getRating(Controller::getLoggedInUser()) *100))); ?>% (adjustments) = <?php echo (int) ($college->getRating(Controller::getLoggedInUser()) * 100); ?>%</td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                </div>
            </div>
        </div>
    </body>
</html>