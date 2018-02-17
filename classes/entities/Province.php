<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/6/2018
 * Time: 2:08 PM
 */

class Province
{

    const MODE_DbID = 3;
    const MODE_ISO = 1;
    const MODE_NAME = 2;
    /**
     * @var string
     */
    private $ISO;
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $pkID;

    /**
     * Province constructor.
     * @param string|int $identifier
     * @param int $mode
     * @throws Exception
     */
    public function __construct($identifier, int $mode = self::MODE_NAME)
    {
        $dbc = new DatabaseConnection();
        if ($mode === self::MODE_ISO) {
            $params = ["s", strtoupper($identifier)];
            $province = $dbc->query("select", "SELECT * FROM `tblprovince` WHERE `idiso`=?", $params);
        } elseif ($mode === self::MODE_DbID) {
            $params = ["i", $identifier];
            $province = $dbc->query("select", "SELECT * FROM `tblprovince` WHERE `pkstateid` = ?", $params);
        } else {
            $params = ["s", strtoupper($identifier)];
            $province = $dbc->query("select", "SELECT * FROM `tblprovince` WHERE UPPER(`nmname`)=?", $params);
        }

        if ($province) {
            $result = [
                $this->setPkID($province["pkstateid"]),
                $this->setISO($province["idiso"]),
                $this->setName($province["nmname"])
            ];
            if (in_array(false, $result)) {
                throw new Exception("Province->__construct($identifier, $mode) - Unable to construct Province object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
        } else {
            throw new Exception("Province->__construct($identifier, $mode) - Unable to construct Province object; invalid province");
        }
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        try {
            return new Country($this->getPkID(), Country::MODE_ProvinceID);
        } catch (Exception $e) {
            echo $e;
            return null;
        }
    }

    /**
     * @return string
     */
    public function getISO(): string
    {
        return $this->ISO;
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
     * @param string $ISO
     * @return bool
     */
    private function setISO(string $ISO): bool
    {
        $this->ISO = $ISO;
        return true;
    }

    /**
     * @param string $name
     * @return bool
     */
    private function setName(string $name): bool
    {
        $this->name = $name;
        return true;
    }

    /**
     * @param int $pkID
     * @return bool
     */
    private function setPkID(int $pkID): bool
    {
        $options = [
            "options" => [
                "min_range" => 0,
                "max_range" => pow(2, 31) - 1
            ]
        ];
        if ($filtered = filter_var($pkID, FILTER_VALIDATE_INT, $options)) {
            $this->pkID = $filtered;
            return true;
        }
        return false;
    }


}