<html>
<title>Search Results</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



<style>
    body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
    .w3-bar,h1,button {font-family: "Montserrat", sans-serif}



         /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
     .row.content {height: 1500px}

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
        .row.content {height: auto;}
    }

</style>
<body>

<!-- Navbar -->
<div class="w3-top">
    <div class="w3-bar w3-red w3-card w3-left-align w3-large">
        <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-red" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
        <a href="#" class="w3-bar-item w3-button w3-padding-large w3-white">MyCollege</a>
        <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Schools</a>
        <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Scholarships</a>
        <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Events</a>
        <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">More</a>
    </div>



<!-- Body text -->

    <div class="container-fluid">
        <div class="row content">
            <div class="col-sm-3 sidenav">
                <h4>Filter Results</h4>
                <br>



                <div class="col-sm-9">



                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            School size <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <form>
                                <input type="radio" name="gender" value="2kless" checked> Less than 2k<br>
                                <input type="radio" name="gender" value="5to15"> 5k to 15k<br>
                                <input type="radio" name="gender" value="Highestamt"> 20k+
                            </form>
                        </ul>
                    </div>



                    <br><br>

                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        Tuition Rates <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <form>
                            <input type="radio" name="gender" value="10kless" checked> Less than 10k<br>
                            <input type="radio" name="gender" value="10to50"> 10k to 50k<br>
                            <input type="radio" name="gender" value="Highestamt"> Greater than 50k+
                        </form>
                    </ul>
                </div>
            </div>

                <div class="col-sm-9">

                    <br>


                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            Average SAT Scores  <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <form>
                                <input type="radio" name="gender" value="960" checked> Below 960<br>
                                <input type="radio" name="gender" value="960+"> Between 960-1090<br>
                                <input type="radio" name="gender" value="1100+"> Between 1100-1290<br>
                                <input type="radio" name="gender" value="Highestamt"> Between 1290-1600
                            </form>
                        </ul>
                    </div>



                    <br><br>



                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            Acceptance Difficulty <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <form>
                                <input type="radio" name="gender" value="NoComp" checked> Not Competitive<br>
                                <input type="radio" name="gender" value="MinDif"> Minimal Difficulty<br>
                                <input type="radio" name="gender" value="VeryDiff"> Very Difficult<br>
                                <input type="radio" name="gender" value="Most Competitive">Most Competitive<br>
                            </form>
                        </ul>
                    </div>
                </div>


        </div>

            <div class="col-sm-9">
                <h4><small>Search Results</small></h4>
                <hr>






                <br><br>




            </div>

    </div>



</body>
</html>