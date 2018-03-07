<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 3/7/2018
 * Time: 1:28 PM
 */

class CollegeSport extends Sport
{
    /**
     * @var bool
     */
    private $women;
    /**
     * @var bool
     */
    private $team;
    /**
     * @var bool
     */
    private $club;
    /**
     * @var bool
     */
    private $scholarship;

    /**
     * CollegeSport constructor.
     * @param int $pkID
     * @param College $college
     * @param bool $women
     * @throws Exception
     */
    public function __construct(int $pkID, College $college, bool $women)
    {
        parent::__construct($pkID);
        $dbc = new DatabaseConnection();
        $params = ["iii", $pkID, $college->getPkID(), $women];
        $sport = $dbc->query("select", "SELECT * FROM tblcollegesports WHERE fksportsid = ? AND fkcollegeid = ? AND iswomen=?", $params);
        if ($sport) {
            $result = [
                $this->setWomen($women),
                $this->setTeam($sport["isteam"]),
                $this->setClub($sport["isclub"]),
                $this->setScholarship($sport["isscholarship"])
            ];
            if (in_array(false, $result, true)) {
                throw new Exception("CollegeSport->__construct($pkID,".$college->getName()."$women) - Unable to construct CollegeSport object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
        } else {
            throw new Exception("CollegeSport->__construct($pkID,".$college->getName()."$women) - CollegeSport not found");
        }
    }

    /**
     * @return bool
     */
    public function isWomen(): bool
    {
        return $this->women;
    }

    /**
     * @param bool $women
     * @return bool
     */
    private function setWomen(bool $women): bool
    {
        $this->women = $women;
        return true;
    }

    /**
     * @return bool
     */
    public function isTeam(): bool
    {
        return $this->team;
    }

    /**
     * @param bool $team
     * @return bool
     */
    private function setTeam(bool $team): bool
    {
        $this->team = $team;
        return true;
    }

    /**
     * @return bool
     */
    public function isClub(): bool
    {
        return $this->club;
    }

    /**
     * @param bool $club
     * @return bool
     */
    private function setClub(bool $club): bool
    {
        $this->club = $club;
        return true;
    }

    /**
     * @return bool
     */
    public function isScholarship(): bool
    {
        return $this->scholarship;
    }

    /**
     * @param bool $scholarship
     * @return bool
     */
    private function setScholarship(bool $scholarship): bool
    {
        $this->scholarship = $scholarship;
        return true;
    }


}