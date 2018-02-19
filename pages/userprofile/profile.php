<?php
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
        <script src="<?php echo $controller->getHomeDir(); ?>resources/common.js"></script>
        <script src="<?php echo $controller->getHomeDir(); ?>resources/cleverMask.js"></script>
        <script src="javascript/profile.js"></script>
        <div class="container">
            <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <h2>MyProfile</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?php include $controller->getHomeDir() . Controller::MODULE_DIR . "pageassembly/profilenav/profilenav.php"; ?>
                </div>
                <div class="col-sm-4">
                    <form class="form-horizontal">
                        <div>
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <input id="firstName" type="text" value="<?php echo Controller::getLoggedInUser()->getFirstName(); ?>" placeholder="First name" class="form-control input-md">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <input id="lastName" type="text" value="<?php echo Controller::getLoggedInUser()->getLastName(); ?>" placeholder="Last name" class="form-control input-md">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                        <input id="email" type="email" value="<?php echo Controller::getLoggedInUser()->getEmail(); ?>" placeholder="Email address" class="form-control input-md">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                        <input id="altEmail" type="email" value="<?php echo Controller::getLoggedInUser()->getAltEmail(); ?>" placeholder="Alternate email address" class="form-control input-md">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-home"></i>
                                        </div>
                                        <input id="streetAddress" type="text" value="<?php echo Controller::getLoggedInUser()->getStreetAddress(); ?>" placeholder="Street Address" class="form-control input-md ">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-road"></i>
                                        </div>
                                        <input id="city" type="text" value="<?php echo Controller::getLoggedInUser()->getCity(); ?>" placeholder="City" class="form-control input-md ">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-globe"></i>
                                        </div>
                                        <select id="country" class="chosen-ones">
                                            <?php
                                            $dbc = new DatabaseConnection();
                                            $countries = $dbc->query("select multiple", "SELECT pkcountryid, idiso, nmname FROM tblcountry WHERE 1");
                                            //Could potentially instantiate a bunch of Country objects here, but with exception handling,
                                            //this slows the webpage down a _crazy_ amount (like by 3 seconds of load time; it's nuts, I know)
                                            $userCountry = $controller::getLoggedInUser()->getCountry()->getISO();
                                            foreach ($countries as $country) {
                                                if ($userCountry === $country["idiso"]) {
                                                    $selected = " selected";
                                                    $savedCountry = $country["pkcountryid"];
                                                } else {
                                                    $selected = "";
                                                }
                                                ?>
                                                <option value="<?php echo $country["idiso"]; ?>"<?php echo $selected; ?>><?php echo $country["nmname"]; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-globe"></i>
                                        </div>
                                        <div id="provinceLabel">
                                            <select id="province" class="chosen-ones">
                                                <?php
                                                $params = ["i", $savedCountry];
                                                $provinces = $dbc->query("select multiple", "SELECT idiso, nmname FROM tblprovince WHERE fkcountryid = ?", $params);
                                                //Could potentially instantiate a bunch of Country objects here, but with exception handling,
                                                //this slows the webpage down a _crazy_ amount (like by 3 seconds of load time; it's nuts, I know)
                                                $userProvince = Controller::getLoggedInUser()->getProvince()->getISO();
                                                foreach ($provinces as $province) {
                                                    if ($userProvince === $province["idiso"]) {
                                                        $selected = " selected";
                                                    } else {
                                                        $selected = "";
                                                    }
                                                    ?>
                                                    <option value="<?php echo $province["idiso"]; ?>"<?php echo $selected; ?>><?php echo $province["nmname"]; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-globe"></i>
                                        </div>
                                        <input id="postalCode" type="text" value="<?php echo Controller::getLoggedInUser()->getPostalCode(); ?>" placeholder="Postal code" class="form-control input-md ">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <input id="phoneNumber" type="tel" value="<?php echo Controller::getLoggedInUser()->getPhone(); ?>" placeholder="Phone number" class="form-control input-md">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-mortar-board"></i>
                                        </div>
                                        <input id="gradYear" type="number" value="<?php echo Controller::getLoggedInUser()->getGradYear(); ?>" min="1900" max="2100" placeholder="Graduation year" class="form-control input-md" data-clevermask="0000">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <a href="#" class="btn btn-success" id="updateContactInfo">
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