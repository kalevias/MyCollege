<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 3/10/2018
 * Time: 11:01 AM
 */

//TODO: class currently only set up to pull data from database, but it should be extended from DataBasedEntity eventually
class CollegeWebsite
{
    /**
     * @var string
     */
    private $URL;
    /**
     * @var string
     */
    private $name;
    /**
     * @var College
     */
    private $college;

    /**
     * CollegeWebsite constructor.
     * @param College $college
     * @param string $name
     * @throws Exception
     */
    public function __construct(College &$college, string $name) {
        $dbc = new DatabaseConnection();
        if($college->isInDatabase()) {
            $params = ["is",$college->getPkID(), $name];
            $website = $dbc->query("select", "SELECT * FROM tblcollegesite WHERE fkcollegeid=? AND txsite=?", $params);
            if($website) {
                $result = [
                    $this->setCollege($college),
                    $this->setName($website["txsite"]),
                    $this->setURL($website["txlink"])
                ];
                if (in_array(false, $result, true)) {
                    throw new Exception("CollegeWebsite->__construct(".$college->getName().", $name) -  Unable to construct CollegeWebsite object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
                }
            } else {
                throw new Exception("CollegeWebsite->__construct(".$college->getName().", $name) -  Unable to select from database");
            }
        } else {
            throw new Exception("CollegeWebsite->__construct(".$college->getName().", $name) -  College not stored in database; unable to query for site");
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
     * @return College
     */
    public function getCollege(): College
    {
        return $this->college;
    }

    /**
     * @return string
     */
    public function getURL(): string
    {
        return $this->URL;
    }

    /**
     * @param string $URL
     * @return bool
     */
    private function setURL(string $URL): bool
    {
        if(filter_var($URL, FILTER_VALIDATE_URL)) {
            $this->URL = $URL;
            return true;
        } else {
            return false;
        }
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
     * @param College $college
     * @return bool
     */
    private function setCollege(College $college): bool
    {
        if($college->isInDatabase()) {
            $this->college = $college;
            return true;
        } else {
            return false;
        }
    }

}