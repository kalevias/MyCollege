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
    const TYPE_PRIVATE = "Private";
    const TYPE_PUBLIC = "Public";
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
     * @var bool
     */
    private $apartments;
    /**
     * @var bool
     */
    private $band;
    /**
     * @var int|null
     */
    private $boardCost;
    /**
     * @var bool
     */
    private $choral;
    /**
     * @var string
     */
    private $city;
    /**
     * @var bool
     */
    private $counseling;
    /**
     * @var bool
     */
    private $dorms;
    /**
     * @var bool
     */
    private $drama;
    /**
     * The average amount of financial aid given to students in USD
     * @var int
     */
    private $finAid;
    /**
     * @var int
     */
    private $finAidAwarded;
    /**
     * @var int
     */
    private $finAidFreshmen;
    /**
     * @var int
     */
    private $finAidGrant;
    /**
     * @var int
     */
    private $finAidInternaional;
    /**
     * @var int
     */
    private $finAidLoan;
    /**
     * @var Greek[]
     */
    private $greeks;
    /**
     * @var bool
     */
    private $healthCenter;
    /**
     * @var bool
     */
    private $legal;
    /**
     * @var bool
     */
    private $library;
    /**
     * @var CollegeMajor[]
     */
    private $majors;
    /**
     * @var bool
     */
    private $mealPlan;
    /**
     * @var string
     */
    private $name;
    /**
     * @var bool
     */
    private $newspaper;
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
     * @var bool
     */
    private $radio;
    /**
     * @var bool
     */
    private $recCenter;
    /**
     * @var int|null
     */
    private $roomCost;
    /**
     * @var bool
     */
    private $roommates;
    /**
     * @var bool
     */
    private $roommatesChoosable;
    /**
     * @var int
     */
    private $sat;
    /**
     * @var CollegeScholarship[]
     */
    private $scholarships;
    /**
     * The type of surrounding area that the college is located at
     * "Urban", "Suburban", "Rural", "Small Town"
     * @var string
     */
    private $setting;
    /**
     * @var CollegeSport[]
     */
    private $sports;
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
     * @var bool
     */
    private $tv;
    /**
     * The type of education the college offers
     * "2-year", "4-year", "vocational", "online", "Grad School"
     * @var string
     */
    private $type;
    /**
     * @var CollegeWebsite[]
     */
    private $websites;
    /**
     * @var float
     */
    private $womenRatio;

    /**
     * @param int $pkID
     * @throws Exception
     */
    public function __construct1(int $pkID)
    {
        $dbc = new DatabaseConnection();
        $params = ["i", $pkID];
        $college = $dbc->query("select", "SELECT * FROM `tblcollege` WHERE `pkcollegeid`=?", $params);
        $campus = $dbc->query("select", "SELECT * FROM tblcollegecampus WHERE fkcollegeid=?", $params);
        $finaid = $dbc->query("select", "SELECT * FROM tblfinalcialaid WHERE fkcollegeid = ?", $params);

        if ($college and $campus and $finaid) {
            $result = [
                $this->setPkID($college["pkcollegeid"]),
                $this->setName($college["nmcollege"]),
                $this->setType($college["entype"]),
                $this->setStreetAddress($college["txstreetaddress"]),
                $this->setCity($college["txcity"]),
                $this->setProvince(new Province($college["fkprovinceid"], Province::MODE_DbID)),
                $this->setPostalCode($college["nzip"]),
                $this->setPhone($college["nphone"]),//must occur after setProvince
                $this->setTuitionIn($college["ninstate"]),
                $this->setTuitionOut($college["noutstate"]),
                $this->setFinAid($finaid["naverage"]),
                $this->setAcceptRate($college["nacceptrate"]),
                $this->setProfCount($college["nprof"]),
                $this->setStudentCount($college["nsize"]),
                $this->setWomenRatio($college["nwomenratio"]),
                $this->setACT($college["nact"]),
                $this->setSAT($college["nsat"]),
                $this->setSetting($college["ensetting"]),
                $this->setLibrary($campus["haslibrary"]),
                $this->setDorms($campus["hasdorm"]),
                $this->setApartments($campus["hasapartments"]),
                $this->setRoomCost($campus["nroomcost"]),
                $this->setBoardCost(((is_null($campus["nroomboardcost"]) or is_null($campus["nroomcost"])) ? $campus["nroomboardcost"] : ($campus["nroomboardcost"] - $campus["nroomcost"]))),
                $this->setRoommates($campus["hasroommates"]),
                $this->setRoommatesChoosable($campus["chooseroommates"]),
                $this->setMealPlan($campus["hasmealplan"]),
                $this->setHealthCenter($campus["hashealthcenter"]),
                $this->setLegal($campus["haslegal"]),
                $this->setCounseling($campus["hascounseling"]),
                $this->setRecCenter($campus["hasreccenter"]),
                $this->setFinAidAwarded($finaid["naveawarded"]),
                $this->setFinAidFreshmen($finaid["navefresh"]),
                $this->setFinAidGrant($finaid["ngrant"]),
                $this->setFinAidInternaional($finaid["naveinternational"]),
                $this->setFinAidLoan($finaid["nloan"])
            ];
            $this->inDatabase = true;
            $params = ["i", $this->getPkID()];

            $this->removeAllMajors();
            $majors = $dbc->query("select multiple", "SELECT `fkmajorid` FROM `tblmajorcollege` WHERE `fkcollegeid` = ?", $params);
            if ($majors) {
                foreach ($majors as $major) {
                    $result[] = $this->addMajor(new CollegeMajor($major["fkmajorid"], $college["pkcollegeid"]));
                }
            }
            $this->removeAllWebsites();
            $websites = $dbc->query("select multiple", "SELECT `txsite` FROM `tblcollegesite` WHERE `fkcollegeid` = ?", $params);
            if ($websites) {
                foreach ($websites as $website) {
                    $result[] = $this->addWebsite(new CollegeWebsite($this, $website["txsite"]));
                }
            }
            $this->removeAllSports();
            $sports = $dbc->query("select multiple", "SELECT * FROM `tblcollegesports` WHERE `fkcollegeid` = ?", $params);
            if ($sports) {
                foreach ($sports as $sport) {
                    $result[] = $this->addSport(new CollegeSport($sport["fksportsid"], $this, $sport["iswomen"]));
                }
            }
            $this->removeAllGreeks();
            $greeks = $dbc->query("select multiple", "SELECT fkgreekid FROM tblgreekcollege WHERE fkcollegeid = ?", $params);
            if ($greeks) {
                foreach ($greeks as $greek) {
                    $result[] = $this->addGreek(new Greek($greek["fkgreekid"]));
                }
            }
            $this->removeAllScholarships();
            $scholarships = $dbc->query("select multiple", "SELECT pkcscholarship FROM tblcollegescholarship WHERE fkcollegeid = ?", $params);
            if ($scholarships) {
                foreach ($scholarships as $scholarship) {
                    $result[] = $this->addScholarship(new CollegeScholarship($scholarship["pkcscholarship"]));
                }
            }
            if (in_array(false, $result, true)) {
                throw new Exception("College->__construct1($pkID) - Unable to construct College object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
            $this->synced = true;
        } else {
            throw new InvalidArgumentException("College->__construct1($pkID) - College not found");
        }
    }

    /**
     * //TODO: update constructor 17 for handling college campus info & finaid info
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
     * @param Greek $greek
     * @return int|bool
     */
    public function addGreek(Greek $greek)
    {
        if (in_array($greek, $this->getGreeks())) {
            return false;
        } else {
            $this->synced = false;
            return array_push($this->greeks, $greek);
        }
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
     * @param CollegeScholarship $scholarship
     * @return bool|int
     */
    public function addScholarship(CollegeScholarship $scholarship)
    {
        if (in_array($scholarship, $this->getScholarships())) {
            return false;
        } else {
            $this->synced = false;
            return array_push($this->scholarships, $scholarship);
        }
    }

    /**
     * @param CollegeSport $sport
     * @return bool|int
     */
    public function addSport(CollegeSport $sport)
    {
        if (in_array($sport, $this->getSports())) {
            return false;
        } else {
            $this->synced = false;
            return array_push($this->sports, $sport);
        }
    }

    /**
     * @param CollegeWebsite $website
     * @return bool
     */
    public function addWebsite(CollegeWebsite $website): bool
    {
        if (in_array($website, $this->getWebsites())) {
            return false;
        } else {
            $this->synced = false;
            return array_push($this->websites, $website);
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
     * @return int|null
     */
    public function getBoardCost(): ?int
    {
        return $this->boardCost;
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
     * @return int|null
     */
    public function getFinAidAwarded(): ?int
    {
        return $this->finAidAwarded;
    }

    /**
     * @return int|null
     */
    public function getFinAidFreshmen(): ?int
    {
        return $this->finAidFreshmen;
    }

    /**
     * @return int|null
     */
    public function getFinAidGrant(): ?int
    {
        return $this->finAidGrant;
    }

    /**
     * @return int|null
     */
    public function getFinAidInternaional(): ?int
    {
        return $this->finAidInternaional;
    }

    /**
     * @return int|null
     */
    public function getFinAidLoan(): ?int
    {
        return $this->finAidLoan;
    }

    /**
     * @return Greek[]|null
     */
    public function getGreeks()
    {
        return $this->greeks;
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
     * Gets an existing rating of this college for a student, or calculates a new rating and saves it to the database if
     * none existed already.
     *
     * @param Student $student
     * @return float|bool
     */
    public function getRating(Student $student)
    {
        $dbc = new DatabaseConnection();
        $params = ["ii", $this->getPkID(), $student->getPkID()];
        $rating = $dbc->query("select", "SELECT npoints FROM tblcollegepoints WHERE fkcollegeid=? AND fkeduprofileid=?", $params);
        if ($rating) {
            return $rating["npoints"];
        } else {
            $newRating = CollegeRanker::scoreCollege($student, $this);
            $params = ["iid", $this->getPkID(), $student->getPkID(), $newRating];
            $result = $dbc->query("insert", "INSERT INTO tblcollegepoints (fkcollegeid, fkeduprofileid, npoints) VALUES (?,?,?)", $params);
            if ($result) {
                return $newRating;
            } else {
                return false;
            }
        }
    }

    /**
     * @return int|null
     */
    public function getRoomCost(): ?int
    {
        return $this->roomCost;
    }

    /**
     * @return int|null
     */
    public function getSAT()
    {
        return $this->sat;
    }

    /**
     * @return CollegeScholarship[]|null
     */
    public function getScholarships()
    {
        return $this->scholarships;
    }

    /**
     * @return string|null
     */
    public function getSetting()
    {
        return $this->setting;
    }

    /**
     * @return CollegeSport[]
     */
    public function getSports()
    {
        return $this->sports;
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
     * @return CollegeWebsite[]
     */
    public function getWebsites()
    {
        return $this->websites;
    }

    /**
     * @return float|null
     */
    public function getWomenRatio()
    {
        return $this->womenRatio;
    }

    /**
     * @return bool|null
     */
    public function hasApartments(): ?bool
    {
        return $this->apartments;
    }

    /**
     * @return bool|null
     */
    public function hasBand(): ?bool
    {
        return $this->band;
    }

    /**
     * @return bool|null
     */
    public function hasChoral(): ?bool
    {
        return $this->choral;
    }

    /**
     * @return bool|null
     */
    public function hasCounseling(): ?bool
    {
        return $this->counseling;
    }

    /**
     * @return bool|null
     */
    public function hasDorms(): ?bool
    {
        return $this->dorms;
    }

    /**
     * @return bool|null
     */
    public function hasDrama(): ?bool
    {
        return $this->drama;
    }

    /**
     * @return bool|null
     */
    public function hasHealthCenter(): ?bool
    {
        return $this->healthCenter;
    }

    /**
     * @return bool|null
     */
    public function hasLegal(): ?bool
    {
        return $this->legal;
    }

    /**
     * @return bool|null
     */
    public function hasLibrary(): ?bool
    {
        return $this->library;
    }

    /**
     * @return bool|null
     */
    public function hasMealPlan(): ?bool
    {
        return $this->mealPlan;
    }

    /**
     * @return bool|null
     */
    public function hasNewspaper(): ?bool
    {
        return $this->newspaper;
    }

    /**
     * @return bool|null
     */
    public function hasRadio(): ?bool
    {
        return $this->radio;
    }

    /**
     * @return bool|null
     */
    public function hasRecCenter(): ?bool
    {
        return $this->recCenter;
    }

    /**
     * @return bool|null
     */
    public function hasRoommates(): ?bool
    {
        return $this->roommates;
    }

    /**
     * @return bool|null
     */
    public function hasRoommatesChoosable(): ?bool
    {
        return $this->roommatesChoosable;
    }

    /**
     * @return bool|null
     */
    public function hasTv(): ?bool
    {
        return $this->tv;
    }

    /**
     * @return bool
     */
    public function removeAllGreeks(): bool
    {
        $this->syncHandler($this->greeks, $this->getGreeks(), []);
        return true;
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
     * @return bool
     */
    public function removeAllScholarships(): bool
    {
        $this->syncHandler($this->scholarships, $this->getScholarships(), []);
        return true;
    }

    /**
     * @return bool
     */
    public function removeAllSports(): bool
    {
        $this->syncHandler($this->sports, $this->getSports(), []);
        return true;
    }

    /**
     * @return bool
     */
    public function removeAllWebsites(): bool
    {
        $this->syncHandler($this->websites, $this->getWebsites(), []);
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

    //TODO: update function with tblcollegecampus and tblfinancialaid saving functionality

    //TODO: update function to encapsulate functionality with DB transaction
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
                "ssssisiiidiidiisi",
                $this->getName(),
                $this->getType(),
                $this->getStreetAddress(),
                $this->getCity(),
                $this->getProvince()->getPkID(),
                $this->getPostalCode(),
                $this->getPhone(),
                $this->getTuitionIn(),
                $this->getTuitionOut(),
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
                                  `nphone`=?,`ninstate`=?,`noutstate`=?,`nacceptrate`=?,
                                  `nprof`=?,`nsize`=?,`nwomenratio`=?,`nact`=?,`nsat`=?,`ensetting`=?
                                  WHERE pkcollegeid = ?", $params);

            $params = ["i", $this->getPkID()];
            $result = ($result and $dbc->query("delete", "DELETE FROM `tblmajorcollege` WHERE `fkcollegeid`=?", $params));

            $result = ($result and $dbc->query("delete", "DELETE FROM `tblcollegesports` WHERE `fkcollegeid`=?", $params));

            $result = ($result and $dbc->query("delete", "DELETE FROM `tblcollegesite` WHERE `fkcollegeid`=?", $params));

            $result = ($result and $dbc->query("delete", "DELETE FROM tblgreekcollege WHERE fkcollegeid = ?", $params));

            //TODO: Add support for updating scholarships to the DB
//            $result = ($result and $dbc->query("delete", "DELETE FROM tblcollegescholarship WHERE fkcollegeid = ?", $params));

            $this->synced = $result;
        } else {
            $params = [
                "ssssisiiidiidiis",
                $this->getName(),
                $this->getType(),
                $this->getStreetAddress(),
                $this->getCity(),
                $this->getProvince()->getPkID(),
                $this->getPostalCode(),
                $this->getPhone(),
                $this->getTuitionIn(),
                $this->getTuitionOut(),
                $this->getAcceptRate(),
                $this->getProfCount(),
                $this->getStudentCount(),
                $this->getWomenRatio(),
                $this->getACT(),
                $this->getSAT(),
                $this->getSetting()
            ];
            $result = $dbc->query("insert", "INSERT INTO `tblcollege`(`pkcollegeid`, `nmcollege`, `entype`, 
                                          `txstreetaddress`, `txcity`, `fkprovinceid`, `nzip`, `nphone`, 
                                          `ninstate`, `noutstate`, `nacceptrate`, `nprof`, `nsize`, 
                                          `nwomenratio`, `nact`, `nsat`, `ensetting`)
                                          VALUES  (NULL,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", $params);

            $result2 = $dbc->query("select", "SELECT LAST_INSERT_ID() AS lii");
            $this->setPkID($result2["lii"]);

            $this->inDatabase = $result;
        }

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
        foreach ($this->getSports() as $sport) {
            $params = [
                "iiiiii",
                $sport->getPkID(),
                $this->getPkID(),
                $sport->isWomen(),
                $sport->isTeam(),
                $sport->isClub(),
                $sport->isScholarship()
            ];
            $result = ($result and $dbc->query("insert", "INSERT INTO `tblcollegesports` (`fksportsid`,`fkcollegeid`,iswomen,isteam,isclub,isscholarship) VALUES (?,?,?,?,?,?)", $params));
        }
        foreach ($this->getWebsites() as $website) {
            $params = [
                "iss",
                $this->getPkID(),
                $website->getName(),
                $website->getURL()
            ];
            $result = ($result and $dbc->query("insert", "INSERT INTO `tblcollegesite` (`fkcollegeid`,txsite,txlink) VALUES (?,?,?)", $params));
        }
        foreach ($this->getGreeks() as $greek) {
            $params = [
                "ii",
                $greek->getPkID(),
                $this->getPkID()
            ];
            $result = ($result and $dbc->query("insert", "INSERT INTO tblgreekcollege (fkgreekid, fkcollegeid) VALUES (?,?)", $params));
        }
        //TODO: add support for updating scholarships to the DB
//        foreach ($this->getScholarships() as $scholarship) {
//            $params = [
//                "ii",
//                $scholarship->getPkID(),
//                $this->getPkID()
//            ];
//            $result = ($result and $dbc->query("insert", "INSERT INTO tblgreekcollege (fkgreekid, fkcollegeid) VALUES (?,?)", $params));
//        }

        $this->synced = $result;

        return (bool)$result;
    }

    /**
     * @param int|null $act
     * @return bool
     */
    public function setACT($act): bool
    {
        if (is_null($act) or ($act <= 36 and $act >= 1)) {
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
     * @param bool $apartments
     * @return bool
     */
    public function setApartments(bool $apartments): bool
    {
        $this->syncHandler($this->apartments, $this->hasApartments(), $apartments);
        return true;
    }

    /**
     * @param bool $band
     * @return bool
     */
    public function setBand(bool $band): bool
    {
        $this->syncHandler($this->band, $this->hasBand(), $band);
        return true;
    }

    /**
     * @param int|null $boardCost
     * @return bool
     */
    public function setBoardCost(?int $boardCost): bool
    {
        if (is_null($boardCost)) {
            $this->syncHandler($this->boardCost, $this->getBoardCost(), $boardCost);
            return true;
        } else if ($boardCost >= 0) {
            $this->syncHandler($this->boardCost, $this->getBoardCost(), $boardCost);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param bool $choral
     * @return bool
     */
    public function setChoral(bool $choral): bool
    {
        $this->syncHandler($this->choral, $this->hasChoral(), $choral);
        return true;
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
     * @param bool $counseling
     * @return bool
     */
    public function setCounseling(bool $counseling): bool
    {
        $this->syncHandler($this->counseling, $this->hasCounseling(), $counseling);
        return true;
    }

    /**
     * @param bool $dorms
     * @return bool
     */
    public function setDorms(bool $dorms): bool
    {
        $this->syncHandler($this->dorms, $this->hasDorms(), $dorms);
        return true;
    }

    /**
     * @param bool $drama
     * @return bool
     */
    public function setDrama(bool $drama): bool
    {
        $this->syncHandler($this->drama, $this->hasDrama(), $drama);
        return true;
    }

    /**
     * @param int|null $finAid
     * @return bool
     */
    public function setFinAid($finAid): bool
    {
        if (is_null($finAid) or $finAid >= 0) {
            $this->syncHandler($this->finAid, $this->getFinAid(), $finAid);
            return true;
        }
        return false;
    }

    /**
     * @param int|null $finAidAwarded
     * @return bool
     */
    public function setFinAidAwarded(?int $finAidAwarded): bool
    {
        if (is_null($finAidAwarded) or $finAidAwarded >= 0) {
            $this->syncHandler($this->finAidAwarded, $this->getFinAidAwarded(), $finAidAwarded);
            return true;
        }
        return false;
    }

    /**
     * @param int|null $finAidFreshmen
     * @return bool
     */
    public function setFinAidFreshmen(?int $finAidFreshmen): bool
    {
        if (is_null($finAidFreshmen) or $finAidFreshmen >= 0) {
            $this->syncHandler($this->finAidFreshmen, $this->getFinAidFreshmen(), $finAidFreshmen);
            return true;
        }
        return false;
    }

    /**
     * @param int|null $finAidGrant
     * @return bool
     */
    public function setFinAidGrant(?int $finAidGrant): bool
    {
        if (is_null($finAidGrant) or $finAidGrant >= 0) {
            $this->syncHandler($this->finAidGrant, $this->getFinAidGrant(), $finAidGrant);
            return true;
        }
        return false;
    }

    /**
     * @param int|null $finAidInternaional
     * @return bool
     */
    public function setFinAidInternaional(?int $finAidInternaional): bool
    {
        if (is_null($finAidInternaional) or $finAidInternaional >= 0) {
            $this->syncHandler($this->finAidInternaional, $this->getFinAidInternaional(), $finAidInternaional);
            return true;
        }
        return false;
    }

    /**
     * @param int|null $finAidLoan
     * @return bool
     */
    public function setFinAidLoan(?int $finAidLoan): bool
    {
        if (is_null($finAidLoan) or $finAidLoan >= 0) {
            $this->syncHandler($this->finAidLoan, $this->getFinAidLoan(), $finAidLoan);
            return true;
        }
        return false;
    }

    /**
     * @param bool $healthCenter
     * @return bool
     */
    public function setHealthCenter(bool $healthCenter): bool
    {
        $this->syncHandler($this->healthCenter, $this->hasHealthCenter(), $healthCenter);
        return true;
    }

    /**
     * @param bool $legal
     * @return bool
     */
    public function setLegal(bool $legal): bool
    {
        $this->syncHandler($this->legal, $this->hasLegal(), $legal);
        return true;
    }

    /**
     * @param bool $library
     * @return bool
     */
    public function setLibrary(bool $library): bool
    {
        $this->syncHandler($this->library, $this->hasLibrary(), $library);
        return true;
    }

    /**
     * @param bool $mealPlan
     * @return bool
     */
    public function setMealPlan(bool $mealPlan): bool
    {
        $this->syncHandler($this->mealPlan, $this->hasMealPlan(), $mealPlan);
        return true;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function setName(string $name): bool
    {
        $this->syncHandler($this->name, $this->getName(), $name);
        return true;
    }

    /**
     * @param bool $newspaper
     * @return bool
     */
    public function setNewspaper(bool $newspaper): bool
    {
        $this->syncHandler($this->newspaper, $this->hasNewspaper(), $newspaper);
        return true;
    }

    /**
     * @param int|null $phone
     * @return bool
     */
    public function setPhone($phone): bool
    {
        if (is_null($phone)) {
            $this->syncHandler($this->phone, $this->getPhone(), $phone);
            return true;
        }
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
     * @param int|null $profCount
     * @return bool
     */
    public function setProfCount($profCount): bool
    {
        if (is_null($profCount) or $profCount >= 1) {
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
     * @param bool $radio
     * @return bool
     */
    public function setRadio(bool $radio): bool
    {
        $this->syncHandler($this->radio, $this->hasRadio(), $radio);
        return true;
    }

    /**
     * @param bool $recCenter
     * @return bool
     */
    public function setRecCenter(bool $recCenter): bool
    {
        $this->syncHandler($this->recCenter, $this->hasRecCenter(), $recCenter);
        return true;
    }

    /**
     * @param int|null $roomCost
     * @return bool
     */
    public function setRoomCost(?int $roomCost): bool
    {
        if (is_null($roomCost)) {
            $this->syncHandler($this->roomCost, $this->getRoomCost(), null);
            return true;
        } else if ($roomCost >= 0) {
            $this->syncHandler($this->roomCost, $this->getRoomCost(), $roomCost);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param bool $roommates
     * @return bool
     */
    public function setRoommates(bool $roommates): bool
    {
        $this->syncHandler($this->roommates, $this->hasRoommates(), $roommates);
        return true;
    }

    /**
     * @param bool $roommatesChoosable
     * @return bool
     */
    public function setRoommatesChoosable(bool $roommatesChoosable): bool
    {
        $this->syncHandler($this->roommatesChoosable, $this->hasRoommatesChoosable(), $roommatesChoosable);
        return true;
    }

    /**
     * @param int|null $sat
     * @return bool
     */
    public function setSAT($sat): bool
    {
        if (is_null($sat) or ($sat <= 1600 and $sat >= 400)) {
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
     * @param bool $tv
     * @return bool
     */
    public function setTv(bool $tv): bool
    {
        $this->syncHandler($this->tv, $this->hasTv(), $tv);
        return true;
    }

    /**
     * @param string|null $type
     * @return bool
     */
    public function setType($type): bool
    {
        switch ($type) {
            case self::TYPE_PRIVATE:
            case self::TYPE_PUBLIC:
            case null:
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
        if ($womenRatio >= 0 and $womenRatio <= 1) {
            $this->syncHandler($this->womenRatio, $this->getWomenRatio(), $womenRatio);
            return true;
        }
        return false;
    }

    /**
     * Forcefully changes the current college's rating with a student, then returns the new rating
     *
     * @param Student $student
     * @return bool|float
     */
    public function updateRating(Student $student)
    {
        $dbc = new DatabaseConnection();
        $params = ["ii", $this->getPkID(), $student->getPkID()];
        $rating = $dbc->query("select", "SELECT npoints FROM tblcollegepoints WHERE fkcollegeid=? AND fkeduprofileid=?", $params);
        if ($rating) {
            $newRating = CollegeRanker::scoreCollege($student, $this);
            $params = ["dii", $newRating, $this->getPkID(), $student->getPkID()];
            $result = $dbc->query("insert", "UPDATE tblcollegepoints SET npoints=? WHERE fkcollegeid=? AND fkeduprofileid=?", $params);
            if ($result) {
                return $newRating;
            } else {
                return false;
            }
        } else {
            $newRating = CollegeRanker::scoreCollege($student, $this);
            $params = ["iid", $this->getPkID(), $student->getPkID(), $newRating];
            $result = $dbc->query("insert", "INSERT INTO tblcollegepoints (fkcollegeid, fkeduprofileid, npoints) VALUES (?,?,?)", $params);
            if ($result) {
                return $newRating;
            } else {
                return false;
            }
        }
    }
}