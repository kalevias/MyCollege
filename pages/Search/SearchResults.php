<html xmlns="http://www.w3.org/1999/html">
<title>Search Results</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="css/searchResults.css" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<style>
    body, h1, h2, h3, h4, h5, h6 {
        font-family: "Lato", sans-serif
    }

    .w3-bar, h1, button {
        font-family: "Montserrat", sans-serif
    }

    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {
        height: 1500px
    }

    /* Set gray background color and 100% height */
    .sidenav {
        background-color: #f1f1f1;
        height: 100%;
    }

    /* Set black background color, white text and some padding */
    footer {
        background-color: #555;
        color: white;
        padding: 15px;
    }

    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
        .sidenav {
            height: auto;
            padding: 15px;
        }

        .row.content {
            height: auto;
        }
    }

</style>
<body>

<!-- Navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="#" class="navbar-nav navbar-default">MyCollege</a></li>
                <li><a href="/MyCollege/pages/Search/SearchResults.php" class="navbar-nav navbar-default">Schools</a>
                </li>
                <li><a href="#" class="navbar-nav navbar-default">Scholarships</a></li>
                <li><a href="#" class="navbar-nav navbar-default">Events</a></li>
                <li><a href="#" class="navbar-nav navbar-default">More</a></li>

                <?php
                if ($loggedIn) {
                    ?>

                    <form action="" method="POST">
                        <input type="hidden" value="logout" name="requestType">
                        <input type="submit" class="navbar-nav navbar-default"
                               value="Log Out">
                    </form>

                    <li><a href="#myModal" data-toggle="modal" data-target="#myModal"><span
                                    class="glyphicon glyphicon-search"></span></a></li>

                    <?php
                } else {
                ?>

                <li><a href="/mycollege/pages/Login/login.php"
                       class="navbar-nav navbar-default">Login</a></li>


                <li><span class="navbar-nav navbar-default dropdown">
                    <button class="navbar-nav navbar-default dropdown-toggle" id="registermenu" type="button"
                            data-toggle="dropdown">
                        Register
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="registermenu">
                        <li role="presentation"><a role="menuitem" tabindex="-1"
                                                   href="/mycollege/pages/Register/signup.php">Students</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1"
                                                   href="/mycollege/pages/Register/signup.php">College Reps</a></li>
                    </ul>
                    </span></li>

                <li><a href="#myModal" data-toggle="modal" data-target="#myModal"><span
                                class="glyphicon glyphicon-search"></span></a></li>

            </ul>


            <?php
            }
            ?>


        </div>

</nav>


<div class="container-fluid">
    <div class="row">

        <div class="col-lg-3 sidebar">
            <div class="slidecontainer">
                <p>School size:</p>
                <input type="range" min="1000" max="20000" value="10000" class="slider" id="myRange">
                <p>Value: <span id="demo"></span> Students</p>
            </div>
            <script>
                var slider = document.getElementById("myRange");
                var output = document.getElementById("demo");
                output.innerHTML = slider.value; // Display the default slider value

                // Update the current slider value (each time you drag the slider handle)
                slider.oninput = function () {
                    output.innerHTML = this.value;
                }
            </script>
            <br>

            <div class="slidecontainer">
                <p>Tuition Rates:</p>
                <input type="range" min="1000" max="50000" value="25000" class="slider" id="myRange2">
                <p>Value: $<span id="demo2"></span></p>
            </div>
            <script>
                slider = document.getElementById("myRange2");
                var output2 = document.getElementById("demo2");
                output2.innerHTML = slider.value; // Display the default slider value

                // Update the current slider value (each time you drag the slider handle)
                slider.oninput = function () {
                    output2.innerHTML = this.value;
                }
            </script>
            <br>

            <div class="slidecontainer">
                <p>Average SAT Score:</p>
                <input type="range" min="0" max="1600" value="800" class="slider" id="myRange3">
                <p>Value: <span id="demo3"></span></p>
            </div>
            <script>
                slider = document.getElementById("myRange3");
                var output3 = document.getElementById("demo3");
                output3.innerHTML = slider.value; // Display the default slider value

                // Update the current slider value (each time you drag the slider handle)
                slider.oninput = function () {
                    output3.innerHTML = this.value;
                }
            </script>

            <br>

            <div class="slidecontainer">
                <p>Distance From Home:</p>
                <input type="range" min="0" max="500" value="250" class="slider" id="myRange4">
                <p>Value: <span id="demo4"></span> Miles </p>
            </div>
            <script>
                slider = document.getElementById("myRange4");
                var output3 = document.getElementById("demo4");
                output3.innerHTML = slider.value; // Display the default slider value

                // Update the current slider value (each time you drag the slider handle)
                slider.oninput = function () {
                    output3.innerHTML = this.value;
                }
            </script>

            <br>

            <div class="dropdown">
                <p>Acceptance Difficulty:</p>
                <select>
                    <option value="volvo">Not Competitive</option>
                    <option value="saab">Medium Difficulty</option>
                    <option value="opel">Very Difficult</option>
                </select>
            </div>

            <br>
            <br>
            <div class="container">
                <input type="submit" class="btn btn-info" value="Update Filter">
            </div>
        </div>


        <div class="col-lg-9 main">
            <h1 class="page-header">Search Results</h1>

            <div class="contentStyle row placeholders"
            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=="
                 width="90" height="80" class="img-responsive" alt="Generic placeholder thumbnail">
            <h3>College Name</h3>

            <dl>
                Location of School /
                Amount of students at school here

            </dl>

            <p>
                Some kind of general description of school here

            </p>

        </div>


    </div>
</div>
</div>


</body>
</html>