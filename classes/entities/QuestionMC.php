<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 3/5/2018
 * Time: 2:44 PM
 */

class QuestionMC extends Question
{
    /**
     * @var array
     */
    private $answers;

    /**
     * QuestionMC constructor.
     * @param $pkID
     * @throws Exception
     */
    public function __construct(int $pkID)
    {
        parent::__construct($pkID);

        $dbc = new DatabaseConnection();
        $params = ["i", $this->getPkID()];
        $answers = $dbc->query("select multiple", "SELECT txanswer FROM tblanswer WHERE fkquestionid = ?", $params);
        if ($answers) {
            $result = [];
            foreach($answers as $answer) {
                $result[] = $this->addAnswer($answer["txanswer"]);
            }
            if (in_array(false, $result, true)) {
                throw new Exception("QuestionMC->__construct($pkID) - Unable to construct QuestionMC object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
        } else {
            throw new Exception("QuestionMC->__construct($pkID) - No multiple choice answers found");
        }
    }

    /**
     * @param string $json
     * @return bool|int
     */
    public function addAnswer(string $json) {
        $answer = json_decode($json, true);
        if (in_array($answer, $this->getAnswers())) {
            return false;
        } else {
            return array_push($this->answers, $answer);
        }
    }

    /**
     * @return array
     */
    public function getAnswers(): array {
        return $this->answers;
    }
}