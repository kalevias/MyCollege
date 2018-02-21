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
     * @var int
     */
    private $size;
    /**
     * @var string
     */
    private $streetAddress;
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
     * @var float
     */
    private $womenRatio;
    /**
     * @var int
     */
    private $zip;

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
     */
    public function __construct17(string $name, $type, string $streetAddress, string $city, Province $province, int $zip, int $phone, int $inState, int $outState, int $finAid, float $acceptRate, int $profCount, int $size, float $womenRatio, int $act, int $sat, $setting)
    {
        $result = [
            $this->setName($name),
            $this->setType($type),
            $this->setStreetAddress($streetAddress),
            $this->setCity($city),
            $this->setProvince($province),
            $this->setZip($zip),
            $this->setPhone($phone),
            $this->setTuitionIn($inState),
            $this->setTuitionOut($outState),
            $this->setFinAid($finAid),
            $this->setAcceptRate($acceptRate),
            $this->setProfCount($profCount),
            $this->setSize($size),
            $this->setWomenRatio($womenRatio),
            $this->setAct($act),
            $this->setSat($sat),
            $this->setSetting($setting),
        ];
        $this->inDatabase = false;
        $this->synced = false;
    }

    /**
     * @return float|null
     */
    public function getAcceptRate()
    {
        return $this->acceptRate;
    }

    /**
     * @return int|null
     */
    public function getAct()
    {
        return $this->act;
    }

    /**
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return int|null
     */
    public function getFinAid()
    {
        return $this->finAid;
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
    public function getSat()
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
     * @return int|null
     */
    public function getSize()
    {
        return $this->size;
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
     * @return float|null
     */
    public function getWomenRatio()
    {
        return $this->womenRatio;
    }

    /**
     * @return int|null
     */
    public function getZip()
    {
        return $this->zip;
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
     * @param float $acceptRate
     * @return bool
     */
    public function setAcceptRate(float $acceptRate): bool
    {
        if($acceptRate <= 1 and $acceptRate >= 0) {
            $this->syncHandler($this->acceptRate, $this->getAcceptRate(), $acceptRate);
            return true;
        }
        return false;
    }

    /**
     * @param int $act
     * @return bool
     */
    public function setAct(int $act): bool
    {
        if($act <= 36 and $act >= 1) {
            $this->syncHandler($this->act, $this->getAct(), $act);
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
        if($finAid >= 0) {
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
     * @return Country
     */
    public function getCountry(): Country {
        return $this->getProvince()->getCountry();
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
     * @param int $profCount
     * @return bool
     */
    public function setProfCount(int $profCount): bool
    {
        if($profCount >= 1) {
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
    public function setSat(int $sat): bool
    {
        if($sat <= 1600 and $sat >= 400) {
            $this->syncHandler($this->sat, $this->getSat(), $sat);
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
        switch($setting) {
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
     * @param int $size
     * @return bool
     */
    public function setSize(int $size): bool
    {
        if($size >= 1) {
            $this->syncHandler($this->size, $this->getSize(), $size);
            return true;
        }
        return false;
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
     * @param int $tuitionIn
     * @return bool
     */
    public function setTuitionIn(int $tuitionIn): bool
    {
        if($tuitionIn >= 0) {
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
        if($tuitionOut >= 0) {
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
        switch($type) {
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
     * @param float $womenRatio
     * @return bool
     */
    public function setWomenRatio(float $womenRatio): bool
    {
        if($womenRatio >= 0 and $womenRatio <= 1) {
            $this->syncHandler($this->womenRatio, $this->getWomenRatio(), $womenRatio);
            return true;
        }
        return false;
    }

    /**
     * @param int $zip
     * @return bool
     */
    public function setZip(int $zip): bool
    {
        $this->syncHandler($this->zip, $this->getZip(), $zip);
        return true;
    }

    /**
     * @param int $pkID
     * @return bool
     */
    private function setPkID(int $pkID): bool
    {
        $this->pkID = $pkID;
        return true;
    }
}