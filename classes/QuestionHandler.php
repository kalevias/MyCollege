<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 3/20/2018
 * Time: 8:51 PM
 */

class QuestionHandler
{
    /**
     * Returns the most recently answered question from a user which could also be answered again based on
     * question dependencies.
     *
     * @param Student $student
     * @return Question
     */
    public static function getCurrentQuestion(Student $student)
    {
        $aq = $student->getAnsweredQuestions();
        if (!is_null($aq) and count($aq) > 0) {
            $answered = [];
            foreach ($aq as $a) {
                $answered[] = $a->getQuestion();
            }
            foreach (array_reverse($answered) as $item) {
                if (self::checkQuestionDependency($student, $item)) {
                    return $item;
                }
            }
        }
        return null;
    }

    /**
     * Returns the next question a user can answer given question dependencies.
     *
     * @param Student $student
     * @return Question|null
     */
    public static function getNextQuestion(Student $student)
    {
        $unanswered = self::getUnansweredQuestions($student);
        foreach ($unanswered as $question) {
            if (self::checkQuestionDependency($student, $question)) {
                return $question;
            }
        }
        return null;
    }

    /**
     * @param Student $student
     * @param int $n
     * @return Question|null
     */
    public static function getNthQuestion(Student $student, int $n)
    {
        if ($n < count($student->getAnsweredQuestions())) {
            return $student->getAnsweredQuestions()[$n]->getQuestion();
        } else {
            return self::getUnansweredQuestions($student)[$n];
        }
    }

    /**
     * Returns the index for the specified question, considering which questions have been answered already by the given
     * student, and which have yet to be answered. Returns -1 if the question cannot be found.
     *
     * @param Student $student
     * @param Question $question
     * @return int
     */
    public static function getQuestionIndex(Student $student, Question $question): int
    {
        $aq = $student->getAnsweredQuestions();
        $answered = [];
        if (!is_null($aq) and count($aq) > 0) {
            foreach ($aq as $a) {
                $answered[] = $a->getQuestion();
            }
        }

        $questions = array_merge($answered, self::getUnansweredQuestions($student));
        $IDs = [];
        /**
         * @var $questions Question[]
         */
        foreach ($questions as $q) {
            $IDs[] = $q->getPkID();
        }
        return array_search($question->getPkID(), $IDs, true);
    }

    /**
     * Returns the second most recently answered question from a user which could also be answered again based on
     * question dependencies.
     *
     * @param Student $student
     * @return Question|null
     */
    public static function getPreviousQuestion(Student $student)
    {
        $aq = $student->getAnsweredQuestions();
        if (!is_null($aq) and count($aq) > 0) {
            $answered = [];
            foreach ($aq as $a) {
                $answered[] = $a->getQuestion();
            }
            foreach (array_reverse(array_slice($answered, 1)) as $item) {
                if (self::checkQuestionDependency($student, $item)) {
                    return $item;
                }
            }
        }
        return null;
    }

    /**
     * Returns the QuestionAnswered object for the student if the student has responded to the given question.
     *
     * @param Student $student
     * @param Question $question
     * @return QuestionAnswered
     */
    public static function getStudentAnswer(Student $student, Question $question)
    {
        $aq = $student->getAnsweredQuestions();
        if (!is_null($aq) and count($aq) > 0) {
            $answered = [];
            foreach ($aq as $a) {
                $answered[] = $a->getQuestion();
            }
            for ($i = 0; $i < count($answered); $i++) {
                if ($answered[$i] === $question) {
                    return $aq[$i];
                }
            }
        }
        return null;
    }

    /**
     * Returns an array of questions that have yet to be answered by the student
     *
     * @param Student $student
     * @return Question[]
     */
    public static function getUnansweredQuestions(Student $student)
    {
        $dbc = new DatabaseConnection();
        $params = ["i", $student->getPkID()];
        $questionIDs = $dbc->query("select multiple", "SELECT pkquestionid FROM tblquestions 
                                                                    WHERE pkquestionid NOT IN 
                                                                    (SELECT fkquestionid FROM tblprofileanswers
                                                                      WHERE fkuserid = ?)", $params);
        $output = [];
        if ($questionIDs) {
            try {
                foreach ($questionIDs as $questionID) {
                    $output[] = new QuestionMC($questionID["pkquestionid"]);
                }
            } catch (Exception | Error $e) {
                return [];
            }
        }
        return $output;
    }

    /**
     * Returns an array of questions that have yet to be answered by the student, taking account of depdendencies.
     * For example, if a question's prerequisite's haven't been met, then it won't show up in the output list.
     *
     * @param Student $student
     * @return Question[]
     */
    public static function getAvailableUnansweredQuestions(Student $student)
    {
        $output = self::getUnansweredQuestions($student);
        foreach ($output as &$question) {
            if (!self::checkQuestionDependency($student, $question)) {
                unset($question);
            }
        }
        return array_values($output);
    }

    /**
     * Checks to see if the given question has been answered by the user
     *
     * @param Student $student
     * @param Question $question
     * @return bool
     */
    public static function isQuestionAnswered(Student $student, Question $question): bool
    {
        $aq = $student->getAnsweredQuestions();
        if (!is_null($aq) and count($aq) > 0) {
            $answered = [];
            foreach ($aq as $a) {
                $answered[] = $a->getQuestion()->getPkID();
            }
            return in_array($question->getPkID(), $answered, true);
        }
        return false;
    }

    /**
     * @param Student $student
     * @param Question $question
     * @param $answer
     * @param int $importance
     * @return bool
     */
    public static function saveAnswer(Student $student, Question $question, $answer, int $importance): bool
    {
        if (self::isQuestionAnswered(Controller::getLoggedInUser(), $question)) {
            $answered = $student->getAnsweredQuestions();
            $student->removeAllAnsweredQuestions();
            foreach ($answered as $item) {
                if ($item->getQuestion()->getPkID() === $question->getPkID()) {
                    $item->removeFromDatabase();
                    $student->addAnsweredQuestion(new QuestionAnswered($question, $student, $answer, $importance));
                } else {
                    $student->addAnsweredQuestion($item);
                }
            }
        } else {
            $student->addAnsweredQuestion(new QuestionAnswered($question, $student, $answer, $importance));
        }
        return $student->updateToDatabase();
    }

    /**
     * Checks to see if the specified question can be asked to the given student based on the dependencies of the
     * given question and what questions the student has already answered.
     *
     * Will not always return true if the question has already been answered by the student. For example, if a student
     * answers a child question, then changes the answer to the parent question, and then decides to try to answer
     * the child question again.
     *
     * @param Student $student
     * @param Question $question
     * @return bool
     */
    private static function checkQuestionDependency(Student $student, Question $question): bool
    {
        if (empty($question->getDependencies())) {
            return true;
        } else {
            $haystack = $student->getAnsweredQuestions();
            for ($i = 0; $i < count($haystack); $i++) {
                $haystack[$i] = $haystack[$i]->getQuestion()->getPkID();
            }
            foreach ($question->getDependencies() as $dependency) {
                if ($index = array_search($dependency->getParentID(), $haystack, true)) {
                    $studentAnswer = $student->getAnsweredQuestions()[$index];
                    if ($dependency->getRequiredAnswer() !== $studentAnswer->getAnswer()) {
                        return false;
                    }
                } else {
                    return false;
                }
            }
            return true;
        }
    }
}