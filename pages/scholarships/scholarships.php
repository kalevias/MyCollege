
<?php
include "../../autoload.php";

$controller = $_SESSION["controller"] = new Controller("MyCollege");
$controller->initModuleDir();
$controller->processREQUEST("sc");

$query = $controller->getLastGETRequest()["input"]["query"];
$size = $controller->getLastGETRequest()["input"]["size"];
$tuition = $controller->getLastGETRequest()["input"]["tuition"];
$sat = $controller->getLastGETRequest()["input"]["sat"];
$dist = $controller->getLastGETRequest()["input"]["dist"];
$dif = $controller->getLastGETRequest()["input"]["dif"];
$schools = $controller->getLastGETRequest()["output"];
$isStudent = Controller::isUserLoggedIn() and get_class(Controller::getLoggedInUser()) == "Student";
?>
<!DOCTYPE html>
<html>
<head>
    <title>MyCollege</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Rammetto+One" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $controller->getHomeDir(); ?>pages/scholarships/css/scholarships.min.css" type="text/css">
</head>
<body>
<?php include $controller->getHomeDir() . "pages/pageassembly/header/header.php"; ?>
<script src="javascript/scholarships.js"></script>
<div class="container-fluid">
    <div class="col-lg-9 main container-fluid">
            <h1 class="page-header">Search Results</h1>
            <?php
            /**
             * @var $schools College[]
             */
            if ($schools) {
                $styles = " background-size: cover; background-repeat: no-repeat; background-position: center;";
                foreach ($schools as [$school, $rating]) { ?>
                    <div class="row">
                        <div class="placeholders col-lg-<?php echo($isStudent ? 11 : 12); ?>" style="background-image: linear-gradient(to bottom, rgba(255,255,255,0.6) 0%,rgba(255,255,255,0.6) 100%), url('<?php echo $controller->getHomeDir() . "files/" . $school->getPkID() . ".jpg"; ?>');<?php echo $styles; ?>">
                            <div>
                                <h3 data-id="<?php echo $school->getPkID(); ?>"><?php echo $school->getName(); ?></h3>
                                <dl>
                                    <?php echo $school->getCity() . ", " . $school->getProvince()->getName(); ?>
                                    | <?php echo $school->getStudentCount(); ?>
                                    students
                                </dl>
                            </div>
                        </div>
                        <?php if ($isStudent) {
                            if ($rating === false) {
                                $output = "N/A";
                            } else {
                                $output = ((int) ($rating * 100));
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
                            <div class="col-lg-1 cr-<?php echo $ratingStyle; ?>">
                                <div class="collegeRating cr-<?php echo $ratingStyle; ?>">
                                    <?php echo $output; ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php }
            } else { ?>
                <h2>No schools found</h2>
            <?php } ?>
</body>
</html>
<?php unset($_GET); ?>
