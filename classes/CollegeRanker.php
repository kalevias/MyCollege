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
    const RESULT_COUNT = 5;
    const BASE_WEIGHT = 4;

    /**
     * Returns an in order list of college IDs
     * @param Student $student
     * @param College $college
     * @return float
     */
    public static function scoreCollege(Student $student, College $college): float
    {
        $maxScore = 0;
        $collegeScore = 0;

        //Handling basic college information and student information first
        //=======SAT SCORE=======
        $maxScore += CollegeRanker::BASE_WEIGHT;
        //206.66 is the national standard deviation in SAT scores
        $collegeScore += CollegeRanker::calcPreference(CollegeRanker::calcDistance($student->getSAT(), 206.66, $college->getSAT()), CollegeRanker::BASE_WEIGHT);

        //=======ACT SCORE=======
        $maxScore += CollegeRanker::BASE_WEIGHT;
        //6.64 is the national standard deviation in ACT scores
        $collegeScore += CollegeRanker::calcPreference(CollegeRanker::calcDistance($student->getACT(), 6.64, $college->getACT()), CollegeRanker::BASE_WEIGHT);

        //=======   GPA   =======
        //1.74 is the national standard deviation in GPA scores https://www.nationsreportcard.gov/hsts_2009/course_gpa.aspx
        //Average college admissions GPA not stored in Database

        //=======  MAJORS =======
        $maxScore += CollegeRanker::BASE_WEIGHT * 2;
        $collegeMajors = [];
        foreach ($college->getMajors() as $major) {
            $collegeMajors[] = $major->getPkID();
        }
        $collegeScore += ((int)in_array($student->getDesiredMajor()->getPkID(), $collegeMajors)) * CollegeRanker::BASE_WEIGHT * 2;

        foreach ($student->getPreferredMajors() as $major) {
            $maxScore += CollegeRanker::BASE_WEIGHT;
            $collegeScore += ((int)in_array($major->getPkID(), $collegeMajors)) * CollegeRanker::BASE_WEIGHT;
        }

        //== Duration of degree =
        $maxScore += CollegeRanker::BASE_WEIGHT;
        foreach ($college->getMajors() as $major) {
            $majorMatch = ($major->getPkID() == $student->getDesiredMajor()->getPkID());
            foreach ($student->getPreferredMajors() as $preferredMajor) {
                $majorMatch = ($majorMatch or $preferredMajor->getPkID() == $major->getPkID());
                if ($majorMatch) break;
            }
            if ($student->getDesiredCollegeLength()->y <= 2 and $major->isAssociate() and $majorMatch) {
                $collegeScore += CollegeRanker::BASE_WEIGHT;
                break;
            } elseif ($student->getDesiredCollegeLength()->y <= 4 and ($major->isAssociate() or $major->isBachelor() or $major->isVocational()) and $majorMatch) {
                $collegeScore += CollegeRanker::BASE_WEIGHT;
                break;
            } elseif ($student->getDesiredCollegeLength()->y <= 6 and ($major->isAssociate() or $major->isBachelor() or $major->isVocational() or $major->isMaster()) and $majorMatch) {
                $collegeScore += CollegeRanker::BASE_WEIGHT;
                break;
            } elseif ($student->getDesiredCollegeLength()->y <= 8 and $majorMatch) {
                $collegeScore += CollegeRanker::BASE_WEIGHT;
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
                 * 
                 */
                case 1:

                    break;

                /**
                 *
                 */
                case 2:

                    break;

                /**
                 *
                 */
                case 3:

                    break;

                /**
                 *
                 */
                case 4:

                    break;

                /**
                 *
                 */
                case 5:

                    break;

                /**
                 *
                 */
                case 6:

                    break;

                /**
                 *
                 */
                case 7:

                    break;

                /**
                 *
                 */
                case 8:

                    break;

                /**
                 *
                 */
                case 9:

                    break;

                /**
                 *
                 */
                case 10:

                    break;

                /**
                 * What kind of area would you like your college to be located at?
                 * [Urban, Suburban, Rural, Small Town]
                 */
                case 11:
                    $maxScore += $answer->getWeight();
                    if ($answer->getAnswer() === $college->getSetting()) {
                        $collegeScore += $answer->getWeight();
                    } else {
                        //since they dont match find the distance between responses
                        $diff = abs(array_search($answer->getAnswer(), $question->getAnswers(), true) -
                            array_search($college->getSetting(), $question->getAnswers(), true));
                        // reduce weight proportioanlly by the distance from students's answer
                        $collegeScore += floor($answer->getWeight() / (2 ** $diff));
                    }
                    break;

                /**
                 *
                 */
                case 12:

                    break;

                /**
                 *
                 */
                case 13:

                    break;

                /**
                 *
                 */
                case 14:

                    break;

                /**
                 *
                 */
                case 15:

                    break;

                /**
                 *
                 */
                case 16:

                    break;

                /**
                 *
                 */
                case 17:

                    break;

                /**
                 *
                 */
                case 18:

                    break;

                /**
                 *
                 */
                case 19:

                    break;

                /**
                 *
                 */
                case 20:

                    break;

                /**
                 *
                 */
                case 21:

                    break;

                default:

                    break;
            }
        }

        return ((float)($collegeScore)) / $maxScore;
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