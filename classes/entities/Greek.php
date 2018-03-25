<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 3/24/2018
 * Time: 4:41 PM
 */

class Greek
{
    const TYPE_COED = "Co-Ed";
    const TYPE_FRATERNITY = "Fraternity";
    const TYPE_SORORITY = "Sorority";
    /**
     * A 4 digit year
     *
     * @var int
     */
    private $founded;
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $pkID;
    /**
     * @var string
     */
    private $type;

    /**
     * Greek constructor.
     * @param int $pkID
     * @throws Exception
     */
    public function __construct(int $pkID)
    {
        $dbc = new DatabaseConnection();
        $params = ["i", $pkID];
        $greek = $dbc->query("select", "SELECT * FROM tblgreek WHERE pkgreekid = ?", $params);
        if ($greek) {
            $result = [
                $this->setPkID($greek["pkgreekid"]),
                $this->setName($greek["nmgreek"]),
                $this->setType($greek["enfrat"]),
                $this->setFounded($greek["nfound"])
            ];
            if (in_array(false, $result, true)) {
                throw new Exception("Greek->__construct($pkID) -  Unable to construct Greek object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
        } else {
            throw new Exception("Greek->__construct($pkID) -  Unable to select from database");
        }
    }

    /**
     * @return int
     */
    public function getFounded(): int
    {
        return $this->founded;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param int $founded
     * @return bool
     */
    private function setFounded(int $founded): bool
    {
        $this->founded = $founded;
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
        $this->pkID = $pkID;
        return true;
    }

    /**
     * @param string $type
     * @return bool
     */
    private function setType(string $type): bool
    {
        switch ($type) {
            case self::TYPE_COED:
            case self::TYPE_FRATERNITY:
            case self::TYPE_SORORITY:
                $this->type = $type;
                return true;
            default:
                return false;
        }
    }


}