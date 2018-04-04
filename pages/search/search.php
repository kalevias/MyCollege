<?php
include "../../autoload.php";

$controller = $_SESSION["controller"] = new Controller("MyCollege");
$controller->initModuleDir();
$controller->processREQUEST("searchCollege");

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
            <link rel="stylesheet" href="<?php echo $controller->getHomeDir(); ?>pages/search/css/search.min.css" type="text/css">
        </head>
        <body>
            <?php include $controller->getHomeDir() . "pages/pageassembly/header/header.php"; ?>
            <script src="javascript/search.js"></script>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 sidebar">
                        <form action="" method="GET">
                            <div class="slidecontainer">
                                <label for="myRange">School size:</label>
                                <input type="range" min="1000" max="70000" value="<?php echo $size; ?>" step="1000" class="slider" id="myRange" name="s">
                                <p>Less than <span id="demo"></span> Students</p>
                            </div>
                            <br>
                            <div class="slidecontainer">
                                <label for="myRange2">Tuition Rates:</label>
                                <input type="range" min="1000" max="60000" value="<?php echo $tuition; ?>" step="1000" class="slider" id="myRange2" name="t">
                                <p>Less than $<span id="demo2"></span> per year</p>
                            </div>
                            <br>
                            <div class="slidecontainer">
                                <label for="myRange3">Average SAT Score:</label>
                                <input type="range" min="0" max="1600" value="<?php echo $sat; ?>" step="50" class="slider" id="myRange3" name="sat">
                                <p>Greater than <span id="demo3"></span></p>
                            </div>
                            <?php if ($controller::isUserLoggedIn()) { ?>
                                <br>
                                <div class="slidecontainer">
                                    <label for="myRange4">Distance From Home:</label>
                                    <input type="range" min="0" max="500" value="<?php echo $dist; ?>" step="10" class="slider" id="myRange4" name="dist">
                                    <p>Less than <span id="demo4"></span> miles</p>
                                </div>
                            <?php } ?>
                            <br>
                            <div class="dropdown">
                                <label for="difficulty">Acceptance Difficulty:</label>
                                <select id="difficulty" name="dif">
                                    <?php /*the values for this select indicate the middle of the acceptable difficulty
                            range, with +/- 0.1 acceptance rate from the given value */ ?>
                                    <option value="1"<?php if ($dif == 1) echo " selected"; ?>>
                                        No Preference
                                    </option>
                                    <option value="0.9"<?php if ($dif == 0.9) echo " selected"; ?>>
                                        Minimally Competitive
                                    </option>
                                    <option value="0.7"<?php if ($dif == 0.7) echo " selected"; ?>>
                                        Slightly Competitive
                                    </option>
                                    <option value="0.5"<?php if ($dif == 0.5) echo " selected"; ?>>
                                        Moderately Competitive
                                    </option>
                                    <option value="0.3"<?php if ($dif == 0.3) echo " selected"; ?>>
                                        Very Competitive
                                    </option>
                                    <option value="0.1"<?php if ($dif == 0.1) echo " selected"; ?>>
                                        Highly Competitive
                                    </option>
                                </select>
                            </div>
                            <br>
                            <br>
                            <div class="container">
                                <?php if (isset($query)) { ?>
                                    <input type="hidden" name="q" value="<?php echo $query; ?>">
                                <?php } ?>
                                <input type="submit" class="btn btn-info" value="Update Filter">
                                <?php
                                if ($isStudent) {
                                    ?>
                                    <input type="submit" class="btn btn-info" value="Update Matches" id="updateMatch">
                                    <input type="hidden" name="m" value="n" id="match">
                                <?php } ?>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-9 main container-fluid">
                        <h1 class="page-header">Results</h1>
                        <?php
                        /**
                         * @var $school College
                         */
                        if ($schools) {
                            $styles = " background-size: cover; background-repeat: no-repeat; background-position: center top;";
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
                                            <p>
                                                A<?php if ($school->getSetting() == "Urban") echo "n"; ?>
                                                <?php echo $school->getSetting(); ?> school set in
                                                <?php echo $school->getCity() . ", " . $school->getProvince()->getName();
                                                if (count($school->getMajors()) >= 2) {
                                                    ?>
                                                    servicing students studying everything from
                                                    <?php
                                                    echo $school->getMajors()[0]->getName(); ?> to <?php echo $school->getMajors()[count($school->getMajors()) - 1]->getName();
                                                }
                                                ?>
                                            </p>
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
                    </div>
                </div>
            </div>
        </body>
    </html>
<?php unset($_GET); ?>