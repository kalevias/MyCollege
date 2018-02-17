<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/9/2018
 * Time: 8:25 PM
 */

include_once "../../autoload.php";

if (isset($_POST["requestType"]) and $_POST["requestType"] === "getprovinces") {
    try {
        $country = new Country($_POST["country"], Country::MODE_ISO);
    } catch (Exception $e) {
        $_SESSION["localerrors"][] = "Invalid country selected";
    }
    $provinces = $country->getProvinces();
    $output = [];

    foreach ($provinces as $province) {
        $output[] = [
            "iso" => $province->getISO(),
            "name" => $province->getName()
        ];
    }
    echo json_encode($output);
}