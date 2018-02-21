<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/6/2018
 * Time: 1:22 PM
 */

abstract class DataBasedEntity
{
    /**
     * Indicates whether or not the current object is reflected in the database.
     *
     * @var bool
     */
    protected $inDatabase;
    /**
     * primary identifier of the object as in the database. May be null when inDatabase is false.
     *
     * @var mixed
     */
    protected $pkID;
    /**
     * Indicates whether or not the current object is synced with the database. The difference between this and
     * inDatabase can be seen in the following truth table:
     *
     * inDatabase | synced
     *      T    --> T/F
     *      F    -->  F
     *      T    <--  T
     *     T/F   <--  F
     * @var bool
     */
    protected $synced;

    /**
     * Generic constructor for calling more specific "overloaded" constructors
     *
     * DataBasedEntity constructor.
     */
    public function __construct()
    {
        //This segment of code originally written by rayro@gmx.de
        //http://php.net/manual/en/language.oop5.decon.php
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this, $f = '__construct' . $i)) {
            call_user_func_array(array($this, $f), $a);
        }
    }

    /**
     * @return mixed
     */
    public function getPkID()
    {
        return $this->pkID;
    }

    /**
     * @return bool
     */
    public function isInDatabase(): bool
    {
        return isset($this->inDatabase) and $this->inDatabase;
    }

    /**
     * @return bool
     */
    public function isSynced(): bool
    {
        return isset($this->synced) and $this->synced;
    }

    /**
     * Removes the current object from the database.
     * Returns true if the update was completed successfully, false otherwise.
     *
     * @return bool
     */
    public abstract function removeFromDatabase(): bool;

    /**
     * Loads the current object with data from the database to which pkID pertains.
     *
     * @return bool
     */
    public abstract function updateFromDatabase(): bool;

    /**
     * Saves the current object to the database. After execution of this function, inDatabase and synced should both be
     * true.
     *
     * @return bool
     */
    public abstract function updateToDatabase(): bool;

    /**
     * @param mixed $pkID
     * @return bool
     */
    protected function setPkID($pkID): bool
    {
        if ($this->isInDatabase()) {
            return false;
        } else {
            $this->pkID = $pkID;
            return true;
        }
    }

    /**
     * @param $reference mixed : An internal class attribute to be changed
     * @param $oldValue
     * @param $newValue
     */
    protected function syncHandler(&$reference, $oldValue, $newValue): void
    {
        $sync = ($this->synced and ($oldValue === $newValue));
        $reference = $newValue;
        $this->synced = $sync;
    }
}