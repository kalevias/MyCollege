<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/21/2018
 * Time: 4:15 PM
 */

include "../../autoload.php";

$controller = $_SESSION["controller"] = new Controller("MyCollege");
$controller->initModuleDir();
$controller->processREQUEST();
$controller->checkPermissions($controller->userHasAccess([Permission::PERMISSION_STUDENT]));

if (isset($_SESSION["nextQuestion"]) or isset($_SESSION["prevQuestion"])) {
    try {
        $lastQuestion = new QuestionMC($_SESSION["question"]);
        unset($_SESSION["question"]);
    } catch (Exception $e) {
        $_SESSION["localErrors"][] = $e;
        if (isset($_SESSION["nextQuestion"])) {
            unset($_SESSION["nextQuestion"]);
        }
        if (isset($_SESSION["prevQuestion"])) {
            unset($_SESSION["prevQuestion"]);
        }
        unset($_SESSION["question"]);
    }
}

if (isset($_SESSION["nextQuestion"])) {
    //If the user is asking to answer the next question
    unset($_SESSION["nextQuestion"]);
    $index = QuestionHandler::getAvailableQuestionIndex(Controller::getLoggedInUser(), $lastQuestion);
    $question = QuestionHandler::getNthAvailableQuestion(Controller::getLoggedInUser(), $index + 1);
    if(QuestionHandler::isQuestionAnswered(Controller::getLoggedInUser(), $question)) {
        $currentAnswer = QuestionHandler::getStudentAnswer($controller::getLoggedInUser(), $question);
    }
} else if (isset($_SESSION["prevQuestion"])) {
    //If the user is asking to answer the previous question
    unset($_SESSION["prevQuestion"]);
    $index = QuestionHandler::getAvailableQuestionIndex(Controller::getLoggedInUser(), $lastQuestion);
    $question = QuestionHandler::getNthAvailableQuestion(Controller::getLoggedInUser(), $index - 1);
    if(QuestionHandler::isQuestionAnswered(Controller::getLoggedInUser(), $question)) {
        $currentAnswer = QuestionHandler::getStudentAnswer($controller::getLoggedInUser(), $question);
    }
} else {
    //If the user isn't asking to answer any particular question
    if (!is_null(QuestionHandler::getCurrentQuestion($controller::getLoggedInUser()))) {
        $question = QuestionHandler::getCurrentQuestion($controller::getLoggedInUser());
        $currentAnswer = QuestionHandler::getStudentAnswer($controller::getLoggedInUser(), $question);
    } else {
        $question = QuestionHandler::getNextQuestion($controller::getLoggedInUser());
    }
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
        <title>MyCollege</title>

        <link rel="stylesheet" href="<?php echo $controller->getHomeDir(); ?>resources/jslib/chosen/chosen.min.css" type="text/css">
        <link rel="stylesheet" href="css/profile.min.css" type="text/css">
    </head>
    <body>
        <?php include $controller->getHomeDir() . Controller::MODULE_DIR . "/pageassembly/header/header.php"; ?>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <script src="javascript/questions.js"></script>
        <div class="container">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <h2>College Preferences</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?php include $controller->getHomeDir() . Controller::MODULE_DIR . "pageassembly/profilenav/profilenav.php"; ?>
                </div>
                <div class="col-md-4">
                    <form class="form-horizontal">
                        <div id="current-question">
                            <div class="container-fluid">
                                <h6>Answer questions to improve college matching accuracy</h6>
                                <hr style="margin-top:0">
                                <div class="row">
                                    <div class="col-sm-2">
                                            <span id="questionID" data-id="<?php echo $question->getPkID(); ?>">
                                                #<?php echo QuestionHandler::getAvailableQuestionIndex(Controller::getLoggedInUser(), $question) + 1; ?>
                                                <br>
                                                <br>
                                                (of <?php echo
                                                    count(QuestionHandler::getAvailableUnansweredQuestions($controller::getLoggedInUser()))
                                                    + count($controller::getLoggedInUser()->getAnsweredQuestions())
                                                ?>)
                                            </span>
                                    </div>
                                    <div class="col-sm-10">
                                        <div id="questionText">
                                            <?php echo $question->getQuestionText(); ?>
                                        </div>
                                        <div id="questionAnswers">
                                            <?php
                                            if (get_class($question) === "QuestionMC") {
                                                /**
                                                 * @var $question QuestionMC
                                                 */
                                                foreach ($question->getAnswers() as $answer) {
                                                    ?>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="answer" value="<?php echo htmlspecialchars($answer); ?>"<?php if (isset($currentAnswer) and $currentAnswer->getAnswer() == $answer) echo " checked"; ?>>
                                                        <?php echo $answer; ?>
                                                    </label>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div id="importanceText">
                                        How important is that answer to you?
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="questionImportance">
                                        <?php
                                        for ($i = 0; $i <= 4; $i++) {
                                            switch ($i) {
                                                case 0:
                                                    $importance = "very low";
                                                    break;
                                                case 1:
                                                    $importance = "low";
                                                    break;
                                                case 2:
                                                    $importance = "average";
                                                    break;
                                                case 3:
                                                    $importance = "high";
                                                    break;
                                                case 4:
                                                    $importance = "very high";
                                                    break;
                                            }
                                            ?>
                                            <label class="radio-inline">
                                                <input type="radio" name="importance" value="<?php echo $i; ?>"<?php if ((isset($currentAnswer) and $currentAnswer->getImportance() === $i) or (!isset($currentAnswer) and $i === 2)) echo " checked"; ?>>
                                                <?php echo $importance; ?>
                                            </label>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="qnav-button">
                                <a href="#" class="btn btn-success<?php if (QuestionHandler::getAvailableQuestionIndex(Controller::getLoggedInUser(), $question) !== 0) {
                                    echo "\" id=\"prevQuestion";
                                } else {
                                    echo " disabled";
                                } ?>">
                                    <i class="glyphicon glyphicon-arrow-left"></i>
                                </a>
                            </div>
                            <div class="qnav-button">
                                <a href="#" class="btn btn-success<?php if (QuestionHandler::getAvailableQuestionIndex(Controller::getLoggedInUser(), $question) !== (count(QuestionHandler::getAvailableUnansweredQuestions(Controller::getLoggedInUser())) + count(Controller::getLoggedInUser()->getAnsweredQuestions()) - 1)) {
                                    echo "\" id=\"nextQuestion";
                                } else {
                                    echo " disabled";
                                } ?>">
                                    <i class="glyphicon glyphicon-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>