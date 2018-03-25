<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 3/25/2018
 * Time: 4:48 PM
 */

include_once "../../autoload.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$controller = $_SESSION["controller"];

if (isset($_POST["requestType"]) and $_POST["requestType"] === "getscorecard") {
    $output = [];
    try {
        $college = new College($_POST["college"]);

        $output = CollegeRanker::scoreCollege($controller::getLoggedInUser(), $college, true);

    } catch (Exception $e) {
        $_SESSION["localErrors"][] = "Invalid country selected";
    }
    echo json_encode($output);
}