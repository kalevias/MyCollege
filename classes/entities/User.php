<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/6/2018
 * Time: 1:19 PM
 */

class User extends DataBasedEntity
{

    const MODE_DbID = 1;
    const MODE_NAME = 2;
    /**
     * @var bool
     */
    private $active;
    /**
     * @var string
     */
    private $altEmail;
    /**
     * @var string
     */
    private $city;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $firstName;
    /**
     * @var int
     */
    private $gradYear;
    /**
     * @var string
     */
    private $hash;
    /**
     * @var string
     */
    private $lastName;
    /**
     * @var Permission[]
     */
    private $permissions;
    /**
     * @var string
     */
    private $phone;
    /**
     * @var int
     */
    private $postalCode;
    /**
     * @var Province
     */
    private $province;
    /**
     * @var string
     */
    private $streetAddress;

    /**
     * Loads a user from the database.
     *
     * @param string|int $identifier May be either user email or ID
     * @param int $mode
     * @return null|User
     */
    public static function load($identifier, int $mode = self::MODE_NAME)
    {
        try {
            return new User($identifier, $mode);
        } catch (InvalidArgumentException $iae) {
            return null;
        }
    }

    /**
     * User constructor (12 arguments).
     *
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $altEmail
     * @param string $streetAddress
     * @param string $city
     * @param Province $province
     * @param int $postalCode
     * @param int $phone
     * @param int $gradYear
     * @param string $password
     * @param bool $active
     * @throws Exception
     */
    public function __construct12(string $firstName, string $lastName, string $email, string $altEmail, string $streetAddress, string $city, Province $province, int $postalCode, int $phone, int $gradYear, string $password, bool $active)
    {
        $result = [
            $this->setFirstName($firstName),
            $this->setLastName($lastName),
            $this->setEmail($email),
            $this->setAltEmail($altEmail),
            $this->setStreetAddress($streetAddress),
            $this->setCity($city),
            $this->setProvince($province),
            $this->setPostalCode($postalCode),
            $this->setPhone($phone),
            $this->setGradYear($gradYear),
            $this->updatePassword($password),
            $this->setActive($active),
        ];
        if (in_array(false, $result, true)) {
            throw new Exception("User->__construct12($firstName, $lastName, $email, $altEmail, $streetAddress, $city, ".$province->getISO().", $postalCode, $phone, $gradYear, $password, $active) - Unable to construct User object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
        }
        $this->permissions = [];
        $this->inDatabase = false;
    }

    /**
     * User Constructor (2 arguments).
     *
     * @param int|string $identifier
     * @param int $mode
     * @throws Exception
     */
    public function __construct2($identifier, int $mode = self::MODE_NAME)
    {
        $dbc = new DatabaseConnection();
        if ($mode === self::MODE_DbID) {
            $params = ["i", $identifier];
            $user = $dbc->query("select", "SELECT * FROM `tbluser` WHERE `pkuserid`=?", $params);
        } else {
            $params = ["s", $identifier];
            $user = $dbc->query("select", "SELECT * FROM `tbluser` WHERE `txemail`=?", $params);
        }

        if ($user) {
            $result = [
                $this->setPkID($user["pkuserid"]),
                $this->setFirstName($user["nmfirst"]),
                $this->setLastName($user["nmlast"]),
                $this->setEmail($user["txemail"]),
                $this->setAltEmail($user["txemailalt"]),
                $this->setStreetAddress($user["txstreetaddress"]),
                $this->setCity($user["txcity"]),
                $this->setProvince(new Province($user["fkprovinceid"], Province::MODE_DbID)),
                $this->setPostalCode($user["txpostalcode"]),
                $this->setPhone($user["nphone"]),//must occur after setProvince
                $this->setGradYear($user["dtgradyear"]),
                $this->setHash($user["txhash"]),
                $this->setActive($user["isactive"]),
            ];
            if (in_array(false, $result, true)) {
                throw new Exception("User->__construct2($identifier, $mode) - Unable to construct User object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
            $this->inDatabase = true;
            $this->removeAllPermissions();
            $params = ["i", $user["pkuserid"]];
            $permissions = $dbc->query("select multiple", "SELECT `fkpermissionid` FROM `tbluserpermissions` WHERE `fkuserid` = ?", $params);
            if ($permissions) {
                foreach ($permissions as $permission) {
                    $this->addPermission(new Permission($permission["fkpermissionid"]));
                }
            }
            $this->synced = true;
        } else {
            throw new InvalidArgumentException("User->__construct2($identifier, $mode) - User not found");
        }
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "{" . implode(" ", [$this->getFirstName(), $this->getLastName(), $this->getEmail(), $this->getPkID(), $this->isInDatabase(), $this->isActive()]) . "}";
    }

    /**
     * Adds a permission to the user's permissions.
     *
     * @param Permission $permission
     * @return bool|int
     */
    public function addPermission(Permission $permission)
    {
        if (in_array($permission, $this->getPermissions())) {
            return false;
        } else {
            $this->synced = false;
            return array_push($this->permissions, $permission);
        }
    }

    /**
     * @return string|null
     */
    public function getAltEmail()
    {
        if ($this->altEmail === null) {
            return "";
        } else {
            return $this->altEmail;
        }
    }

    /**
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return Country|null
     */
    public function getCountry()
    {
        return $this->getProvince()->getCountry();
    }

    /**
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return int|null
     */
    public function getGradYear()
    {
        return $this->gradYear;
    }

    /**
     * @return string|null
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @return string|null
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return Permission[]|null
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @return int|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return string|null
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @return Province|null
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @return string|null
     */
    public function getStreetAddress()
    {
        return $this->streetAddress;
    }

    /**
     * @param Permission $permission
     * @return bool
     */
    public function hasPermission(Permission $permission): bool
    {
        return in_array($permission, $this->getPermissions());
    }

    /**
     * @return bool|null
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function removeAllPermissions(): bool
    {
        $this->syncHandler($this->permissions, $this->getPermissions(), []);
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
        if($this->isInDatabase()) {
            $dbc = new DatabaseConnection();
            $params = ["i", $this->getPkID()];
            $result = $dbc->query("delete", "DELETE FROM tbluser WHERE pkuserid = ?", $params);
            if($result) {
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
     * @param int $pkID
     * @return bool
     */
    protected function setPkID($pkID): bool
    {
        if ($this->isInDatabase()) {
            return false;
        } else {
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
                $this->__construct2($this->getPkID(), self::MODE_DbID);
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
                "ssssssisiisii",
                $this->getFirstName(),
                $this->getLastName(),
                $this->getEmail(),
                $this->getAltEmail(),
                $this->getStreetAddress(),
                $this->getCity(),
                $this->getProvince()->getPkID(),
                $this->getPostalCode(),
                $this->getPhone(),
                $this->getGradYear(),
                $this->getHash(),
                $this->isActive(),
                $this->getPkID()
            ];
            $result = $dbc->query("update", "UPDATE `tbluser` SET 
                                      `nmfirst`=?,`nmlast`=?,`txemail`=?,`txemailalt`=?,
                                      `txstreetaddress`=?,`txcity`=?,`fkprovinceid`=?,`txpostalcode`=?,
                                      `nphone`=?,`dtgradyear`=?, `txhash`=?,`isactive`=?
                                      WHERE `pkuserid`=?", $params);

            $params = ["i", $this->getPkID()];
            $result = ($result and $dbc->query("delete", "DELETE FROM `tbluserpermissions` WHERE `fkuserid`=?", $params));

            foreach ($this->getPermissions() as $permission) {
                $params = ["ii", $permission->getPkID(), $this->getPkID()];
                $result = ($result and $dbc->query("insert", "INSERT INTO `tbluserpermissions` (`fkpermissionid`,`fkuserid`) VALUES (?,?)", $params));
            }
            $this->synced = $result;
        } else {
            $params = [
                "ssssssisiisi",
                $this->getFirstName(),
                $this->getLastName(),
                $this->getEmail(),
                $this->getAltEmail(),
                $this->getStreetAddress(),
                $this->getCity(),
                $this->getProvince()->getPkID(),
                $this->getPostalCode(),
                $this->getPhone(),
                $this->getGradYear(),
                $this->getHash(),
                $this->isActive()
            ];
            $result = $dbc->query("insert", "INSERT INTO `tbluser` (`pkuserid`, 
                                          `nmfirst`, `nmlast`, `txemail`, `txemailalt`, 
                                          `txstreetaddress`, `txcity`, `fkprovinceid`, `txpostalcode`, 
                                          `nphone`,`dtgradyear`, `txhash`, `isactive`) 
                                          VALUES  (NULL,?,?,?,?,?,?,?,?,?,?,?,?)", $params);

            $params = ["s", $this->getEmail()];
            $result2 = $dbc->query("select", "SELECT `pkuserid` FROM `tbluser` WHERE `txemail`=?", $params);

            $this->setPkID($result2["pkuserid"]);

            foreach ($this->getPermissions() as $permission) {
                $params = ["ii", $permission->getPkID(), $this->getPkID()];
                $result = ($result and $dbc->query("insert", "INSERT INTO `tbluserpermissions` (`fkpermissionid`,`fkuserid`) VALUES (?,?)", $params));
            }

            $this->inDatabase = $result;
            $this->synced = $result;
        }

        return (bool)$result;
    }

    /**
     * @param Permission $permission
     * @return bool
     */
    public function removePermission(Permission $permission): bool
    {
        if (($key = array_search($permission, $this->getPermissions(), true)) !== false) {
            unset($this->permissions[$key]);
            $this->synced = false;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param bool $active
     * @return bool
     */
    public function setActive(bool $active): bool
    {
        $this->syncHandler($this->active, $this->isActive(), $active);
        return true;
    }

    /**
     * @param null|string $email
     * @return bool
     */
    public function setAltEmail(string $email = null): bool
    {
        if ($email === null or $email === "") {
            $this->syncHandler($this->altEmail, $this->getAltEmail(), null);
            return true;
        }
        $dbc = new DatabaseConnection();
        if (strlen($email) <= $dbc->getMaximumLength("tbluser", "txemailalt") and $filtered = filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->syncHandler($this->altEmail, $this->getAltEmail(), filter_var($filtered, FILTER_SANITIZE_EMAIL));
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
        $dbc = new DatabaseConnection();
        if (strlen($city) <= $dbc->getMaximumLength("tbluser", "txcity")) {
            $this->syncHandler($this->city, $this->getCity(), $city);
            return true;
        }
        return false;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function setEmail(string $email): bool
    {
        if ($email === null) {
            $this->syncHandler($this->email, $this->getEmail(), null);
            return true;
        }
        $dbc = new DatabaseConnection();
        if (strlen($email) <= $dbc->getMaximumLength("tbluser", "txemail") and $filtered = filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->syncHandler($this->email, $this->getEmail(), filter_var($filtered, FILTER_SANITIZE_EMAIL));
            return true;
        }
        return false;
    }

    /**
     * @param string $firstName
     * @return bool
     */
    public function setFirstName(string $firstName): bool
    {
        $dbc = new DatabaseConnection();
        if (strlen($firstName) <= $dbc->getMaximumLength("tbluser", "nmfirst")) {
            $this->syncHandler($this->firstName, $this->getFirstName(), $firstName);
            return true;
        }
        return false;
    }

    /**
     * @param int $gradYear
     * @return bool
     */
    public function setGradYear(int $gradYear): bool
    {
        $options = [
            "options" => [
                "min_range" => 1970,
                "max_range" => 3000
            ]
        ];
        if ($filtered = filter_var($gradYear, FILTER_VALIDATE_INT, $options)) {
            $this->syncHandler($this->gradYear, $this->getGradYear(), $filtered);
            return true;
        }
        return false;
    }

    /**
     * @param string $lastName
     * @return bool
     */
    public function setLastName(string $lastName): bool
    {
        $dbc = new DatabaseConnection();
        if (strlen($lastName) <= $dbc->getMaximumLength("tbluser", "nmlast")) {
            $this->syncHandler($this->lastName, $this->getLastName(), $lastName);
            return true;
        }
        return false;
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
    public function setPostalCode(int $postalCode = null): bool
    {
        if (isset($postalCode)) {
            $postalCode = strtoupper($postalCode);
            $postalCode = preg_replace("/[^0-9A-Z]/", "", $postalCode);
            $dbc = new DatabaseConnection();
            if (strlen($postalCode) <= $dbc->getMaximumLength("tbluser", "txpostalcode")) {
                $this->syncHandler($this->postalCode, $this->getPostalCode(), $postalCode);
                return true;
            }
            return false;
        } else {
            $this->syncHandler($this->postalCode, $this->getPostalCode(), null);
            return true;
        }
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
     * @param string $streetAddress
     * @return bool
     */
    public function setStreetAddress(string $streetAddress): bool
    {
        $dbc = new DatabaseConnection();
        if (strlen($streetAddress) <= $dbc->getMaximumLength("tbluser", "txstreetaddress")) {
            $this->syncHandler($this->streetAddress, $this->getStreetAddress(), $streetAddress);
            return true;
        }
        return false;
    }

    /**
     * @param string $password
     * @return bool
     */
    public function updatePassword(string $password): bool
    {
        $newHash = Hasher::cryptographicHash($password);
        return $this->setHash($newHash);
    }

    /**
     * @param string $hash
     * @return bool
     */
    private function setHash(string $hash): bool
    {
        $dbc = new DatabaseConnection();
        if (strlen($hash) <= $dbc->getMaximumLength("tbluser", "txhash")) {
            $this->syncHandler($this->hash, $this->getHash(), $hash);
            return true;
        }
        return false;
    }
}