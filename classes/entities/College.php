<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/02/18
 * Time: 02:20
 */

class College extends DataBasedEntity
{

    const SETTING_RURAL = "Rural";
    const SETTING_SMALL_TOWN = "Small Town";
    const SETTING_SUBURBAN = "Suburban";
    const SETTING_URBAN = "Urban";
    const TYPE_2YEAR = "2-year";
    const TYPE_4YEAR = "4-year";
    const TYPE_GRAD = "Grad School";
    const TYPE_ONLINE = "online";
    const TYPE_VOCATIONAL = "vocational";
    /**
     * The average rate of student acceptance at the college
     * @var float
     */
    private $acceptRate;
    /**
     * @var int
     */
    private $act;
    /**
     * @var string
     */
    private $city;
    /**
     * The average amount of financial aid given to students in USD
     * @var int
     */
    private $finAid;
    /**
     * @var CollegeMajor[]
     */
    private $majors;
    /**
     * @var string
     */
    private $name;
    /**
     * Phone number of the College used as contact information.
     * Does not include the country code (this information garnered through the fkProvinceID field).
     * @var int
     */
    private $phone;
    /**
     * @var int
     */
    private $postalCode;
    /**
     * @var int
     */
    private $profCount;
    /**
     * Foreign key referencing pkStateID in tblProvince. Refers to the province or state in which the college is located
     * @var Province
     */
    private $province;
    /**
     * @var int
     */
    private $sat;
    /**
     * The type of surrounding area that the college is located at
     * "Urban", "Suburban", "Rural", "Small Town"
     * @var string
     */
    private $setting;
    /**
     * @var string
     */
    private $streetAddress;
    /**
     * @var int
     */
    private $studentCount;
    /**
     * The average yearly tutition for the college in state
     * @var int
     */
    private $tuitionIn;
    /**
     * The average yearly tuition for the college out of state
     * @var int
     */
    private $tuitionOut;
    /**
     * The type of education the college offers
     * "2-year", "4-year", "vocational", "online", "Grad School"
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $website;
    /**
     * @var float
     */
    private $womenRatio;

