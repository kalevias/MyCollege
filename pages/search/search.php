<?php
include "../../autoload.php";

$controller = $_SESSION["controller"] = new Controller("MyCollege");
$controller->initModuleDir();
$controller->processREQUEST();

$q = isset($_GET["q"]) ? "%" . $_GET["q"] . "%" : "%%";
$size = isset($_GET["s"]) ? $_GET["s"] : 70000;
$tuition = isset($_GET["t"]) ? $_GET["t"] : 60000;
$sat = isset($_GET["sat"]) ? $_GET["sat"] : 0;
$dist = isset($_GET["dist"]) ? $_GET["dist"] : 500;
$difHigher = (isset($_GET["dif"]) and $_GET["dif"] != 1) ? $_GET["dif"] + 0.1 : 1;
$difLower = (isset($_GET["dif"]) and $_GET["dif"] != 1) ? $_GET["dif"] - 0.1 : 0;
//TODO: finish implementation of "distance from home" filter
//TODO: finish implementation of tuition filter to consider in-state vs. out-of-state based on user address

$dbc = new DatabaseConnection();
$query = "SELECT pkcollegeid, nmcollege, txcity, nsize, p.nmname AS nmprovince, ensetting, MIN(m.nmname) AS firstmajor, MAX(m.nmname) AS lastmajor
                                FROM tblcollege c
                                JOIN tblprovince p ON c.fkprovinceid = p.pkstateid
                                LEFT JOIN tblmajorcollege mc ON c.pkcollegeid = mc.fkcollegeid
                                LEFT JOIN tblmajor m ON mc.fkmajorid = m.pkmajorid
                                WHERE c.nmcollege LIKE ?
                                  AND c.nsize < ?
                                  AND c.ninstate < ?
                                  AND (c.nsat > ? OR c.nsat IS NULL)
                                  AND c.nacceptrate <= ?
                                  AND c.nacceptrate >= ?
                                GROUP BY c.pkcollegeid
                                ORDER BY c.nmcollege";
$params = [
    "siiidd",
    $q,
    $size,
    $tuition,
    $sat,
    $difHigher,
    $difLower
];
$schools = $dbc->query("select multiple", $query, $params);
?>
    <!DOCTYPE html>
    <html>
        <head>
            <title>MyCollege</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
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
                                    <option value="1"<?php if (isset($_GET["dif"]) and $_GET["dif"] == 1) echo " selected"; ?>>
                                        No Preference
                                    </option>
                                    <option value="0.9"<?php if (isset($_GET["dif"]) and $_GET["dif"] == 0.9) echo " selected"; ?>>
                                        Minimally Competitive
                                    </option>
                                    <option value="0.7"<?php if (isset($_GET["dif"]) and $_GET["dif"] == 0.7) echo " selected"; ?>>
                                        Slightly Competitive
                                    </option>
                                    <option value="0.5"<?php if (isset($_GET["dif"]) and $_GET["dif"] == 0.5) echo " selected"; ?>>
                                        Moderately Competitive
                                    </option>
                                    <option value="0.3"<?php if (isset($_GET["dif"]) and $_GET["dif"] == 0.3) echo " selected"; ?>>
                                        Very Competitive
                                    </option>
                                    <option value="0.1"<?php if (isset($_GET["dif"]) and $_GET["dif"] == 0.1) echo " selected"; ?>>
                                        Highly Competitive
                                    </option>
                                </select>
                            </div>
                            <br>
                            <br>
                            <div class="container">
                                <?php if (isset($_GET["q"])) { ?>
                                    <input type="hidden" name="q" value="<?php echo $_GET["q"]; ?>">
                                <?php } ?>
                                <input type="submit" class="btn btn-info" value="Update Filter">
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-9 main">
                        <h1 class="page-header">Search Results</h1>
                        <?php
                        if ($schools) {
                            $styles = " background-size: cover; background-repeat: no-repeat; background-position: center;";
                            foreach ($schools as $school) { ?>
                                <div class="placeholders" style="background-image: linear-gradient(to bottom, rgba(255,255,255,0.6) 0%,rgba(255,255,255,0.6) 100%), url('<?php echo $controller->getWindowsHomeDir() . "files/" . $school["pkcollegeid"] . ".jpg"; ?>');<?php echo $styles; ?>">
                                    <div style="opacity: 1">
                                        <h3 data-id="<?php echo $school["pkcollegeid"]; ?>"><?php echo $school["nmcollege"]; ?></h3>
                                        <dl>
                                            <?php echo $school["txcity"] . ", " . $school["nmprovince"]; ?>
                                            | <?php echo $school["nsize"]; ?>
                                            students
                                        </dl>
                                        <p>
                                            A<?php if ($school["ensetting"] == "Urban") echo "n"; ?>
                                            <?php echo $school["ensetting"]; ?> school set in
                                            <?php echo $school["txcity"] . ", " . $school["nmprovince"]; ?>
                                            servicing students studying everything from
                                            <?php echo $school["firstmajor"]; ?> to <?php echo $school["lastmajor"]; ?>
                                        </p>
                                    </div>
                                </div>
                            <?php }
                        } else { ?>
                            <h3>No schools found</h3>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </body>
    </html>
<?php unset($_GET); ?>