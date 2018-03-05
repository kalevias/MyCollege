<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 3/5/2018
 * Time: 2:13 PM
 */

abstract class Question
{
    /**
     * @var int
     */
    private $pkID;
    /**
     * @var string
     */
    private $questionText;

    /**
     * Question constructor.
     * @param int $pkID
     * @throws Exception
     */
    public function __construct(int $pkID)
    {
        $dbc = new DatabaseConnection();
        $params = ["i", $pkID];
        $question = $dbc->query("select", "SELECT txquestion FROM tblquestions WHERE pkquestionid = ?", $params);
        if ($question) {
            $result = [
                $this->setPkID($pkID),
                $this->setQuestionText($question["txquestion"])
            ];
            if (in_array(false, $result, true)) {
                throw new Exception("Question->__construct($pkID) - Unable to construct Question object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
        } else {
            throw new Exception("Question->__construct($pkID) - Question not found");
        }
    }

    /**
     * @return int
     */
    public function getPkID(): int
    {
        return $this->pkID;
    }

    /**
     * @return string
     */
    public function getQuestionText(): string
    {
        return $this->questionText;
    }

    /**
     * @param int $pkID
     * @return bool
     */
    private function setPkID(int $pkID): bool
    {
        $this->pkID = $pkID;
        return true;
    }

    /**
     * @param string $questionText
     * @return bool
     */
    private function setQuestionText(string $questionText): bool
    {
        $this->questionText = $questionText;
        return true;
    }
}