<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 3/24/2018
 * Time: 7:32 PM
 */

class CollegeScholarship extends Scholarship
{

    const FIELD_ARTS = 'Visual and Performance Arts';
    const FIELD_BUSINESS = 'Business';
    const FIELD_ENGINEERING = 'Engineering and Technology';
    const FIELD_LIBERAL_ARTS = 'Liberal Arts';
    const FIELD_MEDICAL = 'Medical and Life Science';
    const TYPE_GRANT = "Grant";
    const TYPE_LOAN = "Loan";
    const TYPE_MERIT = "Merit based";
    /**
     * @var int|null
     */
    private $act;
    /**
     * @var string|null
     */
    private $field;
    /**
     * @var int|null
     */
    private $sat;

    /**
     * @param int $pkID
     * @throws Exception
     */
    public function __construct1(int $pkID)
    {
        $dbc = new DatabaseConnection();
        $params = ["i", $pkID];
        $scholarship = $dbc->query("select", "SELECT * FROM tblcollegescholarship WHERE pkcscholarship = ?", $params);
        if ($scholarship) {
            $result = [
                $this->setPkID($pkID),
                $this->setName($scholarship["nmscholarship"]),
                $this->setType($scholarship["entype"]),
                $this->setDescription($scholarship["txdescription"]),
                $this->setRequirements($scholarship["txrequirements"]),
                $this->setField($scholarship["enfield"]),
                $this->setGpa($scholarship["ngpa"]),
                $this->setAct($scholarship["nact"]),
                $this->setSat($scholarship["nsat"]),
                $this->setValue($scholarship["namount"])
            ];
            if (in_array(false, $result, true)) {
                throw new Exception("CollegeScholarship->__construct($pkID) - Unable to construct CollegeScholarship object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
            $this->inDatabase = true;
            $this->synced = true;
        } else {
            throw new Exception("CollegeScholarship->__construct($pkID) - CollegeScholarship not found");
        }
    }

    //TODO: implement constructor for non-existing-in-DB scholarships.

    /**
     * @param string $type
     * @return bool
     */
    public function setType(string $type): bool
    {
        switch ($type) {
            case self::TYPE_GRANT:
            case self::TYPE_LOAN:
            case self::TYPE_MERIT:
                $this->syncHandler($this->type, $this->getType(), $type);
                return true;
            default:
                return false;
        }
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
     * @param Student $student
     * @return bool
     */
    public function isStudentEligible(Student $student): bool
    {
        //If you meet the GPA requirement (if there is one, and if you provided your GPA), ACT requirement, and/or SAT requirement
        return (is_null($this->getGpa()) or (!is_null($student->getGPA()) and $student->getGPA() >= $this->getGpa())) and
            ((is_null($this->getAct()) or (!is_null($student->getAct()) and $student->getAct() >= $this->getAct())) or
                (is_null($this->getSat()) or (!is_null($student->getSat()) and $student->getSat() >= $this->getSat())));
    }

    /**
     * @return int|null
     */
    public function getAct(): ?int
    {
        return $this->act;
    }

    /**
     * @return College
     */
    public function getCollege(): College
    {
        $dbc = new DatabaseConnection();
        $params = ["i", $this->getPkID()];
        $college = $dbc->query("select", "SELECT fkcollegeid FROM tblcollegescholarship WHERE pkcscholarship = ?", $params);
        return new College($college);
    }

    /**
     * @return null|string
     */
    public function getField(): ?string
    {
        return $this->field;
    }

    /**
     * @return int|null
     */
    public function getSat(): ?int
    {
        return $this->sat;
    }

    /**
     * @param int|null $act
     * @return bool
     */
    public function setAct(?int $act): bool
    {
        if (is_null($act) or ($act <= 36 and $act >= 1)) {
            $this->syncHandler($this->gpa, $this->getAct(), $act);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param null|string $field
     * @return bool
     */
    public function setField(?string $field): bool
    {
        switch ($field) {
            case self::FIELD_ARTS:
            case self::FIELD_BUSINESS:
            case self::FIELD_ENGINEERING:
            case self::FIELD_LIBERAL_ARTS:
            case self::FIELD_MEDICAL:
            case null:
                $this->syncHandler($this->field, $this->getField(), $field);
                return true;
                break;
            default:
                return false;
        }
    }

    /**
     * @param int|null $sat
     * @return bool
     */
    public function setSat(?int $sat): bool
    {
        if (is_null($sat) or ($sat <= 1600 and $sat >= 400)) {
            $this->syncHandler($this->sat, $this->getSat(), $sat);
            return true;
        } else {
            return false;
        }
    }
}