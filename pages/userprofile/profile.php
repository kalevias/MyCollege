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
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Edit Profile</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <style>
            body {
                padding-top: 70px;
                /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
            }

            .othertop {
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <?php include $homedir."pages/pageassembly/header/header.php"; ?>
        <div class="container">
            <div class="row">
                <div class="col-md-10 ">
                    <form class="form-horizontal">
                        <fieldset>

                            <!-- Form Name -->
                            <legend>Edit Profile</legend>

                            <!-- Text input-->


                            <div class="form-group">
                                <label class="col-md-4 control-label" for="Name (Full name)">Name (Full name)</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user">
                                            </i>
                                        </div>
                                        <input id="Name (Full name)" name="Name (Full name)" type="text" placeholder="Name (Full name)" class="form-control input-md">
                                    </div>


                                </div>


                            </div>

                            <!-- File Button -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="Upload photo">Upload photo</label>
                                <div class="col-md-4">
                                    <input id="Upload photo" name="Upload photo" class="input-file" type="file">
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="Date Of Birth">Date Of Birth</label>
                                <div class="col-md-4">

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-birthday-cake"></i>

                                        </div>
                                        <input id="Date Of Birth" name="Date Of Birth" type="text" placeholder="Date Of Birth" class="form-control input-md">
                                    </div>


                                </div>
                            </div>


                            <!-- Text input-->


                            <!-- Text input-->


                            <!-- Multiple Radios (inline) -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="Gender">Gender</label>
                                <div class="col-md-4">
                                    <label class="radio-inline" for="Gender-0">
                                        <input type="radio" name="Gender" id="Gender-0" value="1" checked="checked">
                                        Male
                                    </label>
                                    <label class="radio-inline" for="Gender-1">
                                        <input type="radio" name="Gender" id="Gender-1" value="2">
                                        Female
                                    </label>
                                    <label class="radio-inline" for="Gender-2">
                                        <input type="radio" name="Gender" id="Gender-2" value="3">
                                        Other
                                    </label>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label col-xs-12" for="Permanent Address">Permanent
                                    Address</label>
                                <div class="col-md-2  col-xs-4">
                                    <input id="Permanent Address" name="Permanent Address" type="text" placeholder="District" class="form-control input-md ">
                                </div>

                                <div class="col-md-2 col-xs-4">

                                    <input id="Permanent Address" name="Permanent Address" type="text" placeholder="Area" class="form-control input-md ">
                                </div>


                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="Permanent Address"></label>
                                <div class="col-md-2  col-xs-4">
                                    <input id="Permanent Address" name="Permanent Address" type="text" placeholder="Street" class="form-control input-md ">

                                </div>


                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label" for="Temporary Address"></label>
                                <div class="col-md-2  col-xs-4">
                                    <input id="Temporary Address" name="Temporary Address" type="text" placeholder="Street" class="form-control input-md ">

                                </div>
                            </div>


                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="Skills">Skills</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-graduation-cap"></i>

                                        </div>
                                        <input id="Skills" name="Skills" type="text" placeholder="Skills" class="form-control input-md">
                                    </div>


                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="Phone number ">Phone number </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>

                                        </div>
                                        <input id="Phone number " name="Phone number " type="text" placeholder="Primary Phone number " class="form-control input-md">

                                    </div>
                                    <div class="input-group othertop">
                                        <div class="input-group-addon">
                                            <i class="fa fa-mobile fa-1x" style="font-size: 20px;"></i>

                                        </div>
                                        <input id="Phone number " name="Secondary Phone number " type="text" placeholder=" Secondary Phone number " class="form-control input-md">

                                    </div>

                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="Email Address">Email Address</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-envelope-o"></i>

                                        </div>
                                        <input id="Email Address" name="Email Address" type="text" placeholder="Email Address" class="form-control input-md">

                                    </div>

                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label" for="Email Address">Alternate Email
                                    Address</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-envelope-o"></i>

                                        </div>
                                        <input id="Email Address" name="Alternate Email Address" type="text" placeholder="Alternate Email Address" class="form-control input-md">

                                    </div>

                                </div>
                            </div>


                            <!-- Textarea -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="About (max 200 words)">About (max 200
                                    words)</label>
                                <div class="col-md-4">
                                    <textarea class="form-control" rows="10" id="About (max 200 words)" name="About (max 200 words)"></textarea>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-4">
                                    <a href="#" class="btn btn-success"><span class="glyphicon glyphicon-thumbs-up"></span>
                                        Update</a>
                                    <a href="#" class="btn btn-danger" value=""><span class="glyphicon glyphicon-remove-sign"></span>
                                        Clear</a>

                                </div>
                            </div>

                        </fieldset>
                    </form>
                </div>
                <div class="col-md-2 hidden-xs">
                    <img src="http://websamplenow.com/30/userprofile/images/avatar.jpg" class="img-responsive img-thumbnail ">
                </div>
            </div>
        </div>
        <!-- jQuery Version 1.11.1 -->
        <script src="js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

    </body>

</html>