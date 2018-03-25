<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 05/03/18
 * Time: 10:33
 */

//How many results that are returned
class CollegeRanker
{
    const BASE_WEIGHT = 4;

    /**
     * Returns the newly calculated student's score for a college, or the scorecard if desired
     * @param Student $student
     * @param College $college
     * @param bool $scorecard
     * @return float|array
     */
    public static function scoreCollege(Student $student, College $college, bool $scorecard = false)
    {
        $maxScore = 0;
        $collegeScore = 0;
        $scorecardOutput = [];

        //Handling basic college information and student information first
        //=======SAT SCORE=======
        $max = CollegeRanker::BASE_WEIGHT;
        $maxScore += $max;
        //206.66 is the national standard deviation in SAT scores
        $score = CollegeRanker::calcPreference(CollegeRanker::calcDistance($student->getSAT(), 206.66, $college->getSAT()), CollegeRanker::BASE_WEIGHT);
        $collegeScore += $score;
        $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "SAT score similarity"];

        //=======ACT SCORE=======
        $max = CollegeRanker::BASE_WEIGHT;
        $maxScore += $max;
        //6.64 is the national standard deviation in ACT scores
        $score = CollegeRanker::calcPreference(CollegeRanker::calcDistance($student->getACT(), 6.64, $college->getACT()), CollegeRanker::BASE_WEIGHT);
        $collegeScore += $score;
        $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "ACT score similarity"];

        //=======   GPA   =======
        //1.74 is the national standard deviation in GPA scores https://www.nationsreportcard.gov/hsts_2009/course_gpa.aspx
        //TODO: Average college admissions GPA not stored in Database

        //=======  MAJORS =======
        $max = CollegeRanker::BASE_WEIGHT * 2;
        $maxScore += $max;
        $collegeMajors = [];
        foreach ($college->getMajors() as $major) {
            $collegeMajors[] = $major->getPkID();
        }
        $score = ((int)in_array($student->getDesiredMajor()->getPkID(), $collegeMajors)) * CollegeRanker::BASE_WEIGHT * 2;
        $collegeScore += $score;
        $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Has your desired major, {$student->getDesiredMajor()->getName()}?"];

        foreach ($student->getPreferredMajors() as $major) {
            $max = CollegeRanker::BASE_WEIGHT;
            $maxScore += $max;
            $score = ((int)in_array($major->getPkID(), $collegeMajors)) * CollegeRanker::BASE_WEIGHT;
            $collegeScore += $score;
            $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Has your preferred major, {$major->getName()}?"];
        }

        //== Duration of degree =
        $max = CollegeRanker::BASE_WEIGHT;
        $maxScore += $max;
        foreach ($college->getMajors() as $major) {
            $majorMatch = ($major->getPkID() == $student->getDesiredMajor()->getPkID());
            foreach ($student->getPreferredMajors() as $preferredMajor) {
                $majorMatch = ($majorMatch or $preferredMajor->getPkID() == $major->getPkID());
                if ($majorMatch) break;
            }
            if ($student->getDesiredCollegeLength()->y <= 2 and $major->isAssociate() and $majorMatch) {
                $score = CollegeRanker::BASE_WEIGHT;
                $collegeScore += $score;
                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Offers an Associate degree for {$major->getName()}"];
                break;
            } elseif ($student->getDesiredCollegeLength()->y <= 4 and ($major->isAssociate() or $major->isBachelor() or $major->isVocational()) and $majorMatch) {
                $score = CollegeRanker::BASE_WEIGHT;
                $collegeScore += $score;
                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Offers an Associate or Bachelor degree for {$major->getName()}"];
                break;
            } elseif ($student->getDesiredCollegeLength()->y <= 6 and ($major->isAssociate() or $major->isBachelor() or $major->isVocational() or $major->isMaster()) and $majorMatch) {
                $score = CollegeRanker::BASE_WEIGHT;
                $collegeScore += $score;
                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Offers an Associate, Bachelor, or Master degree for {$major->getName()}"];
                break;
            } elseif ($student->getDesiredCollegeLength()->y <= 8 and $majorMatch) {
                $score = CollegeRanker::BASE_WEIGHT;
                $collegeScore += $score;
                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Offers a degree for {$major->getName()}"];
                break;
            }
        }

        foreach ($student->getAnsweredQuestions() as $answer) {
            /**
             * @var $question QuestionMC
             */
            $question = $answer->getQuestion();
            switch ($question->getPkID()) {

                /**
                 * Would you rather commute or live on campus?
                 * [Commute, Live on Campus]
                 */
                case 1:
                    //Filter question to get to others that we can rank
                    break;

                /**
                 * How long would you be willing to drive in minutes when commuting?
                 * [5, 10, 20, 30, 40, 60, More than 60]
                 *
                 * 1    "Commute"
                 * 14    "In-State"
                 */
                case 2:
                    //TODO: API integration
                    //requires integration with Bing maps to calculate travel time from user home address to college address
                    break;

                /**
                 * Where would you like to live when going to college?
                 * ["On-Campus Dorm", "On-Campus Apartment", "Off-Campus"]
                 */
                case 3:
                    $max = $answer->getWeight();
                    $maxScore += $max;
                    switch ($answer->getAnswer()) {
                        case "On-Campus Dorm":
                            if ($college->hasDorms()) {
                                $score = $answer->getWeight() / 2;
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max / 2, "score" => $score, "desc" => "Has dorms?"];
                            }
                            if ($college->hasMealPlan()) {
                                $score = $answer->getWeight() / 2;
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max / 2, "score" => $score, "desc" => "Has a meal plan?"];
                            }
                            break;
                        case "On-Campus Apartment":
                            if ($college->hasApartments()) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Has on-campus apartments?"];
                            }
                            break;
                        default:
                            $collegeScore += $answer->getWeight();
                            break;
                    }
                    break;

                /**
                 * Would you like to have roommates or live by yourself?
                 * "Roommates", "Live by Myself"
                 *
                 * 1    "Live On Campus"
                 */
                case 4:
                    $max = $answer->getWeight();
                    $maxScore += $max;
                    switch ($answer->getAnswer()) {
                        case "Roommates":
                            if ($college->hasRoommates() or $college->hasRoommatesChoosable()) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Offers roommates"];
                            }
                            break;
                        case "Live by Myself":
                            if ($college->hasRoommatesChoosable()) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Roommates are choosable"];
                            }
                            break;
                        default:
                            break;
                    }
                    break;

                /**
                 * What would be your main focus in college?
                 * "Academia", "Athletics", "Social Life"
                 *
                 * 7    <null>
                 */
                case 5:
                    $max = $answer->getWeight();
                    $maxScore += $max;
                    $dbc = new DatabaseConnection();
                    $averageAcademia = $dbc->query("select", "SELECT AVG(c) AS ac FROM (SELECT COUNT(fkmajorid) AS c FROM tblmajorcollege GROUP BY fkcollegeid) AS ct")["ac"];
                    $averageSports = $dbc->query("select", "SELECT AVG(c) AS ac FROM (SELECT COUNT(fksportsid) AS c FROM tblcollegesports GROUP BY fkcollegeid) AS ct")["ac"];
                    $averageSocial = $dbc->query("select", "SELECT AVG(c) AS ac FROM (SELECT COUNT(fkgreekid) AS c FROM tblgreekcollege GROUP BY fkcollegeid) AS ct")["ac"];

                    switch ($answer->getAnswer()) {
                        case "Academia":
                            if (count($college->getMajors()) > $averageAcademia) {
                                $score = $answer->getWeight() / 2;
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max / 2, "score" => $score, "desc" => "School focus is academia"];
                            }
                            if ($college->hasLibrary()) {
                                $score = $answer->getWeight() / 2;
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max / 2, "score" => $score, "desc" => "Has a library"];
                            }
                            break;
                        case "Athletics":
                            if (count($college->getSports()) > $averageSports) {
                                $score = $answer->getWeight() / 2;
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max / 2, "score" => $score, "desc" => "School focus is athletics"];
                            }
                            if ($college->hasRecCenter()) {
                                $score = $answer->getWeight() / 2;
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max / 2, "score" => $score, "desc" => "Has a recreation center"];
                            }
                            break;
                        case "Social Life":
                            $outOf = 1;
                            try {
                                if (QuestionHandler::isQuestionAnswered($student, new QuestionMC(3)) and QuestionHandler::getStudentAnswer($student, new QuestionMC(3))->getAnswer() === "On-Campus Dorm") {
                                    $outOf = 2;
                                }
                            } catch (Exception $e) {
                            }

                            if (count($college->getGreeks()) > $averageSocial) {
                                $score = $answer->getWeight() / $outOf;
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max / $outOf, "score" => $score, "desc" => "School focus is social life"];
                            }
                            if ($outOf === 2 and $college->hasTv()) {
                                $score = $answer->getWeight() / $outOf;
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max / $outOf, "score" => $score, "desc" => "Has Tv's in the dorms"];
                            }
                            break;
                        default:
                            break;
                    }
                    break;

                /**
                 * Are you interested in a fraternity or sorority?
                 * "Yes", "No"
                 */
                case 6:
                    $max = $answer->getWeight();
                    $maxScore += $max;
                    if ($answer->getAnswer() === "Yes") {
                        $greeks = $college->getGreeks();
                        foreach ($greeks as $greek) {
                            if (($greek->getType() === Greek::TYPE_SORORITY and $student->isWoman())
                                or ($greek->getType() === Greek::TYPE_FRATERNITY and $student->isMan())
                                or ($greek->getType() === Greek::TYPE_COED)) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $type = ($student->isWoman() ? "sorority" : "standard fraternity");
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Has at least one co-ed fraternity or $type you can join"];
                                break;
                            }
                        }
                    } else {
                        $collegeScore += $answer->getWeight();
                    }
                    break;

                /**
                 * Are you interested in playing sports, either as a club or on a team?
                 * "Yes"
                 * "No"
                 */
                case 7:
                    //checks to see if the school offers any sports for the student's indicated gender
                    $max = $answer->getWeight();
                    $maxScore += $max;
                    if ($answer->getAnswer() === "Yes") {
                        $sports = $college->getSports();
                        foreach ($sports as $sport) {
                            if (($sport->isWomen() and $student->isWoman())
                                or ($sport->isMen() and $student->isMan())) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Has at least one sport you can join"];
                                break;
                            }
                        }
                    } else {
                        $collegeScore += $answer->getWeight();
                    }
                    break;

                /**
                 * Are you interested in joining clubs?
                 * "Yes", "No"
                 */
                case 8:
                    //Checks to see if a college offers radio, drama, newspaper, band, or choral clubs (i.e. not all clubs)
                    $max = $answer->getWeight();
                    $maxScore += $max;
                    if ($answer->getAnswer() === "Yes") {
                        $collegeHas = [
                            $college->hasDrama(),
                            $college->hasRadio(),
                            $college->hasNewspaper(),
                            $college->hasBand(),
                            $college->hasChoral()
                        ];
                        if (in_array(true, $collegeHas, true)) {
                            $score = $answer->getWeight();
                            $collegeScore += $score;
                            $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Has some sort of student clubs"];
                        }
                    } else {
                        $collegeScore += $answer->getWeight();
                    }
                    break;

                /**
                 * Would you consider to go study abroad if given the opportunity?
                 * "Yes", "No"
                 */
                case 9:
                    //TODO: get a DB bool field to store this info
                    //Have no data to check for this one right now
                    break;

                /**
                 * Would you like to go to a vocational school?
                 * "Yes", "No"
                 */
                case 10:
                    //checks to see if the school offers any majors marked as, "vocational"
                    $max = $answer->getWeight();
                    $maxScore += $max;
                    if ($answer->getAnswer() === "Yes") {
                        $majors = $college->getMajors();
                        foreach ($majors as $major) {
                            if ($major->isVocational()) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Offers vocational areas of study"];
                                break;
                            }
                        }
                    } else {
                        $collegeScore += $answer->getWeight();
                    }
                    break;

                /**
                 * What kind of area would you like your college to be located at?
                 * [Urban, Suburban, Rural, Small Town]
                 */
                case 11:
                    $max = $answer->getWeight();
                    $maxScore += $max;
                    if ($answer->getAnswer() === $college->getSetting()) {
                        $collegeScore += $answer->getWeight();
                    } else {
                        //since they dont match find the distance between responses
                        $diff = abs(array_search($answer->getAnswer(), $question->getAnswers(), true) -
                            array_search($college->getSetting(), $question->getAnswers(), true));
                        // reduce weight proportioanlly by the distance from students's answer
                        $score = (int)floor($answer->getWeight() / (2 ** $diff));
                        $collegeScore += $score;
                        $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Similarity to your desired college setting"];
                    }
                    break;

                /**
                 * Would you like to go to a Private or Public college?
                 * "Private", "Public"
                 */
                case 12:
                    $max = $answer->getWeight();
                    $maxScore += $max;
                    switch ($answer->getAnswer()) {
                        case "Private":
                            if ($college->getType() === College::TYPE_PRIVATE) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Is a private school"];
                            }
                            break;
                        case "Public":
                            if ($college->getType() === College::TYPE_PUBLIC) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Is a public school"];
                            }
                            break;
                        default:
                            break;
                    }
                    break;

                /**
                 * How big of the school would you like to go to?
                 * "Small (<= 5000)", "Medium (<= 15000)", "Large (<= 30000)", "Huge (>30000)"
                 */
                case 13:
                    $max = $answer->getWeight();
                    $maxScore += $max;
                    switch ($answer->getAnswer()) {
                        case "Small (<= 5000)":
                            if ($college->getStudentCount() <= 5000) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Is a small school"];
                            }
                            break;
                        case "Medium (<= 15000)":
                            if ($college->getStudentCount() > 5000 and $college->getStudentCount() <= 15000) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Is a medium size school"];
                            }
                            break;
                        case "Large (<= 30000)":
                            if ($college->getStudentCount() > 15000 and $college->getStudentCount() <= 30000) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Is a large school"];
                            }
                            break;
                        case "Huge (>30000)":
                            if ($college->getStudentCount() > 30000) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Is a huge school"];
                            }
                            break;
                        default:
                            break;
                    }
                    break;

                /**
                 * Would you rather go to an in-state or out-of-state college?
                 * "In-State", "Out-Of-State"
                 */
                case 14:
                    $max = $answer->getWeight();
                    $maxScore += $max;
                    switch ($answer->getAnswer()) {
                        case "In-State":
                            if ($college->getProvince()->getPkID() === $student->getProvince()->getPkID()) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Is in the same area as you"];
                            }
                            break;
                        case "Out-Of-State":
                            if ($college->getProvince()->getPkID() !== $student->getProvince()->getPkID()) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Is in a different area than you"];
                            }
                            break;
                        default:
                            break;
                    }
                    break;

                /**
                 * Are you a veteran of the Armed Forces of the United States?
                 * "Yes", "No"
                 */
                case 15:
                    //Filter question to get to others we can rank
                    break;

                /**
                 * How much in student loans would you be comfortable with having to pay off after graduation?
                 * "<=$10,000", "<=$50,000", "<=$100,000", ">100,000"
                 */
                case 16:
                    $max = $answer->getWeight();
                    $maxScore += $max;
                    if ($answer->getAnswer() === ">100,000") {
                        $collegeScore += $answer->getWeight();
                        break;
                    }

                    //Debit is the cost of attendance
                    $totalDebit = 0;
                    //Credit is how much a student can expect to pay off during their time at college
                    $totalCredit = 0;

                    //========= ADDING TOTAL DEBITS =============

                    if ($college->getProvince()->getPkID() === $student->getProvince()->getPkID()) {
                        $totalDebit += $student->getDesiredCollegeLength()->y * $college->getTuitionIn();
                    } else {
                        $totalDebit += $student->getDesiredCollegeLength()->y * $college->getTuitionOut();
                    }

                    try {
                        $question = new QuestionMC(3);
                        if (QuestionHandler::isQuestionAnswered($student, $question)) {
                            if (QuestionHandler::getStudentAnswer($student, $question)->getAnswer() === "On-Campus Dorm") {
                                $totalDebit += ($college->getRoomCost() + $college->getBoardCost()) * $student->getDesiredCollegeLength()->y;
                            } else if (QuestionHandler::getStudentAnswer($student, $question)->getAnswer() === "On-Campus Apartment") {
                                $totalDebit += $college->getRoomCost() * $student->getDesiredCollegeLength()->y;
                            }
                        }
                    } catch (Exception $e) {
                    }

                    //========= ADDING TOTAL CREDITS ============
                    $totalCredit += $student->getDesiredCollegeLength()->y * $student->getExpectedFamilyContribution();

                    foreach ($college->getScholarships() as $scholarship) {
                        if ($scholarship->isStudentEligible($student)) {
                            $totalCredit += $scholarship->getValue();
                        }
                    }

                    $dbc = new DatabaseConnection();
                    $scholarships = $dbc->query("select multiple", "SELECT pkoscholarship FROM tblotherscholarship");
                    foreach ($scholarships as $scholarship) {
                        $temp = new ScholarshipOther($scholarship["pkoscholarship"]);
                        if ($temp->isStudentEligible($student)) {
                            $totalCredit += $temp->getValue();
                        }
                    }

                    if ($student->getDesiredCollegeEntry() > new DateTime("now")) {
                        $fresh = is_null($college->getFinAidFreshmen()) ? 0 : $college->getFinAidFreshmen();
                        $award = is_null($college->getFinAidAwarded()) ? 0 : $college->getFinAidAwarded();
                        $avail = is_null($college->getFinAid()) ? 1 : $college->getFinAid();
                        $totalCredit += (int)floor($fresh * ($award / ($avail * 1.0)));
                    }

                    if ($student->getCountry()->getPkID() !== $college->getCountry()->getPkID()) {
                        $inter = is_null($college->getFinAidInternaional()) ? 0 : $college->getFinAidInternaional();
                        $totalCredit += $student->getDesiredCollegeLength()->y * $inter;
                    } else {
                        $local = is_null($college->getFinAidAwarded()) ? 0 : $college->getFinAidAwarded();
                        $totalCredit += ($student->getDesiredCollegeLength()->y - 1) * $local;
                    }

                    $totalDebt = $totalCredit - $totalDebit;

                    switch ($answer->getAnswer()) {
                        case "<=$10,000":
                            if ($totalDebt <= 10000) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Estimated debt upon graduation: $$totalDebt"];
                            }
                            break;
                        case "<=$50,000":
                            if ($totalDebt <= 50000) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Estimated debt upon graduation: $$totalDebt"];
                            }
                            break;
                        case "<=$100,000":
                            if ($totalDebt <= 100000) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Estimated debt upon graduation: $$totalDebt"];
                            }
                            break;
                        default:
                            //Short circuited earlier in case statement
                            break;
                    }

                    break;

                /**
                 * Do you want to go to a religious college?
                 * "Yes", "No"
                 */
                case 17:
                    //TODO: get a DB bool field to store this info
                    //Have no data to check for this one right now
                    break;

                /**
                 * What kind of college would you rather go to?
                 * "Majority Men", "Majority Women", "Balanced"
                 */
                case 18:
                    $max = $answer->getWeight();
                    $maxScore += $max;
                    switch ($answer->getAnswer()) {
                        case "Majority Men":
                            if ($college->getWomenRatio() < 0.4) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Has more male students than female"];
                            }
                            break;
                        case "Majority Women":
                            if ($college->getWomenRatio() >= 0.6) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Has more female students than female"];
                            }
                            break;
                        case "Balanced":
                            if ($college->getWomenRatio() >= 0.4 and $college->getWomenRatio() < 0.6) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Has a balanced amount of male and female students"];
                            }
                            break;
                        default:
                            break;
                    }
                    break;

                /**
                 * As a US Veteran, what branch did you serve under?
                 * "Air Force", "Army", "Navy", "Marines", "Coast Guard", "Air National Guard", "Army National Guard"
                 *
                 * 15    "Yes"
                 */
                case 19:
                    //Doesn't directly impact schools ranking, but helps fill out the student's financial profile
                    break;

                /**
                 * Do you have a disability?
                 * "Yes", "No"
                 */
                case 20:
                    $max = $answer->getWeight();
                    $maxScore += $max;
                    switch ($answer->getAnswer()) {
                        case "Yes":
                            if ($college->hasHealthCenter() or $college->hasCounseling()) {
                                $score = $answer->getWeight();
                                $collegeScore += $score;
                                $scorecardOutput[] = ["max" => $max, "score" => $score, "desc" => "Has health or counseling services"];
                            }
                            break;
                        default:
                            $collegeScore += $answer->getWeight();
                            break;
                    }
                    break;

                /**
                 * What type of disability do you have?
                 * "Visual", "Hearing/Auditory", "Physical", "Cognitive/Learning", "Psychological", "Invisible", "Cancer/Chronic Illness"
                 *
                 * 20    "Yes"
                 */
                case 21:
                    //Doesn't directly impact schools ranking, but helps fill out the student's financial profile
                    break;

                default:

                    break;
            }
        }
        if($scorecard) {
            return $scorecardOutput;
        } else {
            return ((float)($collegeScore)) / $maxScore;
        }
    }

    /**
     * Calculates how many standard deviations from $mean $x is
     *
     * @param $mean
     * @param $stDev
     * @param $x
     * @return float
     */
    private static function calcDistance($mean, $stDev, $x)
    {
        if (is_null($mean) or is_null($stDev) or is_null($x) or $stDev == 0) {
            return 0;
        } else {
            return abs(($mean - $x) / $stDev);
        }
    }

    /**
     * Returns the weight that should be added to a score given an already calculated distance
     *
     * @param float $distance
     * @param int $weight
     * @return int
     */
    private static function calcPreference(float $distance, int $weight)
    {
        return $weight - min(2 ** ((int)floor($distance)) - 1, $weight);
    }
}