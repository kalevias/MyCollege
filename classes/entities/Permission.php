<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/6/2018
 * Time: 2:10 PM
 */

class Permission
{

    const PERMISSION_ADMIN = 2;
    const PERMISSION_PARENT = 4;
    const PERMISSION_REPRESENTATIVE = 3;
    const PERMISSION_STUDENT = 1;

    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $pkID;

    /**
     * Permission constructor.
     * @param int $permissionID
     * @throws Exception
     */
    public function __construct(int $permissionID)
    {
        $dbc = new DatabaseConnection();
        $params = ["i", $permissionID];
        $permission = $dbc->query("select", "SELECT * FROM `tblpermission` WHERE `pkpermissionid`=?", $params);
        if ($permission) {
            $result = [
                $this->setPkID($permissionID),
                $this->setName($permission["nmname"]),
                $this->setDescription($permission["txdescription"])
            ];
            if (in_array(false, $result, true)) {
                throw new Exception("Permission->__construct($permissionID) -  Unable to construct Permission object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
        } else {
            throw new Exception("Permission->__construct($permissionID) -  Unable to select from database");
        }
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "{" . implode(" ", [$this->getPkID(), $this->getName()]) . "}";
    }

    /**
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
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
     * @param string $description
     * @return bool
     */
    public function setDescription(string $description): bool
    {
        $dbc = new DatabaseConnection();
        if (strlen($description) <= $dbc->getMaximumLength("permission", "txDescription")) {
            $this->description = $description;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public function setName(string $name): bool
    {
        $dbc = new DatabaseConnection();
        $params = ["s", $name];
        if ($dbc->query("exists", "SELECT * FROM `permission` WHERE `nmName`=?", $params)) {
            $this->name = $name;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param int $permissionID
     * @return bool
     */
    private function setPkID(int $permissionID): bool
    {
        $this->permissionID = $permissionID;
        return true;
    }


}