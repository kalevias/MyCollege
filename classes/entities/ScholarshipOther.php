<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 3/24/2018
 * Time: 7:33 PM
 */

class ScholarshipOther extends Scholarship
{

    const DISABILITY_CHRONIC = "Cancer/Chronic Illness";
    const DISABILITY_COGNITIVE = "Cognitive/Learning";
    const DISABILITY_HEARING = "Hearing/Auditory";
    const DISABILITY_INVISIBLE = "Invisible";
    const DISABILITY_PHYSICAL = "Physical";
    const DISABILITY_PSYCHOLOGICAL = "Psychological";
    const DISABILITY_VISUAL = "Visual";

    const ETHNICITY_AFRICAN_AMERICAN = "African American";
    const ETHNICITY_ALL_MINORS = "All Minorities";
    const ETHNICITY_ASIAN_PI = "Asian/Pacific Islander";
    const ETHNICITY_EUROPEAN = "European";
    const ETHNICITY_HISPANIC = "Hispanic";
    const ETHNICITY_NATIVE_AMERICAN = "Native American";
    const ETHNICITY_OTHERS = "Other";

    const MILITARY_AIR = "Air Force";
    const MILITARY_AIR_NATIONAL = "Air National Guard";
    const MILITARY_ARMY = "Army";
    const MILITARY_ARMY_NATIONAL = "Army National Guard";
    const MILITARY_COAST = "Coast Guard";
    const MILITARY_MARINES = "Marines";
    const MILITARY_NAVY = "Navy";

    const RELIGION_BAPTIST = "Baptist";
    const RELIGION_BRETHREN = "Brethren";
    const RELIGION_CATHOLIC = "Catholic";
    const RELIGION_CHRISTIAN = "Christian";
    const RELIGION_DISCIPLE = "Disciple of Christ";
    const RELIGION_EPISCOPALIAN = "Episcopalian";
    const RELIGION_ISLAM = "Islam/Muslim Faith";
    const RELIGION_JEWISH = "Jewish";
    const RELIGION_METHODIST = "Methodist";
    const RELIGION_MORMON = "Latter-Day Saints";
    const RELIGION_ORTHODOX = "Eastern Orthodox";
    const RELIGION_PRESBYTERIAN = "Presbyterian";
    const RELIGION_PROTESTANT = "Protestant";

    const TYPE_FELLOWSHIP = "Fellowship";
    const TYPE_GRANT = "Grant";
    const TYPE_LOAN = "Loan";
    const TYPE_PRIZE = "Prize";
    const TYPE_SCHOLARSHIP = "Scholarship";
    /**
     * @var string|null
     */
    private $disability;
    /**
     * @var string|null
     */
    private $ethnicity;
    /**
     * @var string|null
     */
    private $military;
    /**
     * @var string|null
     */
    private $religion;
    /**
     * @var bool
     */
    private $renewable;
    /**
     * @var string
     */
    private $sponsor;

    /**
     * @return null|string
     */
    public function getDisability(): ?string
    {
        return $this->disability;
    }

    /**
     * @return null|string
     */
    public function getEthnicity(): ?string
    {
        return $this->ethnicity;
    }

    /**
     * @return null|string
     */
    public function getMilitary(): ?string
    {
        return $this->military;
    }

    /**
     * @return null|string
     */
    public function getReligion(): ?string
    {
        return $this->religion;
    }

    /**
     * @return string|null
     */
    public function getSponsor(): ?string
    {
        return $this->sponsor;
    }

