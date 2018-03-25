
<?php
include "../../autoload.php";
$controller = $_SESSION["controller"] = new Controller("MyCollege");
?>



<!DOCTYPE html>
    <html>
            <title>MyCollege</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="css/scholarships.min.css" type="text/css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <body>

        <?php include $controller->getHomeDir() . "pages/pageassembly/header/header.php"; ?>
        <script src="javascript/scholarships.js"></script>

        <div class="header">

                <div id="myCarousel" class="carousel slide" data-ride="carousel">

                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="12.jpg" alt="indiana" width="2000" height="10">
                            <div class="carousel-caption">
                                <h1> Find the Perfect Scholarship.</h1>

                                <h2
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

                                    </div>
                                </div> </h2>

                            </div>
                        </div>
                    </div>
        </div>





        <div class="row">
            <div class="leftcolumn">
                <div class="card">
                    <h2>TITLE HEADING</h2>
                    <h5>Title description, Dec 7, 2017</h5>
                    <div class="fakeimg" style="height:200px;">Image</div>
                    <p>Some text..</p>
                    <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
                </div>
                <div class="card">
                    <h2>TITLE HEADING</h2>
                    <h5>Title description, Sep 2, 2017</h5>
                    <div class="fakeimg" style="height:200px;">Image</div>
                    <p>Some text..</p>
                    <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
                </div>
            </div>
            <div class="rightcolumn">
                <div class="card">
                    <h2>About Me</h2>
                    <div class="fakeimg" style="height:100px;">Image</div>
                    <p>Some text about me in culpa qui officia deserunt mollit anim..</p>
                </div>
                <div class="card">
                    <h3>Popular Post</h3>
                    <div class="fakeimg"><p>Image</p></div>
                    <div class="fakeimg"><p>Image</p></div>
                    <div class="fakeimg"><p>Image</p></div>
                </div>
                <div class="card">
                    <h3>Follow Me</h3>
                    <p>Some text..</p>
                </div>
            </div>
        </div>

        <div class="footer">
            <h2>Footer</h2>
        </div>


        </body>



<head>
    <Style>

        * {
            box-sizing: border-box;
        }

        h1 {
            text-align : left;
        }

        body {
            font-family: Arial;
            padding: 10px;
            background: #f1f1f1;
        }

        /* Header/Blog Title */
        .header {
            padding: 30px;
            text-align: center;
            background: white;
        }

        .header h1 {
            font-size: 50px;
        }

        /* Style the top navigation bar */
        .topnav {
            overflow: hidden;
            background-color: #333;
        }

        /* Style the topnav links */
        .topnav a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        /* Change color on hover */
        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        /* Create two unequal columns that floats next to each other */
        /* Left column */
        .leftcolumn {
            float: left;
            width: 75%;
        }

        /* Right column */
        .rightcolumn {
            float: left;
            width: 25%;
            background-color: #f1f1f1;
            padding-left: 20px;
        }

        /* Fake image */
        .fakeimg {
            background-color: #aaa;
            width: 100%;
            padding: 20px;
        }

        /* Add a card effect for articles */
        .card {
            background-color: white;
            padding: 20px;
            margin-top: 20px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Footer */
        .footer {
            padding: 20px;
            text-align: center;
            background: #ddd;
            margin-top: 20px;
        }

        /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 800px) {
            .leftcolumn, .rightcolumn {
                width: 100%;
                padding: 0;
            }
        }

        /* Responsive layout - when the screen is less than 400px wide, make the navigation links stack on top of each other instead of next to each other */
        @media screen and (max-width: 400px) {
            .topnav a {
                float: none;
                width: 100%;
            }
        }

        .carousel-caption {
            top: 0;
            left: 25px;
            bottom: auto;
        }


        

    </Style>

</head>



</html>

