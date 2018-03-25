





























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


    <style>

        #example1 {
            background-image: url(img_flwr.gif);
            background-position: right bottom, left top;
            background-repeat: no-repeat, repeat;
            padding: 15px;
        }
    </style>

</head>
<body>
<?php include $controller->getHomeDir() . "pages/pageassembly/header/header.php"; ?>
<script src="javascript/scholarships.js"></script>
<div class="container-fluid">
    <div class="col-lg-9 main container-fluid">
            <h1 class="page-header">Search Results</h1>



        <div id="example1">




        <style>
            #main-content .promo .container h4 {
                display: block;
                margin: 0;
                color: #fff;
                font-size: 1em;
                font-family: "Lexia W01 Light",serif;
                font-weight: normal;
            }

            #main-content .promo .container .button {
                margin-top: .625em;
                font-size: .8125em;
            }

            #main-content .promo .container .button:active, #main-content .promo .container .button:focus {
                background: none !important;
                background-color: transparent !important;
            }

            @media screen and (min-width: 768px) {
                #main-content .promo .container h4 {
                    font-size: 1.25em;
                    display: inline-block;
                    vertical-align: middle;
                }

                #main-content .promo .container .button {
                    margin-top: 0;
                }
            }

            @media screen and (min-width: 1024px) {
                #main-content .promo .container h4 {
                    font-size: 1.5em;
                }
            }

            #main-content .promo .container .small {
                color: rgba(255,255,255,.5);
                font-size: .875em;
                font-style: italic;
            }
        </style>








        <div class="col-2-3">
            <div class="scholarship-form">
                <p class="scholarshipformHead museo">Answer a few questions to find scholarships.</p>
                <div class="col-1-1 bottom-bump" style="padding-right: 0; padding-left: 0;">
                    <div class="col-7-12 museo questionLabel">What type of student are you?</div>
                    <div class="col-5-12 clearfix">
                        <div class="half-width">
                            <input type="radio" name="studyType" value="ugrad" id="studyTypeUg" checked="checked"><label for="studyTypeUg"><span></span>Undergraduate</label>
                        </div>
                        <div class="half-width ">
                            <input type="radio" name="studyType" value="grad" id="studyTypeGr"><label for="studyTypeGr"><span></span>Graduate</label>
                        </div>
                    </div>
                </div>
                <div class="col-1-1 bottom-bump" id="currentlyInHighShool" style="padding-right: 0; padding-left: 0;">
                    <div class="col-7-12 museo questionLabel">Are you currently in high school?</div>
                    <div class="col-5-12 clearfix">
                        <div class="half-width">
                            <input type="radio" name="highschool" value="isInHighSchool" id="hsYes"><label for="hsYes"><span></span>Yes</label>
                        </div>
                        <div class="half-width">
                            <input type="radio" name="highschool" value="" id="hsNo"><label for="hsNo"><span></span>No</label>
                        </div>
                    </div>
                </div>

                <div class="col-1-1 bottom-bump" style="padding-right: 0; padding-left: 0;">
                    <div class="col-7-12 museo questionLabel">Will you study full time or part time?</div>
                    <div class="col-5-12 clearfix">
                        <div class="half-width">
                            <input type="radio" name="ftPt" value="fullTime" id="ftPtYes"><label for="ftPtYes"><span></span>Full Time</label>
                        </div>
                        <div class="half-width">
                            <input type="radio" name="ftPt" value="partTime" id="ftPtNo"><label for="ftPtNo"><span></span>Part Time</label>
                        </div>
                    </div>
                </div>
                <div class="col-1-1 bottom-bump" id="schoolType" style="padding-right: 0; padding-left: 0;">
                    <div class="col-7-12 museo questionLabel" style="padding-top: 5px;">What type of school will you attend?</div>
                    <div class="col-5-12" style="margin-top: -4px;">
                        <div class="custom-dropdown">
                            <select tabindex="16" name="schoolTypeDropdown" id="schoolTypeDropdown" required="required">
                                <option value="0">Select Type</option>
                                <option value="university">University</option>
                                <option value="fourYearCollege">Four-Year College</option>
                                <option value="twoYearCollege">Two-Year College</option>
                                <option value="tradeSchool">Trade/Technical Institution</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr class="dotted">
                <div class="col-1-1" style="text-align: right; margin-top: 10px;">
                    <button type="button" tabindex="5" id="searchByQuestions" class="nice medium orange button radius">Search</button>
                </div>
                <div style="clear: both;"></div>
            </div>
            <div class="scholarship-form" style="margin-top: 30px;">
                <p class="scholarshipformHead museo" style="margin-bottom: 5px;">Or search by name or keyword</p>
                <div style="position: relative;">
                    <input type="text" class="input-text scholarshipAuto ui-autocomplete-input" id="inputText" placeholder="Enter keyword" autocomplete="off">
                    <button type="submit" class="search scholarshipSubmit" id="textSearch" style="height: 15px"></button>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>














            <?php
            /**
             * @var $schools College[]
             */
            if ($schools) {
                $styles = " background-size: cover; background-repeat: no-repeat; background-position: center;";
                foreach ($schools as [$school, $rating]) { ?>

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



