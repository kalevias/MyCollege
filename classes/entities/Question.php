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
     * @var Dependency[]
     */
    private $dependencies;
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

            $this->setDependencies([]);
            $params = ["i", $this->getPkID()];
            $dependencies = $dbc->query("select multiple", "SELECT fkqparent FROM tblquestionorder WHERE fkquestionid = ?", $params);
            if ($dependencies) {
                foreach ($dependencies as $dependency) {
                    $result[] = $this->addDependency(new Dependency($this, $dependency["fkqparent"]));
                }
            }

            if (in_array(false, $result, true)) {
                throw new Exception("Question->__construct($pkID) - Unable to construct Question object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
        } else {
            throw new Exception("Question->__construct($pkID) - Question not found");
        }
    }

    /**
     * @return Dependency[]
     */
    public function getDependencies()
    {
        return $this->dependencies;
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
     * @param Dependency $dependency
     * @return bool|int
     */
    private function addDependency(Dependency $dependency)
    {
        return array_push($this->dependencies, $dependency);
    }

    /**
     * @param $dependencies
     * @return bool
     */
    private function setDependencies($dependencies): bool
    {
        $this->dependencies = $dependencies;
        return true;
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