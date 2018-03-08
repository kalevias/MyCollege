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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
<link rel="stylesheet" href="css/college.min.css">
<body>
<img src="/mycollege/files/7.jpg" id="bg" alt="">

<?php include $controller->getHomeDir() . Controller::MODULE_DIR . "/pageassembly/header/header.php"; ?>
<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu"
     id="myOverlay"></div>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main" style="margin-left:200px">


    <div class="borderStyle">


        <div class="w3-row w3-padding-64">

            <div class="w3-twothird w3-container">
                <h1 class="w3-text-teal"><?php echo $college->getName(); ?></h1>

            </div>
            <table>

                <tbody>
                <tr>
                    <td><i class="fa fa-globe fa-lg"></i> <?php echo $college->getProvince()->getName().", ". $college->getCity(); ?></td>
                    <td>Type: <?php echo $college->getType(); ?></td>
                    <td>Setting: <?php echo $college->getSetting(); ?></td>
                </tr>
                <tr>
                    <td><i class="fas fa-male fa-lg"></i><?php echo (1-$college->getWomenRatio())*100 . "%"; ?>
                        <i class="fas fa-female fa-lg"></i><?php echo ($college->getWomenRatio())*100 . "%"; ?>
                    </td>
                    <td>Number of Students: <?php echo $college->getStudentCount(); ?></td>
                    <td><i class="far fa-money-bill-alt fa-lg"></i> In-State: $<?php echo $college->getTuitionIn(); ?><br>
                        <i class="far fa-money-bill-alt fa-lg"></i> Out of State: $<?php echo $college->getTuitionOut(); ?>
                    </td>

                </tr>
                <tr>
                    <td>Acceptance Rate: <?php echo ($college->getAcceptRate())*100 . "%"; ?></td>
                    <td><i class="fas fa-first-aid fa-lg"></i>Average Finalcial Aid Package: <?php echo $college->getFinAid(); ?></td>
                    <td>Number of Professors: <?php echo $college->getProfCount(); ?></td>

                </tr>


                </tbody>
            </table>


            <div class="w3-third w3-container">
                <p class="w3-border w3-padding-large w3-padding-64 w3-center">Picture or logo of school</p>
                <p>List of Sports</p>
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
    <h4 class="w3-bar-item"><b>Links to school website, etc</b></h4>
    <a class="w3-bar-item w3-button w3-hover-black" href="#">Link</a>
    <a class="w3-bar-item w3-button w3-hover-black" href="#">Link</a>
    <a class="w3-bar-item w3-button w3-hover-black" href="#">Link</a>
    <a class="w3-bar-item w3-button w3-hover-black" href="#">Link</a>
</nav>
</body>
</html>