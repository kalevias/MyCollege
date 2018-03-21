<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/20/2018
 * Time: 11:34 PM
 */

class Student extends User
{
    const MODE_EduprofileID = 3;
    const MODE_UserID = 4;
    /**
     * What did the student get on the ACT test?
     *
     * @var int
     */
    private $ACT;
    /**
     * Has the student taken AP classes?
     *
     * @var bool
     */
    private $AP;
    /**
     * What is the student's GPA on a 4-point scale?
     *
     * @var float
     */
    private $GPA;
    /**
     * What did the student get on the SAT test?
     *
     * @var int
     */
    private $SAT;
    /**
     * @var QuestionAnswered[]
     */
    private $answeredQuestions;
    /**
     * When (usually a year) would the student like to enter higher education?
     *
     * @var DateTime
     */
    private $desiredCollegeEntry;
    /**
     * How long the student would like to remain in college
     *
     * @var DateInterval
     */
    private $desiredCollegeLength;
    /**
     * The most preferred major of the student. May be, "undecided."
     *
     * @var Major
     */
    private $desiredMajor;
    /**
     * @var bool
     */
    private $gender;
    /**
     * How much money can the student and their family expect to save, per year, for educational expenses?
     *
     * @var int
     */
    private $householdIncome;
    /**
     * If the student's desired Major is, "undecided," then which majors are they interested in? (max length of 3)
     *
     * @var Major[]
     */
    private $preferredMajors;

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $altEmail
     * @param string $streetAddress
     * @param string $city
     * @param Province $province
     * @param int $postalCode
     * @param int $phone
     * @param int $gradYear
     * @param string $password
     * @param bool $active
     * @param bool $women
     * @throws Exception
     */
    public function __construct13(string $firstName, string $lastName, string $email, string $altEmail, string $streetAddress, string $city, Province $province, int $postalCode, int $phone, int $gradYear, string $password, bool $active, bool $women)
    {
        parent::__construct12($firstName, $lastName, $email, $altEmail, $streetAddress, $city, $province, $postalCode, $phone, $gradYear, $password, $active);
        $result = [
            $this->setGender($women)
        ];
        if (in_array(false, $result, true)) {
            throw new Exception("Student->__construct12($firstName, $lastName, $email, $altEmail, $streetAddress, $city, ".$province->getISO().", $postalCode, $phone, $gradYear, $password, $active, $women) - Unable to construct User object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
        }
    }

    /**
     * @param int $identifier
     * @param int $mode
     * @throws Exception
     */
    public function __construct2($identifier, int $mode = self::MODE_UserID)
    {
        $dbc = new DatabaseConnection();
        $foundID = $mode;
        if ($mode == self::MODE_UserID) {
            $foundID = self::MODE_DbID;
        } else if ($mode == self::MODE_EduprofileID) {
            $params = ["i", $identifier];
            $identifier = $dbc->query("select", "SELECT fkuserid FROM tbleduprofile WHERE pkeduprofileid = ?", $params)["fkuserid"];
            $foundID = self::MODE_DbID;
        }
        parent::__construct2($identifier, $foundID);
        $this->inDatabase = false;
        $this->synced = false;

        $params = ["i", $this->getPkID()];
        $student = $dbc->query("select", "SELECT * FROM `tbleduprofile` WHERE `fkuserid`=?", $params);

        if ($student) {
            $result = [
                $this->setACT($student["nact"]),
                $this->setAP($student["hadap"]),
                $this->setDesiredCollegeEntry((new DateTime())->setDate($student["dtentry"], 1, 1)),
                $this->setDesiredCollegeLength(new DateInterval("P" . $student["ncollegelength"] . "Y")),
                $this->setDesiredMajor(new Major($student["fkmajorid"])),
                $this->setGPA($student["ngpa"]),
                $this->setHouseholdIncome($student["nhouseincome"]),
                $this->setSAT($student["nsat"]),
                $this->setGender($student["isgender"])
            ];

            $this->removeAllPreferredMajors();
            is_null($student["fkmajor1"]) ?: $result[] = $this->addPreferredMajor(new Major($student["fkmajor1"]));
            is_null($student["fkmajor2"]) ?: $result[] = $this->addPreferredMajor(new Major($student["fkmajor2"]));
            is_null($student["fkmajor3"]) ?: $result[] = $this->addPreferredMajor(new Major($student["fkmajor3"]));

            $this->removeAllAnsweredQuestions();
            $params = ["i", $this->getPkID()];
            $answeredQuestions = $dbc->query("select multiple", "SELECT fkquestionid FROM tblprofileanswers WHERE fkuserid = ?", $params);

            if ($answeredQuestions) {
                foreach ($answeredQuestions as $answeredQuestion) {
                    $question = new QuestionMC($answeredQuestion["fkquestionid"]);
                    $answer = new QuestionAnswered($question, $this);
                    $result[] = $this->addAnsweredQuestion($answer);
                }
            }

            if (in_array(false, $result, true)) {
                throw new Exception("Student->__construct2($identifier, $mode) - Unable to construct Student object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }

            $this->inDatabase = true;
            $this->synced = true;
        } else {
            throw new InvalidArgumentException("Student->__construct2($identifier, $mode) - Student not found");
        }
    }

    /**
     * Loads a user from the database.
     *
     * @param string|int $identifier May be either user email or ID
     * @param int $mode
     * @return null|User
     */
    public static function load($identifier, int $mode = self::MODE_NAME)
    {
        try {
            return new Student($identifier, $mode);
        } catch (InvalidArgumentException $iae) {
            return null;
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
        if ($this->isInDatabase()) {
            $dbc = new DatabaseConnection();
            $params = ["i", $this->getPkID()];
            $result = $dbc->query("delete", "DELETE FROM tblEduProfile WHERE fkuserid = ?", $params);
            if ($result) {
                $this->inDatabase = false;
                $this->synced = false;
                return parent::removeFromDatabase();
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
                $this->__construct2($this->getPkID(), self::MODE_UserID);
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
        //Check if current object is already syncronized to database
        if ($this->isSynced()) {
            return true;
        } else if (parent::updateToDatabase()) {
            if ($this->isInDatabase()) {

                $dbc = new DatabaseConnection();
                $preferredMajors = $this->getPreferredMajors();
                while (count($preferredMajors) < 3) {
                    $preferredMajors[] = null;
                }
                foreach ($preferredMajors as &$preferredMajor) {
                    if (gettype($preferredMajor) == "object") {
                        $preferredMajor = $preferredMajor->getPkID();
                    }
                }
                $params = [
                    "iidiiiiiiiiii",
                    $this->getACT(),
                    $this->isAP(),
                    $this->getGPA(),
                    $this->getSAT(),
                    ((int)$this->getDesiredCollegeEntry()->format("Y")),
                    $this->getDesiredCollegeLength()->y,
                    $this->getDesiredMajor()->getPkID(),
                    $preferredMajors[0],
                    $preferredMajors[1],
                    $preferredMajors[2],
                    $this->getHouseholdIncome(),
                    $this->isGender(),
                    $this->getPkID()
                ];
                $result = $dbc->query("update", "UPDATE tbleduprofile SET nact=?, hadap=?, ngpa=?, nsat=?, 
							  dtentry=?, ncollegelength=?, fkmajorid=?, fkmajor1=?, fkmajor2=?, fkmajor3=?, 
							  nhouseincome=?, isgender=? WHERE fkuserid=?", $params);
            } else {
                $dbc = new DatabaseConnection();
                $preferredMajors = $this->getPreferredMajors();
                while (count($preferredMajors) < 3) {
                    $preferredMajors[] = null;
                }
                foreach ($preferredMajors as &$preferredMajor) {
                    if (gettype($preferredMajor) == "object") {
                        $preferredMajor = $preferredMajor->getPkID();
                    }
                }
                $params = [
                    "iiiiidiiiiiii",
                    $this->getPkID(),
                    is_null($this->getDesiredMajor()) ? null : $this->getDesiredMajor()->getPkID(),
                    $preferredMajors[0],
                    $preferredMajors[1],
                    $preferredMajors[2],
                    $this->getGPA(),
                    $this->getACT(),
                    $this->getSAT(),
                    $this->isAP(),
                    $this->getHouseholdIncome(),
                    is_null($this->getDesiredCollegeEntry()) ? null : ((int)$this->getDesiredCollegeEntry()->format("Y")),
                    is_null($this->getDesiredCollegeLength()) ? null : $this->getDesiredCollegeLength()->y,
                    $this->isGender()
                ];
                $result = $dbc->query("insert", "INSERT INTO tbleduprofile (fkuserid, fkmajorid, fkmajor1, 
                                                        fkmajor2, fkmajor3, ngpa, nact, nsat, hadap, nhouseincome, 
                                                        dtentry, ncollegelength, isgender) VALUES 
                                                        (?,?,?,?,?,?,?,?,?,?,?,?,?)", $params);
            }
            $this->inDatabase = $result;

            if(!is_null($this->getAnsweredQuestions())) {
                foreach($this->getAnsweredQuestions() as $answeredQuestion) {
                    $answeredQuestion->removeFromDatabase();
                    $result = ($result and $answeredQuestion->updateToDatabase());
                }
            }

            $this->inDatabase = $result;
            $this->synced = $result;
            return (bool)$result;
        } else {
            return false;
        }
    }

    /**
     * @param QuestionAnswered $answeredQuestion
     * @return bool|int
     */
    public function addAnsweredQuestion(QuestionAnswered $answeredQuestion)
    {
        if (in_array($answeredQuestion, $this->getAnsweredQuestions())) {
            return false;
        } else {
            $this->synced = false;
            return array_push($this->answeredQuestions, $answeredQuestion);
        }
    }

    /**
     * @param Major $major
     * @return int|bool
     */
    public function addPreferredMajor(Major $major)
    {
        if (in_array($major, $this->getPreferredMajors())) {
            return false;
        } else {
            $this->synced = false;
            return array_push($this->preferredMajors, $major);
        }
    }

    /**
     * @return int|null
     */
    public function getACT()
    {
        return $this->ACT;
    }

    /**
     * @return QuestionAnswered[]|null
     */
    public function getAnsweredQuestions()
    {
        return $this->answeredQuestions;
    }

    /**
     * @return DateTime|null
     */
    public function getDesiredCollegeEntry()
    {
        return $this->desiredCollegeEntry;
    }

    /**
     * @return DateInterval|null
     */
    public function getDesiredCollegeLength()
    {
        return $this->desiredCollegeLength;
    }

    /**
     * @return Major|null
     */
    public function getDesiredMajor()
    {
        return $this->desiredMajor;
    }

    /**
     * @return float|null
     */
    public function getGPA()
    {
        return $this->GPA;
    }

    /**
     * @return int|null
     */
    public function getHouseholdIncome()
    {
        return $this->householdIncome;
    }

    /**
     * @return Major[]|null
     */
    public function getPreferredMajors()
    {
        return $this->preferredMajors;
    }

    /**
     * @return int|null
     */
    public function getSAT()
    {
        return $this->SAT;
    }

    /**
     * @return bool|null
     */
    public function isAP()
    {
        return $this->AP;
    }

    /**
     * @return bool
     */
    public function isGender()
    {
        return $this->gender;
    }

    /**
     * @return bool
     */
    public function removeAllAnsweredQuestions(): bool
    {
        $this->syncHandler($this->answeredQuestions, $this->getAnsweredQuestions(), []);
        return true;
    }

    /**
     * @return bool
     */
    public function removeAllPreferredMajors(): bool
    {
        $this->syncHandler($this->preferredMajors, $this->getPreferredMajors(), []);
        return true;
    }

    /**
     * @param int $act
     * @return bool
     */
    public function setACT(int $act): bool
    {
        if ($act <= 36 and $act >= 1) {
            $this->syncHandler($this->ACT, $this->getAct(), $act);
            return true;
        }
        return false;
    }

    /**
     * @param bool $AP
     * @return bool
     */
    public function setAP(bool $AP): bool
    {
        $this->syncHandler($this->AP, $this->isAP(), $AP);
        return true;
    }

    /**
     * @param DateTime $desiredCollegeEntry
     * @return bool
     */
    public function setDesiredCollegeEntry(DateTime $desiredCollegeEntry): bool
    {
        if ($desiredCollegeEntry > new DateTime()) {
            $this->syncHandler($this->desiredCollegeEntry, $this->getDesiredCollegeEntry(), $desiredCollegeEntry);
            return true;
        }
        return false;
    }

    /**
     * @param DateInterval $desiredCollegeLength
     * @return bool
     */
    public function setDesiredCollegeLength(DateInterval $desiredCollegeLength): bool
    {
        $this->syncHandler($this->desiredCollegeLength, $this->getDesiredCollegeLength(), $desiredCollegeLength);
        return true;
    }

    /**
     * @param Major $desiredMajor
     * @return bool
     */
    public function setDesiredMajor(Major $desiredMajor): bool
    {
        $this->syncHandler($this->desiredMajor, $this->getDesiredMajor(), $desiredMajor);
        return true;
    }

    //TODO: add in resume and transcript handling (if useful...?)

    /**
     * @param float $gpa
     * @return bool
     */
    public function setGPA(float $gpa): bool
    {
        if ($gpa >= 0 and $gpa <= 4) {
            $this->syncHandler($this->GPA, $this->getGpa(), $gpa);
            return true;
        }
        return false;
    }

    /**
     * @param bool $women
     * @return bool
     */
    public function setGender(bool $women)
    {
        $this->syncHandler($this->gender, $this->isGender(), $women);
        return true;
    }

    /**
     * @param int $householdIncome
     * @return bool
     */
    public function setHouseholdIncome(int $householdIncome): bool
    {
        if ($householdIncome >= 0) {
            $this->syncHandler($this->householdIncome, $this->getHouseholdIncome(), $householdIncome);
            return true;
        }
        return false;
    }

    /**
     * @param int $sat
     * @return bool
     */
    public function setSAT(int $sat): bool
    {
        if ($sat <= 1600 and $sat >= 400) {
            $this->syncHandler($this->SAT, $this->getSat(), $sat);
            return true;
        }
        return false;
    }
}