<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/6/2018
 * Time: 2:12 PM
 */

class Country
{
    const MODE_DbID = 4;
    const MODE_ISO = 1;
    const MODE_NAME = 2;
    const MODE_ProvinceID = 3;
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
    private $phoneCode;
    /**
     * @var int
     */
    private $pkID;
    /**
     * @var Province[]
     */
    private $provinces;

    /**
     * Country constructor.
     * @param string|int $identifier
     * @param int $mode
     * @throws Exception
     */
    public function __construct($identifier, int $mode = self::MODE_NAME)
    {
        $dbc = new DatabaseConnection();

        if ($mode === self::MODE_ISO) {
            $params = ["s", strtoupper($identifier)];
            $country = $dbc->query("select", "SELECT * FROM `tblcountry` WHERE `idiso`=?", $params);
        } elseif ($mode === self::MODE_ProvinceID) {
            $params = ["i", $identifier];
            $country = $dbc->query("select", "SELECT c.* FROM `tblcountry` c JOIN tblprovince t ON c.pkcountryid = t.fkcountryid WHERE t.pkstateid = ?", $params);
        } elseif ($mode === self::MODE_DbID) {
            $params = ["i", $identifier];
            $country = $dbc->query("select", "SELECT * FROM `tblcountry` WHERE `pkcountryid`=?", $params);
        } else {
            $params = ["s", strtoupper($identifier)];
            $country = $dbc->query("select", "SELECT * FROM `tblcountry` WHERE UPPER(`nmname`)=?", $params);
        }

        if ($country) {
            $result = [
                $this->setPkID($country["pkcountryid"]),
                $this->setISO($country["idiso"]),
                $this->setName($country["nmname"]),
                $this->setPhoneCode($country["idphonecode"]),
                $this->setProvinces() //call to setPkID must be before this function call
            ];
            if (in_array(false, $result)) {
                throw new Exception("Country->__construct($identifier, $mode) - Unable to construct Country object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
        } else {
            throw new Exception("Country->__construct($identifier, $mode) - Unable to construct Country object; invalid country");
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
    public function getPhoneCode(): int
    {
        return $this->phoneCode;
    }

    /**
     * @return int
     */
    public function getPkID(): int
    {
        return $this->pkID;
    }

    /**
     * @return Province[]
     */
    public function getProvinces()
    {
        return $this->provinces;
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
     * @param int $phoneCode
     * @return bool
     */
    private function setPhoneCode(int $phoneCode): bool
    {
        $this->phoneCode = $phoneCode;
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

    /**
     * @return bool
     */
    private function setProvinces(): bool
    {
        $dbc = new DatabaseConnection();
        $params = ["i", $this->getPkID()];
        $provinces = $dbc->query("select multiple", "SELECT pkstateid FROM tblprovince WHERE fkcountryid = ?", $params);
        $provinceObjects = [];
        if ($provinces) {
            foreach ($provinces as $province) {
                try {
                    $provinceObjects[] = new Province($province["pkstateid"], Province::MODE_DbID);
                } catch (Exception $e) {
                    return false;
                }
            }
        }
        $this->provinces = $provinceObjects;
        return true;
    }
}