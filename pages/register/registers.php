<?php

include "../../autoload.php";

$controller = $_SESSION["controller"] = new Controller("Student Registration");
$controller->initModuleDir();
$controller->processREQUEST();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Student Sign Up</title>
        <link rel="stylesheet" href="css/register.min.css" type="text/css">
        <link rel="stylesheet" href="<?php echo $controller->getHomeDir(); ?>resources/jslib/chosen/chosen.min.css" type="text/css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="<?php echo $controller->getHomeDir(); ?>resources/jslib/chosen/chosen.jquery.min.js"></script>
        <script src="<?php echo $controller->getHomeDir(); ?>resources/common.js"></script>
        <script src="<?php echo $controller->getHomeDir(); ?>resources/cleverMask.js"></script>
        <script src="javascript/registers.js"></script>
    </head>
    <body>
        <img class="bg-image" src="css/UniOfChi.jpg">
        <?php
        include $controller->getHomeDir() . "pages/pageassembly/alerts/alerts.php";
        ?>
        <div class="rcorners2">
            <h1>Student Sign Up</h1>
            <input id="firstName" type="text" placeholder="First Name" required>
            <input id="lastName" type="text" placeholder="Last Name" required>
            <input id="email" type="email" placeholder="your.email@example.com" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
            <input id="altEmail" type="email" placeholder="other.email@example.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
            <input id="streetAddress" type="text" placeholder="Street Address">
            <input id="city" type="text" placeholder="City">
            <label>
                Country
                <select id="country" class="chosen-ones">
                    <?php
                    $dbc = new DatabaseConnection();
                    $countries = $dbc->query("select multiple", "SELECT idiso, nmname FROM tblcountry WHERE 1");
                    //Could potentially instantiate a bunch of Country objects here, but with exception handling,
                    //this slows the webpage down a _crazy_ amount (like by 3 seconds of load time; it's nuts, I know)
                    foreach ($countries as $country) {
                        ?>
                        <option value="<?php echo $country["idiso"]; ?>"><?php echo $country["nmname"]; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </label>
            <label id="provinceLabel">
                Province
                <?php //province dropdown gets inserted here! ?>
            </label>
            <input id="postalCode" type="text" placeholder="Postal code" data-clevermask="00000">
            <input id="phoneNumber" type="text" placeholder="Phone Number" data-clevermask="(000) 000-0000">
            <input id="gradYear" type="number" min="1900" max="2100" placeholder="Graduation Year" data-clevermask="0000">
            <input id="password" type="password" title="Password must contain at least 6 characters, including UPPER/lowercase and numbers" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" placeholder="Password">
            <input id="confirmPassword" type="password" placeholder="Confirm Password">
            <input id="registerButton" type="submit" value="Sign Up">
        </div>
    </body>
</html>