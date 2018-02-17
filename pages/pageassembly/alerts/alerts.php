<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/9/2018
 * Time: 8:35 PM
 */

$localErrors = isset($_SESSION["localErrors"]) ? $_SESSION["localErrors"] : [];
$localWarnings = isset($_SESSION["localWarnings"]) ? $_SESSION["localWarnings"] : [];
$localNotifications = isset($_SESSION["localNotifications"]) ? $_SESSION["localNotifications"] : [];
?>
<script type="text/javascript" src="<?php echo $controller->getHomeDir(); ?>pages/pageassembly/alerts/javascript/alerts.js"></script>
<link rel="stylesheet" href="<?php echo $controller->getHomeDir(); ?>pages/pageassembly/alerts/css/alerts.min.css" type="text/css">
<div id="alerts">
    <div id="errors">
        <?php
        for ($i = 0; $i < count($localErrors); $i++) { ?>
            <div>
                    <span>
                        <img class="remove-alert" src="<?php echo $controller->getHomeDir() . "resources/images/cancel.png"; ?>" title="Dismiss">
                    </span>
                <img src="<?php echo $controller->getHomeDir() . "resources/images/exclamation.png"; ?>">
                <?php echo $localErrors[$i]; ?>
            </div>
            <?php
            unset($_SESSION["localErrors"][$i]);
        } ?>
    </div>
    <div id="warnings">
        <?php
        for ($i = 0; $i < count($localWarnings); $i++) { ?>
            <div>
                    <span>
                        <img class="remove-alert" src="<?php echo $controller->getHomeDir() . "resources/images/cancel.png"; ?>" title="Dismiss">
                    </span>
                <img src="<?php echo $controller->getHomeDir() . "resources/images/error.png"; ?>">
                <?php echo $localWarnings[$i]; ?>
            </div>
            <?php
            unset($_SESSION["localWarnings"][$i]);
        } ?>
    </div>
    <div id="notifications">
        <?php
        for ($i = 0; $i < count($localNotifications); $i++) { ?>
            <div>
                    <span>
                        <img class="remove-alert" src="<?php echo $controller->getHomeDir() . "resources/images/cancel.png"; ?>" title="Dismiss">
                    </span>
                <img src="<?php echo $controller->getHomeDir() . "resources/images/information.png"; ?>">
                <?php echo $localNotifications[$i]; ?>
            </div>
            <?php
            unset($_SESSION["localNotifications"][$i]);
        } ?>
    </div>
</div>
