<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$homedir = "../../";
if (isset($_SESSION["userLoggedIn"])) {
    $loggedIn = true;
} else {
    $loggedIn = false;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Search Results</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <link rel="stylesheet" href="<?php echo $homedir; ?>pages/search/css/search.min.css" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php include $homedir . "pages/pageassembly/header/header.php"; ?>
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
    </body>
</html>