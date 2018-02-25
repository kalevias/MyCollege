<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/20/2018
 * Time: 11:34 PM
 */

class EduProfile extends DataBasedEntity //Should extend the User class to a Student, and then have eduprofile as tacked on stuff
{
    //TODO: extend User class to Student, and handle all eduprofile stuff there instead of in a separate class
    const MODE_EDUPROFILEID = 1;
    const MODE_USERID = 2;
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
     * @param int $identifier
     * @param int $mode
     * @throws Exception
     */
    public function __construct2(int $identifier, int $mode = self::MODE_USERID)
    {
        //TODO: finish constructor implementation, specifically with regard to adding preferred majors
        $dbc = new DatabaseConnection();
        if ($mode === self::MODE_EDUPROFILEID) {
            $params = ["i", $identifier];
            $eduprofile = $dbc->query("select", "SELECT * FROM `tbleduprofile` WHERE `pkeduprofileid`=?", $params);
        } else {
            $params = ["s", $identifier];
            $eduprofile = $dbc->query("select", "SELECT * FROM `tbleduprofile` WHERE `fkuserid`=?", $params);
        }

        if ($eduprofile) {
            $result = [
                $this->setPkID($eduprofile["pkeduprofileid"]),
                $this->setACT($eduprofile["nact"]),
                $this->setAP($eduprofile["hadap"]),
                $this->setDesiredCollegeEntry($eduprofile["dtentry"]),
                $this->setDesiredCollegeLength($eduprofile["ncollegelength"]),
                $this->setDesiredMajor($eduprofile["fkmajorid"]),
                $this->setGPA($eduprofile["ngpa"]),
                $this->setHouseholdIncome($eduprofile["nhouseincome"]),
                $this->setSAT($eduprofile["nsat"])
            ];
            if (in_array(false, $result, true)) {
                throw new Exception("EduProfile->__construct2($identifier, $mode) - Unable to construct EduProfile object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
            $this->inDatabase = true;
            $this->synced = true;
        } else {
            throw new InvalidArgumentException("EduProfile->__construct2($identifier, $mode) - EduProfile not found");
        }
    }

    /**
     * @param bool $AP
     * @param int $ACT
     * @param DateTime $desiredCollegeEntry
     * @param DateInterval $desiredCollegeLength
     * @param Major $desiredMajor
     * @param float $GPA
     * @param int $householdIncome
     * @param int $SAT
     */
    public function __construct8(bool $AP, int $ACT, DateTime $desiredCollegeEntry, DateInterval $desiredCollegeLength, Major $desiredMajor, float $GPA, int $householdIncome, int $SAT)
    {
        //TODO: finish implementation of function.
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
    public function removeAllPreferredMajors(): bool
    {
        $this->syncHandler($this->preferredMajors, $this->getPreferredMajors(), []);
        return true;
    }

    /**
     * Removes the current object from the database.
     * Returns true if the update was completed successfully, false otherwise.
     *
     * @return bool
     */
    public function removeFromDatabase(): bool{
		if ($this->isInDatabase()) {
			$dbc = new DatabaseConnection();
			$params = ["i", $this->getPkID()];
			$result = $dbc->query("delete", "DELETE FROM tblEduProfile WHERE pkEduProfileID = ?", $params);
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
    public function updateFromDatabase(): bool{
		if ($this->isSynced()) {
			return true;
		} elseif ($this->isInDatabase() and !$this->isSynced()) {
			try {
				$this->__construct1($this->getPkID());
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
    public function updateToDatabase(): bool{
		//Check if current object is already syncronized to database
		if ($this->isSynced()) {
			return true;
		}
		//open database connection
		$dbc = new DatabaseConnection();
		$params = [
			"ibfissiii",
			$this->getACT(),
			$this->isAP(),
			$this->getGPA(),
			$this->getSAT(),
			$this->getDesiredCollegeEntry(),
			$this->getDesiredCollegeLength(),
			$this->getDesiredMajor(),
			$this->getHouseholdIncome(),
			$this->getPkID
		];
		$result = $dbc->query("update","UPDATE tblEduProfile SET nACT=?, hadAP=?, nGPA=?, nSAT=?, 
							  dtEntry=?, nCollegeLength=?, fkMajorID=?, nHouseIncome=?, WHERE pkEduProfileID=?", $params);
		$this->inDatabase = $result;
		$this->synced = $result;
		return (bool)$result;

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

    //TODO: add in resume and transcript handling (if useful...?)

    /**
     * @param Major $desiredMajor
     * @return bool
     */
    public function setDesiredMajor(Major $desiredMajor): bool
    {
        $this->syncHandler($this->desiredMajor, $this->getDesiredMajor(), $desiredMajor);
        return true;
    }

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