    /**
     * @return bool|null
     */
    public function isRenewable(): ?bool
    {
        return $this->renewable;
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

    /**
     * @param int $pkID
     * @throws Exception
     */
    public function __construct1(int $pkID)
    {
        $dbc = new DatabaseConnection();
        $params = ["i", $pkID];
        $scholarship = $dbc->query("select", "SELECT * FROM tblotherscholarship WHERE pkoscholarship = ?", $params);
        if ($scholarship) {
            $result = [
                $this->setPkID($pkID),
                $this->setName($scholarship["nmscholarship"]),
                $this->setType($scholarship["entype"]),
                $this->setDescription($scholarship["txdescription"]),
                $this->setRequirements($scholarship["txrequirements"]),
                $this->setGpa($scholarship["ngpa"]),
                $this->setValue($scholarship["namount"]),
                $this->setSponsor($scholarship["nmorganization"]),
                $this->setEthnicity($scholarship["enethnicity"]),
                $this->setReligion($scholarship["enreligion"]),
                $this->setMilitary($scholarship["enmilitary"]),
                $this->setDisability($scholarship["endisability"]),
                $this->setRenewable($scholarship["isrenewable"])
            ];
            if (in_array(false, $result, true)) {
                throw new Exception("ScholarshipOther->__construct($pkID) - Unable to construct ScholarshipOther object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
            $this->inDatabase = true;
            $this->synced = true;
        } else {
            throw new Exception("ScholarshipOther->__construct($pkID) - ScholarshipOther not found");
        }
    }

    /**
     * @param string $type
     * @return bool
     */
    public function setType(string $type): bool
    {
        switch ($type) {
            case self::TYPE_GRANT:
            case self::TYPE_LOAN:
            case self::TYPE_SCHOLARSHIP:
            case self::TYPE_FELLOWSHIP:
            case self::TYPE_PRIZE:
                $this->syncHandler($this->type, $this->getType(), $type);
                return true;
            default:
                return false;
        }
    }

    /**
     * @param Student $student
     * @return bool
     */
    public function isStudentEligible(Student $student): bool
    {
        try {
            $answer = $answer2 = null;
            $inMilitary = QuestionHandler::isQuestionAnswered($student, new QuestionMC(19));
            if ($inMilitary) $answer = QuestionHandler::getStudentAnswer($student, new QuestionMC(19));
            $hasDisability = QuestionHandler::isQuestionAnswered($student, new QuestionMC(21));
            if ($hasDisability) $answer2 = QuestionHandler::getStudentAnswer($student, new QuestionMC(21));

            return (is_null($this->getGpa()) or (!is_null($student->getGPA()) and $student->getGPA() >= $this->getGpa())) and
                (is_null($this->getMilitary()) or ($inMilitary and isset($answer) and $answer->getAnswer() === $this->getMilitary())) and
                (is_null($this->getDisability()) or ($hasDisability and isset($answer2)  and $answer2->getAnswer() === $this->getDisability()));
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param null|string $disability
     * @return bool
     */
    public function setDisability(?string $disability): bool
    {
        switch ($disability) {
            case self::DISABILITY_VISUAL:
            case self::DISABILITY_HEARING:
            case self::DISABILITY_PHYSICAL:
            case self::DISABILITY_COGNITIVE:
            case self::DISABILITY_PSYCHOLOGICAL:
            case self::DISABILITY_INVISIBLE:
            case self::DISABILITY_CHRONIC:
            case null:
                $this->syncHandler($this->disability, $this->getDisability(), $disability);
                return true;
            default:
                return false;
        }
    }

    /**
     * @param null|string $ethnicity
     * @return bool
     */
    public function setEthnicity(?string $ethnicity): bool
    {
        switch ($ethnicity) {
            case self::ETHNICITY_AFRICAN_AMERICAN:
            case self::ETHNICITY_ALL_MINORS:
            case self::ETHNICITY_ASIAN_PI:
            case self::ETHNICITY_EUROPEAN:
            case self::ETHNICITY_HISPANIC:
            case self::ETHNICITY_NATIVE_AMERICAN:
            case self::ETHNICITY_OTHERS:
            case null:
                $this->syncHandler($this->ethnicity, $this->getEthnicity(), $ethnicity);
                return true;
            default:
                return false;
        }
    }

    /**
     * @param null|string $military
     * @return bool
     */
    public function setMilitary(?string $military): bool
    {
        switch ($military) {
            case self::MILITARY_AIR:
            case self::MILITARY_ARMY:
            case self::MILITARY_NAVY:
            case self::MILITARY_MARINES:
            case self::MILITARY_COAST:
            case self::MILITARY_AIR_NATIONAL:
            case self::MILITARY_ARMY_NATIONAL:
            case null:
                $this->syncHandler($this->military, $this->getMilitary(), $military);
                return true;
            default:
                return false;
        }
    }

    /**
     * @param null|string $religion
     * @return bool
     */
    public function setReligion(?string $religion): bool
    {

        switch ($religion) {
            case self::RELIGION_JEWISH:
            case self::RELIGION_CATHOLIC:
            case self::RELIGION_ISLAM:
            case self::RELIGION_BAPTIST:
            case self::RELIGION_BRETHREN:
            case self::RELIGION_CHRISTIAN:
            case self::RELIGION_DISCIPLE:
            case self::RELIGION_ORTHODOX:
            case self::RELIGION_EPISCOPALIAN:
            case self::RELIGION_MORMON:
            case self::RELIGION_METHODIST:
            case self::RELIGION_PRESBYTERIAN:
            case self::RELIGION_PROTESTANT:
            case null:
                $this->syncHandler($this->religion, $this->getReligion(), $religion);
                return true;
            default:
                return false;
        }
    }

    /**
     * @param bool $renewable
     * @return bool
     */
    public function setRenewable(bool $renewable): bool
    {
        $this->syncHandler($this->renewable, $this->isRenewable(), $renewable);
        return true;
    }

    /**
     * @param string $sponsor
     * @return bool
     */
    public function setSponsor(string $sponsor): bool
    {
        $this->syncHandler($this->sponsor, $this->getSponsor(), $sponsor);
        return true;
    }
}