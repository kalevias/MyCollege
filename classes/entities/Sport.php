<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 3/7/2018
 * Time: 1:22 PM
 */

class Sport
{
    /**
     * @var int
     */
    private $pkID;

    /**
     * @var string
     */
    private $name;

    /**
     * Sport constructor.
     * @param int $pkID
     * @throws Exception
     */
    public function __construct(int $pkID) {
        $dbc = new DatabaseConnection();
        $params = ["i", $pkID];
        $sport = $dbc->query("select", "SELECT nmsport FROM tblsports WHERE pksportsid = ?", $params);
        if ($sport) {
            $result = [
                $this->setPkID($pkID),
                $this->setName($sport["nmsport"])
            ];
            if (in_array(false, $result, true)) {
                throw new Exception("Sport->__construct($pkID) - Unable to construct Sport object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
        } else {
            throw new Exception("Sport->__construct($pkID) - Sport not found");
        }
    }

    /**
     * @return int
     */
    public function getPkID(): int
    {
        return $this->pkID;
    }

    /**
     * @param $pkID
     * @return bool
     */
    private function setPkID(int $pkID): bool
    {
        $this->pkID = $pkID;
        return true;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return bool
     */
    private function setName(string $name): bool
    {
        $this->name = $name;
        return true;
    }
}