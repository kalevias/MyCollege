<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/20/2018
 * Time: 11:34 PM
 */

class CollegeMajor extends Major
{
    /**
     * @var bool
     */
    private $associate;
    /**
     * @var bool
     */
    private $bachelor;
    /**
     * @var bool
     */
    private $doctoral;
    /**
     * @var bool
     */
    private $master;

    /**
     * Major constructor.
     * @param int $pkID
     * @param int $fkCollegeID
     * @throws Exception
     */
    public function __construct(int $pkID, int $fkCollegeID = 0)
    {
        parent::__construct($pkID);
        $dbc = new DatabaseConnection();
        $params = ["ii", $fkCollegeID, $pkID];
        $collegeMajor = $dbc->query("select", "SELECT * FROM tblmajorcollege WHERE fkcollegeid = ? AND fkmajorid = ?", $params);
        if ($collegeMajor) {
            $result = [
                $this->setAssociate($collegeMajor["isassociate"]),
                $this->setBachelor($collegeMajor["isbachelor"]),
                $this->setMaster($collegeMajor["ismaster"]),
                $this->setDoctoral($collegeMajor["isdoctoral"])
            ];
            if (in_array(false, $result, true)) {
                throw new Exception("CollegeMajor->__construct($pkID, $fkCollegeID) -  Unable to construct CollegeMajor object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
        } else {
            throw new Exception("CollegeMajor->__construct($pkID, $fkCollegeID) -  Unable to select from database");
        }
    }

    /**
     * @return bool
     */
    public function isAssociate(): bool
    {
        return $this->associate;
    }

    /**
     * @return bool
     */
    public function isBachelor(): bool
    {
        return $this->bachelor;
    }

    /**
     * @return bool
     */
    public function isDoctoral(): bool
    {
        return $this->doctoral;
    }

    /**
     * @return bool
     */
    public function isMaster(): bool
    {
        return $this->master;
    }

    /**
     * @param bool $associate
     * @return bool
     */
    public function setAssociate(bool $associate): bool
    {
        $this->associate = $associate;
        return true;
    }

    /**
     * @param bool $bachelor
     * @return bool
     */
    public function setBachelor(bool $bachelor): bool
    {
        $this->bachelor = $bachelor;
        return true;
    }

    /**
     * @param bool $doctoral
     * @return bool
     */
    public function setDoctoral(bool $doctoral): bool
    {
        $this->doctoral = $doctoral;
        return true;
    }

    /**
     * @param bool $master
     * @return bool
     */
    public function setMaster(bool $master): bool
    {
        $this->master = $master;
        return true;
    }
}