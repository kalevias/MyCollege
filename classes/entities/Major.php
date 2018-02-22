<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/20/2018
 * Time: 11:34 PM
 */

class Major //Should create a new child class that inherits from this one to handle the college specific major requirements
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
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $pkID;

    /**
     * Major constructor.
     * @param int $pkID
     * @param int $fkCollegeID
     * @throws Exception
     */
    public function __construct(int $pkID, int $fkCollegeID = 0)
    {
        $dbc = new DatabaseConnection();
        $params = ["i", $pkID];
        $major = $dbc->query("select", "SELECT * FROM tblmajor WHERE pkmajorid = ?", $params);
        if($fkCollegeID === 0) {
            $collegeMajor = [
                "isassociate"=>false,
                "isbachelor"=>false,
                "ismaster"=>false,
                "isdoctoral"=>false
            ];
        } else {
            $params = ["ii", $pkID, $fkCollegeID];
            $collegeMajor = $dbc->query("select", "SELECT * from tblmajorcollege WHERE fkcollegeid = ? and fkmajorid = ?", $params);
        }
        if ($major and $collegeMajor) {
            $result = [
                $this->setPkID($major["pkmajorid"]),
                $this->setName($major["nmnmae"]),
                $this->setAssociate($collegeMajor["isassociate"]),
                $this->setBachelor($collegeMajor["isbachelor"]),
                $this->setMaster($collegeMajor["ismaster"]),
                $this->setDoctoral($collegeMajor["isdoctoral"])
            ];
            if (in_array(false, $result, true)) {
                throw new Exception("Major->__construct($pkID, $fkCollegeID) -  Unable to construct Major object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
        } else {
            throw new Exception("Major->__construct($pkID, $fkCollegeID) -  Unable to select from database");
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPkID(): int
    {
        return $this->pkID;
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

    /**
     * @param $name
     * @return bool
     */
    private function setName($name): bool
    {
        $this->name = $name;
        return true;
    }

    /**
     * @param $pkID
     * @return bool
     */
    private function setPkID($pkID): bool
    {
        $this->pkID = $pkID;
        return true;
    }


}