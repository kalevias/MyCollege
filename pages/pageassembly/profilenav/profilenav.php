<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/19/2018
 * Time: 12:14 PM
 */
?>
<div class="profileNav">
    <ul class="nav nav-pills nav-stacked">
        <li>
            <a href="profile.php">Contact Information</a>
        </li>
        <?php
        try {
            $isStudent = $controller::getLoggedInUser()->hasPermission(new Permission(Permission::PERMISSION_STUDENT));
        } catch (Exception $e) {
            $isStudent = false;
        }
        if ($isStudent) {
            ?>
            <li>
                <a href="eduprofile.php">Education</a>
            </li>
            <li>
                <a href="questions.php">College Preferences</a>
            </li>
            <?php
        }
        ?>
    </ul>
</div>