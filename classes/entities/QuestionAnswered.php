<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 3/5/2018
 * Time: 3:27 PM
 */

class QuestionAnswered extends DataBasedEntity
{

    /**
     * @var string|int
     */
    private $answer;
    /**
     * @var int
     */
    private $importance;
    /**
     * @var Question
     */
    private $question;
    /**
     * @var Student
     */
    private $student;

    /**
     * @param Question $question
     * @param Student $student
     * @throws Exception
     */
    public function __construct2(Question $question, Student $student)
    {
        $dbc = new DatabaseConnection();
        $params = ["ii", $student->getPkID(), $question->getPkID()];
        $answer = $dbc->query("select", "SELECT * FROM tblprofileanswers WHERE fkuserid = ? AND fkquestionid = ?", $params);
        if ($answer) {
            $result = [
                $this->setQuestion($question),
                $this->setStudent($student),
                $this->setAnswer($answer), //Must occur after setQuestion
                $this->setImportance($answer["nimportant"])
            ];
            if (in_array(false, $result, true)) {
                throw new Exception("QuestionMC->__construct(" . $question->getPkID() . ", " . $student->getPkID() . ") - Unable to construct QuestionAnswered object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
            $this->inDatabase = true;
            $this->synced = true;
        } else {
            throw new Exception("QuestionAnswered->__construct(" . $question->getPkID() . ", " . $student->getPkID() . ") - Unable to find question answer");
        }
    }

    /**
     * @param Question $question
     * @param Student $student
     * @param string|int $answer
     * @param int $importance
     * @throws Exception
     */
    public function __construct4(Question $question, Student $student, $answer, int $importance)
    {
        $result = [
            $this->setQuestion($question),
            $this->setStudent($student),
            $this->setAnswer($answer),
            $this->setImportance($importance)
        ];
        if (in_array(false, $result, true)) {
            throw new Exception("QuestionAnswered->__construct12(" . $question->getPkID() . "," . $student->getEmail() . ",$answer,$importance) - Unable to construct QuestionAnswered object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
        }
        $this->inDatabase = false;
        $this->synced = false;
    }

    /**
     * Since the database table that this class reflects has a multi-field primary key, pkID will be
     * null, to reduce confusion in what exactly the pkID is. Returning an array is possible, but
     * seems tacked on.
     *
     * @return mixed|null
     */
    public function getPkID()
    {
        return null;
    }

    /**
     * @return Student|null
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param Student $student
     * @return bool
     */
    private function setStudent(Student &$student): bool
    {
        $this->syncHandler($this->student, $this->getStudent(), $student);
        return true;
    }

    /**
     * @return string|int|null
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * The $answer parameter must be the result of the
     *
     * @param array $answer
     * @return bool
     */
    public function setAnswer($answer): bool
    {
        $type = get_class($this->getQuestion());
        switch ($type) {
            case "QuestionMC":
                if (gettype($answer) === "array") {
                    $this->syncHandler($this->answer, $this->getAnswer(), $answer["txanswer"]);
                } else {
                    $this->syncHandler($this->answer, $this->getAnswer(), $answer);
                }
                break;
            case "QuestionN":
                if (gettype($answer) === "array") {
                    $this->syncHandler($this->answer, $this->getAnswer(), $answer["nanswer"]);
                } else {
                    $this->syncHandler($this->answer, $this->getAnswer(), $answer);
                }
                break;
            default:
                return false;
        }
        return true;
    }

    /**
     * @return Question|null
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param Question $question
     * @return bool
     */
    public function setQuestion(Question $question): bool
    {
        if(gettype($this->getAnswer()) === "string" and get_class($question) !== "QuestionMC") {
            return false;
        } else if (gettype($this->getAnswer()) === "integer" and get_class($question) !== "QuestionN") {
            return false;
        } else {
            $this->syncHandler($this->question, $this->getQuestion(), $question);
            return true;
        }
    }

    /**
     * @return int|null
     */
    public function getImportance()
    {
        return $this->importance;
    }

    /**
     * You may not call this function until after importance has been set
     *
     * @return int
     */
    public function getWeight(): int
    {
        return 2 ** $this->getImportance();
    }

    /**
     * @param int $importance
     * @return bool
     */
    public function setImportance(int $importance): bool
    {
        if ($importance <= 4 and $importance >= 0) {
            $this->syncHandler($this->importance, $this->getImportance(), $importance);
            return true;
        }
        return false;
    }

    /**
     * Removes the current object from the database.
     * Returns true if the update was completed successfully, false otherwise.
     *
     * @return bool
     */
    public function removeFromDatabase(): bool
    {
        if ($this->isInDatabase()) {
            $dbc = new DatabaseConnection();
            $params = ["ii", $this->getStudent()->getPkID(), $this->getQuestion()->getPkID()];
            $result = $dbc->query("delete", "DELETE FROM tblprofileanswers WHERE fkuserid = ? AND fkquestionid = ?", $params);
            if ($result) {
                $this->inDatabase = false;
                $this->synced = false;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Loads the current object with data from the database to which pkID pertains.
     *
     * @return bool
     */
    public function updateFromDatabase(): bool
    {
        if ($this->isSynced()) {
            return true;
        } elseif ($this->isInDatabase() and !$this->isSynced()) {
            try {
                $this->__construct2($this->getQuestion(), $this->getStudent());
            } catch (Exception $e) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Saves the current object to the database. After execution of this function, inDatabase and synced should both be
     * true.
     *
     * @return bool
     */
    public function updateToDatabase(): bool
    {
        if ($this->isSynced()) {
            return true;
        }
        $dbc = new DatabaseConnection();
        if ($this->getStudent()->isInDatabase()) {
            if (gettype($this->getAnswer()) == "string") {
                $stringAnswer = $this->getAnswer();
                $numberAnswer = null;
            } else {
                $stringAnswer = null;
                $numberAnswer = $this->getAnswer();
            }
            if ($this->isInDatabase()) {
                $params = [
                    "siiii",
                    $stringAnswer,
                    $numberAnswer,
                    $this->getImportance(),
                    $this->getStudent()->getPkID(),
                    $this->getQuestion()->getPkID()
                ];
                $result = $dbc->query("update", "UPDATE `tblprofileanswers` SET 
                                      `txanswer`=?,`nanswer`=?,`nimportant`=?
                                      WHERE `fkuserid`=? AND fkquestionid = ?", $params);
                $this->synced = $result;
            } else {
                $params = [
                    "iisii",
                    $this->getStudent()->getPkID(),
                    $this->getQuestion()->getPkID(),
                    $stringAnswer,
                    $numberAnswer,
                    $this->getImportance()
                ];
                $result = $dbc->query("insert", "INSERT INTO `tblprofileanswers` (`fkuserid`, 
                                          `fkquestionid`, `txanswer`, `nanswer`, `nimportant`) 
                                          VALUES  (?,?,?,?,?)", $params);
                $this->inDatabase = $result;
                $this->synced = $result;
            }
            return (bool)$result;
        } else {
            return false;
        }
    }
}