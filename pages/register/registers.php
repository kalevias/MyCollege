<?php

include "../../autoload.php";

$controller = $_SESSION["controller"] = new Controller("Student Registration");
$controller->initModuleDir();
$controller->processREQUEST();

$registerFail = isset($_SESSION["registerStudentFail"]) ? $_SESSION["registerStudentFail"] : false;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Student Sign Up</title>
        <link rel="stylesheet" href="css/register.min.css" type="text/css">
        <link rel="stylesheet" href="<?php echo $controller->getHomeDir(); ?>resources/jslib/chosen/chosen.min.css" type="text/css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="<?php echo $controller->getHomeDir(); ?>resources/jslib/chosen/chosen.jquery.min.js"></script>
        <script src="javascript/registers.js"></script>
    </head>
    <body>
        <img class="bg-image" src="css/UniOfChi.jpg">
        <div>
            <?php
            if (isset($registerFail) and $registerFail) {
                ?>
                <h2>
                    Erroneous input detected. Please try again. The email you registered with may have already been
                    taken
                </h2>
                <?php
            }
            ?>
        </div>
        <div class="rcorners2">
            <form action="" method="POST">
                <h1>Student Sign Up</h1>
                <input type="text" placeholder="First Name" name="firstName">
                <input type="text" placeholder="Last Name" name="lastName">
                <input title="Please enter a valid email address using the '@' symbol" type="email" placeholder="Email Address" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                <input title="Please enter a valid email address using the '@' symbol" type="email" placeholder="Email Address" name="altEmail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                <input type="text" placeholder="Street Address" name="streetAddress">
                <input type="text" placeholder="City" name="city">
                <label>
                    Country
                    <select name="country" id="country" class="chosen-ones">
                        <?php
                        $dbc = new DatabaseConnection();
                        $countries = $dbc->query("select multiple", "SELECT pkcountryid FROM tblcountry WHERE 1");
                        /**
                         * @var Country[] $countryObjects
                         */
                        $countryObjects = [];
                        foreach ($countries as $country) {
                            try {
                                $countryObjects[] = new Country($country["pkcountryid"], Country::MODE_DbID);
                            } catch (Exception $e) {
                                continue;
                            }
                        }
                        foreach ($countryObjects as $countryObject) {
                            ?>
                            <option value="<?php echo $countryObject->getISO() ?>"><?php echo $countryObject->getName() ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </label>
                <label id="provinceLabel">
                    Province
                    <?php //province dropdown gets inserted here! ?>
                </label>
                <input type="text" placeholder="Zip" name="zip">
                <input title="Please enter a phone number in the form: XXXXXXXXXX" type="text" placeholder="Phone Number" name="phoneNumber" pattern="[0-9]{10}">
                <input type="number" min="1900" max="2100" placeholder="Graduation Year" name="gradYear">
                <input title="Password must contain at least 6 characters, including UPPER/lowercase and numbers" type="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" placeholder="Password" name="password">
                <input type="password" placeholder="Confirm Password" name="confirmPassword">
                <input type="hidden" value="registerStudent" name="requestType">
                <input type="submit" value="Sign Up">
            </form>
        </div>
    </body>
</html>