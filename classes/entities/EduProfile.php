<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/20/2018
 * Time: 11:34 PM
 */

class EduProfile extends DataBasedEntity
{

    /**
     * Has the student taken AP classes?
     *
     * @var bool
     */
    private $AP;
    /**
     * What did the student get on the ACT test?
     *
     * @var int
     */
    private $act;
    /**
     * When (usually a year) would the student like to enter higher education?
     *
     * @var DateTime
     */
    private $desiredCollegeEntry;
    /**
     *
     *
     * @var DateInterval
     */
    private $desiredCollegeLength;
    /**
     *
     *
     * @var Major
     */
    private $desiredMajor;
    /**
     * What is the student's GPA on a 4-point scale?
     *
     * @var float
     */
    private $gpa;
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
     * What did the student get on the SAT test?
     *
     * @var int
     */
    private $sat;

    /**
     * @return int|null
     */
    public function getAct()
    {
        return $this->act;
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
    public function getGpa()
    {
        return $this->gpa;
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
    public function getSat()
    {
        return $this->sat;
    }

    /**
     * @return bool|null
     */
    public function isAP()
    {
        return $this->AP;
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
     * @param bool $AP
     * @return bool
     */
    public function setAP(bool $AP): bool
    {
        $this->syncHandler($this->AP, $this->isAP(), $AP);
        return true;
    }

    /**
     * @param int $act
     * @return bool
     */
    public function setAct(int $act): bool
    {
        if ($act <= 36 and $act >= 1) {
            $this->syncHandler($this->act, $this->getAct(), $act);
            return true;
        }
        return false;
    }

    /**
     * @param DateTime $desiredCollegeEntry
     * @return bool
     */
    public function setDesiredCollegeEntry(DateTime $desiredCollegeEntry): bool
    {
        if($desiredCollegeEntry > new DateTime()) {
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

    /**
     * @param float $gpa
     * @return bool
     */
    public function setGpa(float $gpa): bool
    {
        if($gpa >= 0 and $gpa <= 4) {
            $this->syncHandler($this->gpa, $this->getGpa(), $gpa);
            return true;
        }
        return false;
    }

    //TODO: add in resume and transcript handling (if useful...?)

    /**
     * @param int $householdIncome
     * @return bool
     */
    public function setHouseholdIncome(int $householdIncome): bool
    {
        if($householdIncome >= 0) {
            $this->syncHandler($this->householdIncome, $this->getHouseholdIncome(), $householdIncome);
            return true;
        }
        return false;
    }

    /**
     * @param Major $major
     * @return int|bool
     */
    public function addPreferredMajor(Major $major) {
        if (in_array($major, $this->getPreferredMajors())) {
            return false;
        } else {
            $this->synced = false;
            return array_push($this->preferredMajors, $major);
        }
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
     * @param int $sat
     * @return bool
     */
    public function setSat(int $sat): bool
    {
        if($sat <= 1600 and $sat >= 400) {
            $this->syncHandler($this->sat, $this->getSat(), $sat);
            return true;
        }
        return false;
    }
}