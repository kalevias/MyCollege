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
     * @var mixed
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
    public function __construct2(Question $question, Student &$student)
    {
        $dbc = new DatabaseConnection();
        $params = ["ii", $student->getPkID(), $question->getPkID()];
        $answer = $dbc->query("select", "SELECT * FROM tblprofileanswers WHERE fkuserid = ? AND fkquestionid = ?", $params);
        if($answer) {
            $result = [
                $this->setQuestion($question),
                $this->setStudent($student),
                $this->setAnswer($answer)
            ];
        } else {
            throw new Exception("QuestionAnswered->__construct(".$question->getPkID().", ".$student->getPkID().") - No multiple choice answers found");
        }
    }

    public function __construct3(Question $question, Student $student, $answer, int $importance)
    {

    }

    public function getPkID()
    {
        return null;
    }

    /**
     * @return Student
     */
    public function getStudent(): Student
    {
        return $this->student;
    }

    /**
     * @param Student $student
     * @return bool
     */
    public function setStudent(Student &$student): bool
    {
        $this->student = $student;
        return true;
    }

    /**
     * @return mixed
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param $answer
     * @return bool
     */
    public function setAnswer($answer): bool
    {
        $type = get_class($this->getQuestion());
        switch ($type) {
            case "QuestionMC":
                $this->answer = $answer["txanswer"];
                break;
            case "QuestionN":
                //TODO: implement this class and it's handling (if needed later)
                break;
            default:
                return false;
        }
        $this->answer = $answer;
        return true;
    }

    /**
     * @return Question
     */
    public function getQuestion(): Question
    {
        return $this->question;
    }

    /**
     * @param Question $question
     * @return bool
     */
    public function setQuestion(Question $question): bool
    {
        $this->question = $question;
        return true;
    }

    /**
     * @return int
     */
    public function getImportance(): int
    {
        return $this->importance;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return 2 ** $this->getImportance();
    }

    /**
     * Removes the current object from the database.
     * Returns true if the update was completed successfully, false otherwise.
     *
     * @return bool
     */
    public function removeFromDatabase(): bool
    {
        // TODO: Implement removeFromDatabase() method.
    }

    /**
     * Loads the current object with data from the database to which pkID pertains.
     *
     * @return bool
     */
    public function updateFromDatabase(): bool
    {
        // TODO: Implement updateFromDatabase() method.
    }

    /**
     * Saves the current object to the database. After execution of this function, inDatabase and synced should both be
     * true.
     *
     * @return bool
     */
    public function updateToDatabase(): bool
    {
        // TODO: Implement updateToDatabase() method.
    }
}