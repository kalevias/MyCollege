<?php
include "../../autoload.php";

$controller = $_SESSION["controller"] = new Controller("MyCollege");
$controller->initModuleDir();
$controller->processREQUEST("filterScholarships");
$scholarships = $controller->getLastGETRequest()["output"];
$college = is_null($controller->getLastGETRequest()["input"]["college"]) ? null : new College($controller->getLastGETRequest()["input"]["college"]);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>MyCollege</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/scholarships.min.css" type="text/css">
    </head>
    <body>
        <?php include $controller->getHomeDir() . "pages/pageassembly/header/header.php"; ?>
        <script src="javascript/scholarship.js"></script>

        <div class="contrainer-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        $styles = " background-size: cover; background-repeat: no-repeat; background-position: center 35%;";
                        $file = is_null($college) ? "12" : $controller->getHomeDir() . "files/" . $college->getPkID();
                    ?>
                    <div class="scholarshipHeader" style="background-image: linear-gradient(to bottom, rgba(255,255,255,0) 0%,rgba(255,255,255,0) 100%), url('<?php echo "$file.jpg"; ?>');<?php echo $styles; ?>">
                    <h1>
                        Find the perfect scholarship<?php echo (is_null($college) ? "" : " at<br>" . $college->getName()); ?>
                    </h1>
                    </div>
                </div>
            </div>
            <div id="scholarshipsList">
                <?php
                /**
                 * @var $scholarship Scholarship
                 */
                foreach ($scholarships as $scholarship) {
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="scholarship">
                                <h2><?php echo $scholarship->getName(); ?></h2>
                                <h5><?php if(get_class($scholarship) == "CollegeScholarship") { echo $scholarship->getCollege()->getName() . ", "; } ?>
                                    <?php echo $scholarship->getType(); ?></h5>
                                <p><?php echo $scholarship->getDescription(); ?></p>
                                <p><?php echo $scholarship->getRequirements(); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </body>
</html>