    /**
     * @param int $PkID
     * @throws Exception
     */
    public function __construct1(int $PkID)
    {
        $dbc = new DatabaseConnection();
        $params = ["i", $PkID];
        $college = $dbc->query("select", "SELECT * FROM `tblcollege` WHERE `pkcollegeid`=?", $params);

        if ($college) {
            $result = [
                $this->setPkID($college["pkcollegeid"]),
                $this->setName($college["nmcollege"]),
                $this->setType($college["entype"]),
                $this->setStreetAddress($college["txstreetaddress"]),
                $this->setCity($college["txcity"]),
                $this->setProvince(new Province($college["fkprovinceid"], Province::MODE_DbID)),
                $this->setPostalCode($college["nzip"]),
                $this->setWebsite($college["txwebsite"]),
                $this->setPhone($college["nphone"]),//must occur after setProvince
                $this->setTuitionIn($college["ninstate"]),
                $this->setTuitionOut($college["noutstate"]),
                $this->setFinAid($college["nfinancialave"]),
                $this->setAcceptRate($college["nacceptrate"]),
                $this->setProfCount($college["nprof"]),
                $this->setStudentCount($college["nsize"]),
                $this->setWomenRatio($college["nwomenratio"]),
                $this->setACT($college["nact"]),
                $this->setSAT($college["nsat"]),
                $this->setSetting($college["ensetting"])
            ];
            if (in_array(false, $result, true)) {
                throw new Exception("College->__construct1($PkID) - Unable to construct College object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
            $this->inDatabase = true;
            $this->removeAllMajors();
            $params = ["i", $college["pkcollegeid"]];
            $majors = $dbc->query("select multiple", "SELECT `fkmajorid` FROM `tblmajorcollege` WHERE `fkcollegeid` = ?", $params);
            if ($majors) {
                foreach ($majors as $major) {
                    $this->addMajor(new CollegeMajor($major["fkmajorid"], $college["pkcollegeid"]));
                }
            }
            $this->synced = true;
        } else {
            throw new InvalidArgumentException("College->__construct1($PkID) - College not found");
        }
    }

    /**
     * College constructor.
     * @param string $name
     * @param $type
     * @param string $streetAddress
     * @param string $city
     * @param Province $province
     * @param int $zip
     * @param int $phone
     * @param int $inState
     * @param int $outState
     * @param int $finAid
     * @param float $acceptRate
     * @param int $profCount
     * @param int $size
     * @param float $womenRatio
     * @param int $act
     * @param int $sat
     * @param $setting
     * @throws Exception
     */
    public function __construct17(string $name, $type, string $streetAddress, string $city, Province $province, int $zip, int $phone, int $inState, int $outState, int $finAid, float $acceptRate, int $profCount, int $size, float $womenRatio, int $act, int $sat, $setting)
    {
        $result = [
            $this->setName($name),
            $this->setType($type),
            $this->setStreetAddress($streetAddress),
            $this->setCity($city),
            $this->setProvince($province),
            $this->setPostalCode($zip),
            $this->setPhone($phone),
            $this->setTuitionIn($inState),
            $this->setTuitionOut($outState),
            $this->setFinAid($finAid),
            $this->setAcceptRate($acceptRate),
            $this->setProfCount($profCount),
            $this->setStudentCount($size),
            $this->setWomenRatio($womenRatio),
            $this->setACT($act),
            $this->setSAT($sat),
            $this->setSetting($setting),
        ];
        if (in_array(false, $result, true)) {
            throw new Exception("Country->__construct17($name, $type, $streetAddress, $city, " . $province->getISO() . ", $zip, $phone, $inState, $outState, $finAid, $acceptRate, $profCount, $size, $womenRatio, $act, $sat, $setting) - Unable to construct User object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
        }
        $this->inDatabase = false;
        $this->synced = false;
    }

    /**
     * @param CollegeMajor $major
     * @return bool|int
     */
    public function addMajor(CollegeMajor $major)
    {
        if (in_array($major, $this->getMajors())) {
            return false;
        } else {
            $this->synced = false;
            return array_push($this->majors, $major);
        }
    }

    /**
     * @return int|null
     */
    public function getACT()
    {
        return $this->act;
    }

    /**
     * @return float|null
     */
    public function getAcceptRate()
    {
        return $this->acceptRate;
    }

    /**
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->getProvince()->getCountry();
    }

    /**
     * @return int|null
     */
    public function getFinAid()
    {
        return $this->finAid;
    }

    /**
     * @return CollegeMajor[]|null
     */
    public function getMajors()
    {
        return $this->majors;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int|null
     */
    public function getPhone()
    {
        //TODO: get the country code based on provinceID
        return $this->phone;
    }

    /**
     * @return int|null
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @return int|null
     */
    public function getProfCount()
    {
        return $this->profCount;
    }

    /**
     * @return Province|null
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @return int|null
     */
    public function getSAT()
    {
        return $this->sat;
    }

    /**
     * @return string|null
     */
    public function getSetting()
    {
        return $this->setting;
    }

    /**
     * @return string|null
     */
    public function getStreetAddress()
    {
        return $this->streetAddress;
    }

    /**
     * @return int|null
     */
    public function getStudentCount()
    {
        return $this->studentCount;
    }

    /**
     * @return int|null
     */
    public function getTuitionIn()
    {
        return $this->tuitionIn;
    }

    /**
     * @return int|null
     */
    public function getTuitionOut()
    {
        return $this->tuitionOut;
    }

    /**
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @return float|null
     */
    public function getWomenRatio()
    {
        return $this->womenRatio;
    }

    /**
     * @return bool
     */
    public function removeAllMajors(): bool
    {
        $this->syncHandler($this->majors, $this->getMajors(), []);
        return true;
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
            $result = $dbc->query("delete", "DELETE FROM tblcollege WHERE pkcollegeid = ?", $params);
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
    public function updateFromDatabase(): bool
    {
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
    public function updateToDatabase(): bool
    {
        if ($this->isSynced()) {
            return true;
        }
        $dbc = new DatabaseConnection();
        if ($this->isInDatabase()) {
            $params = [
                "ssssissiiiidiidiisi",
                $this->getName(),
                $this->getType(),
                $this->getStreetAddress(),
                $this->getCity(),
                $this->getProvince()->getPkID(),
                $this->getPostalCode(),
                $this->getWebsite(),
                $this->getPhone(),
                $this->getTuitionIn(),
                $this->getTuitionOut(),
                $this->getFinAid(),
                $this->getAcceptRate(),
                $this->getProfCount(),
                $this->getStudentCount(),
                $this->getWomenRatio(),
                $this->getACT(),
                $this->getSAT(),
                $this->getSetting(),
                $this->getPkID()
            ];
            $result = $dbc->query("update", "UPDATE `tblcollege` SET 
                                  `nmcollege`=?,`entype`=?,`txstreetaddress`=?,`txcity`=?,`fkprovinceid`=?,`nzip`=?,
                                  `txwebsite`=?,`nphone`=?,`ninstate`=?,`noutstate`=?,`nfinancialave`=?,`nacceptrate`=?,
                                  `nprof`=?,`nsize`=?,`nwomenratio`=?,`nact`=?,`nsat`=?,`ensetting`=?
                                  WHERE pkcollegeid = ?", $params);

            $params = ["i", $this->getPkID()];
            $result = ($result and $dbc->query("delete", "DELETE FROM `tblmajorcollege` WHERE `fkcollegeid`=?", $params));

            foreach ($this->getMajors() as $major) {
                $params = [
                    "iiiiii",
                    $major->getPkID(),
                    $this->getPkID(),
                    $major->isAssociate(),
                    $major->isBachelor(),
                    $major->isMaster(),
                    $major->isDoctoral()
                ];
                $result = ($result and $dbc->query("insert", "INSERT INTO `tblmajorcollege` (`fkmajorid`,`fkcollegeid`,isassociate,isbachelor,ismaster,isdoctoral) VALUES (?,?,?,?,?,?)", $params));
            }
            $this->synced = $result;
        } else {
            $params = [
                "ssssissiiiidiidiis",
                $this->getName(),
                $this->getType(),
                $this->getStreetAddress(),
                $this->getCity(),
                $this->getProvince()->getPkID(),
                $this->getPostalCode(),
                $this->getWebsite(),
                $this->getPhone(),
                $this->getTuitionIn(),
                $this->getTuitionOut(),
                $this->getFinAid(),
                $this->getAcceptRate(),
                $this->getProfCount(),
                $this->getStudentCount(),
                $this->getWomenRatio(),
                $this->getACT(),
                $this->getSAT(),
                $this->getSetting()
            ];
            $result = $dbc->query("insert", "INSERT INTO `tblcollege`(`pkcollegeid`, `nmcollege`, `entype`, 
                                          `txstreetaddress`, `txcity`, `fkprovinceid`, `nzip`, `txwebsite`, `nphone`, 
                                          `ninstate`, `noutstate`, `nfinancialave`, `nacceptrate`, `nprof`, `nsize`, 
                                          `nwomenratio`, `nact`, `nsat`, `ensetting`)
                                          VALUES  (NULL,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", $params);

            $result2 = $dbc->query("select", "SELECT LAST_INSERT_ID() AS lii");
            $this->setPkID($result2["lii"]);

            foreach ($this->getMajors() as $major) {
                $params = [
                    "iiiiii",
                    $major->getPkID(),
                    $this->getPkID(),
                    $major->isAssociate(),
                    $major->isBachelor(),
                    $major->isMaster(),
                    $major->isDoctoral()
                ];
                $result = ($result and $dbc->query("insert", "INSERT INTO `tblmajorcollege` (`fkmajorid`,`fkcollegeid`,isassociate,isbachelor,ismaster,isdoctoral) VALUES (?,?,?,?,?,?)", $params));
            }

            $this->inDatabase = $result;
            $this->synced = $result;
        }

        return (bool)$result;
    }

    /**
     * @param int $act
     * @return bool
     */
    public function setACT(int $act): bool
    {
        if ($act <= 36 and $act >= 1) {
            $this->syncHandler($this->act, $this->getACT(), $act);
            return true;
        }
        return false;
    }

    /**
     * @param float $acceptRate
     * @return bool
     */
    public function setAcceptRate(float $acceptRate): bool
    {
        if ($acceptRate <= 1 and $acceptRate >= 0) {
            $this->syncHandler($this->acceptRate, $this->getAcceptRate(), $acceptRate);
            return true;
        }
        return false;
    }

    /**
     * @param string $city
     * @return bool
     */
    public function setCity(string $city): bool
    {
        $this->syncHandler($this->city, $this->getCity(), $city);
        return true;
    }

    /**
     * @param $finAid
     * @return bool
     */
    public function setFinAid(int $finAid): bool
    {
        if ($finAid >= 0) {
            $this->syncHandler($this->finAid, $this->getFinAid(), $finAid);
            return true;
        }
        return false;
    }

    /**
     * @param $name
     * @return bool
     */
    public function setName(string $name): bool
    {
        $this->syncHandler($this->name, $this->getName(), $name);
        return true;
    }

    /**
     * @param int $phone
     * @return bool
     */
    public function setPhone(int $phone): bool
    {
        $phoneNumberUtil = libphonenumber\PhoneNumberUtil::getInstance();
        try {
            $phoneNumberObject = $phoneNumberUtil->parse($phone, $this->getCountry()->getISO());
        } catch (\libphonenumber\NumberParseException $e) {
            return false;
        }
        $isValid = $phoneNumberUtil->isValidNumberForRegion($phoneNumberObject, $this->getCountry()->getISO());

        if ($isValid) {
            $this->syncHandler($this->phone, $this->getPhone(), $phoneNumberUtil->format($phoneNumberObject, \libphonenumber\PhoneNumberFormat::E164));
            return true;
        }
        return false;
    }

    /**
     * @param int $postalCode
     * @return bool
     */
    public function setPostalCode(int $postalCode): bool
    {
        $this->syncHandler($this->postalCode, $this->getPostalCode(), $postalCode);
        return true;
    }

    /**
     * @param int $profCount
     * @return bool
     */
    public function setProfCount(int $profCount): bool
    {
        if ($profCount >= 1) {
            $this->syncHandler($this->profCount, $this->getProfCount(), $profCount);
            return true;
        }
        return false;
    }

    /**
     * @param Province $province
     * @return bool
     */
    public function setProvince(Province $province): bool
    {
        $this->syncHandler($this->province, $this->getProvince(), $province);
        return true;
    }

    /**
     * @param int $sat
     * @return bool
     */
    public function setSAT(int $sat): bool
    {
        if ($sat <= 1600 and $sat >= 400) {
            $this->syncHandler($this->sat, $this->getSAT(), $sat);
            return true;
        }
        return false;
    }

    /**
     * @param string $setting
     * @return bool
     */
    public function setSetting(string $setting): bool
    {
        switch ($setting) {
            case self::SETTING_RURAL:
            case self::SETTING_SMALL_TOWN:
            case self::SETTING_SUBURBAN:
            case self::SETTING_URBAN:
                $this->syncHandler($this->setting, $this->getSetting(), $setting);
                return true;
                break;
            default:
                return false;
        }
    }

    /**
     * @param string $streetAddress
     * @return bool
     */
    public function setStreetAddress(string $streetAddress): bool
    {
        $this->syncHandler($this->streetAddress, $this->getStreetAddress(), $streetAddress);
        return true;
    }

    /**
     * @param int $size
     * @return bool
     */
    public function setStudentCount(int $size): bool
    {
        if ($size >= 1) {
            $this->syncHandler($this->studentCount, $this->getStudentCount(), $size);
            return true;
        }
        return false;
    }

    /**
     * @param int $tuitionIn
     * @return bool
     */
    public function setTuitionIn(int $tuitionIn): bool
    {
        if ($tuitionIn >= 0) {
            $this->syncHandler($this->tuitionIn, $this->getTuitionIn(), $tuitionIn);
            return true;
        }
        return true;
    }

    /**
     * @param int $tuitionOut
     * @return bool
     */
    public function setTuitionOut(int $tuitionOut): bool
    {
        if ($tuitionOut >= 0) {
            $this->syncHandler($this->tuitionOut, $this->getTuitionOut(), $tuitionOut);
            return true;
        }
        return false;
    }

    /**
     * @param string $type
     * @return bool
     */
    public function setType(string $type): bool
    {
        switch ($type) {
            case self::TYPE_2YEAR:
            case self::TYPE_4YEAR:
            case self::TYPE_GRAD:
            case self::TYPE_ONLINE:
            case self::TYPE_VOCATIONAL:
                $this->syncHandler($this->type, $this->getType(), $type);
                return true;
                break;
            default:
                return false;
        }
    }

    /**
     * @param string $website
     * @return bool
     */
    public function setWebsite(string $website): bool
    {
        if (filter_var($website, FILTER_VALIDATE_URL) === true) {
            $this->syncHandler($this->website, $this->getWebsite(), $website);
            return true;
        }
        return false;
    }

    /**
     * @param float $womenRatio
     * @return bool
     */
    public function setWomenRatio(float $womenRatio): bool
    {
        if ($womenRatio >= 0 and $womenRatio <= 1) {
            $this->syncHandler($this->womenRatio, $this->getWomenRatio(), $womenRatio);
            return true;
        }
        return false;
    }
}