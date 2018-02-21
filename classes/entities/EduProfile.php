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
     * @var bool
     */
    private $AP;
    /**
     * @var int
     */
    private $act;
    /**
     * @var DateTime
     */
    private $desiredCollegeEntry;
    /**
     * @var DateInterval
     */
    private $desiredCollegeLength;
    /**
     * @var Major
     */
    private $desiredMajor;
    /**
     * @var float
     */
    private $gpa;
    /**
     * @var int
     */
    private $householdIncome;
    /**
     * @var Major[]
     */
    private $preferredMajors;
    /**
     * @var int
     */
    private $sat;

    //TODO: add in resume and transcript handling (if useful...?)

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