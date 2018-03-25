<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 3/19/2018
 * Time: 3:58 PM
 */

//This class is only used in the Question abstract class for establishing dependencies between questions
//as an instance of the question class cannot be used since the class is abstract.
class Dependency
{
    /**
     * @var int
     */
    private $parent;
    /**
     * @var string|int|null
     */
    private $requiredAnswer;

    /**
     * Dependency constructor.
     * @param Question $question
     * @param int $parentID
     * @throws Exception
     */
    public function __construct(Question $question, int $parentID)
    {
        $dbc = new DatabaseConnection();
        $params = ["ii", $question->getPkID(), $parentID];
        $answer = $dbc->query("select", "SELECT jsanswer FROM tblquestionorder WHERE fkquestionid = ? AND fkqparent = ?", $params);
        if ($answer) {
            $result = [
                $this->setParentID($parentID),
                $this->setRequiredAnswer($answer["jsanswer"])
            ];
            if (in_array(false, $result, true)) {
                throw new Exception("Depandency->__construct({$question->getPkID()}, $parentID) - Unable to construct Depandency object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
        } else {
            throw new Exception("Depandency->__construct({$question->getPkID()}, $parentID) - Answer not found");
        }
    }

    /**
     * @return int
     */
    public function getParentID(): int
    {
        return $this->parent;
    }

    /**
     * @return int|null|string
     */
    public function getRequiredAnswer()
    {
        return $this->requiredAnswer;
    }

    /**
     * @param $parent
     * @return bool
     */
    private function setParentID($parent): bool
    {
        $this->parent = $parent;
        return true;
    }

    /**
     * @param $requiredAnswer
     * @return bool
     */
    private function setRequiredAnswer($requiredAnswer): bool
    {
        $this->requiredAnswer = json_decode($requiredAnswer);
        return true;
    }
}