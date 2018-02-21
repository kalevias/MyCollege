<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/20/2018
 * Time: 11:34 PM
 */

class Major
{
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
     * @throws Exception
     */
    public function __construct(int $pkID)
    {
        $dbc = new DatabaseConnection();
        $params = ["i", $pkID];
        $major = $dbc->query("select", "SELECT * FROM tblmajor WHERE pkmajorid = ?", $params);
        if ($major) {
            $result = [
                $this->setPkID($major["pkmajorid"]),
                $this->setName($major["nmnmae"])
            ];
            if (in_array(false, $result, true)) {
                throw new Exception("Major->__construct($pkID) -  Unable to construct Major object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
        } else {
            throw new Exception("Major->__construct($pkID) -  Unable to select from database");
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