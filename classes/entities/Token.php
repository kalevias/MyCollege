<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/6/2018
 * Time: 1:22 PM
 */

//TODO: finish conversion of class
class Token extends DataBasedEntity
{
    /**
     * Stores data attached to a token to be used for its specified purpose.
     *
     * @var mixed
     */
    private $data;
    /**
     * Stores the timestamp at which a given token expires. After this time passes, all functions related to this
     * token should cease to function (i.e. return false, or a similar failure-indicating result).
     *
     * @var DateTime
     */
    private $expiration;
    /**
     * Stores the purpose for which a given token may be used.
     *
     * @var string
     */
    private $purpose;
    /**
     * Stores the internally used unique identifier for a given token.
     *
     * @var string
     */
    private $tokenID;
    /**
     * Stores the user who has the right to use a given token.
     *
     * @var User
     */
    private $user;

    /**
     * Constructor for Tokens stored in the database.
     *
     * @param string $tokenID
     * @throws Exception
     */
    public function __construct1(string $tokenID)
    {
        $dbc = new DatabaseConnection();

        $params = ["s", $tokenID];
        $token = $dbc->query("select", "SELECT * FROM `tbltokens` WHERE `pktokenid` = ? LIMIT 1", $params);
        if ($token) {
            $data = json_decode($token["jsonget"], true);
            $user = User::load($token["txemail"]);
            if (!isset($user)) {
                $user = new User();
                $user->setEmail($token["txemail"]);
            }
            $result = [
                $this->setTokenID($tokenID),
                $this->setPurpose($data["purpose"]),
                $this->setData($data["data"]),
                $this->setExpiration(new DateTime($token["dtexpire"])),
                $this->setUser($user)
            ];
            if (in_array(false, $result, true)) {
                throw new Exception("Token->__construct1($tokenID) - Unable to construct Token object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
            }
            $this->inDatabase = true;
        } else {
            throw new Exception("Token->__construct1($tokenID) - Unable to select from database");
        }
    }

    /**
     * Constructor for new Tokens not stored in the database.
     *
     * @param string $purpose
     * @param mixed $data
     * @param DateTime|null $expiration
     * @param User|null $user
     * @throws Exception
     */
    public function __construct2(string $purpose, mixed $data, DateTime $expiration = null, User $user = null)
    {
        if (!isset($user)) {
            if (Controller::isUserLoggedIn()) {
                $user = Controller::getLoggedInUser();
            } else {
                if (isset($expiration)) {
                    $printableExpiration = $expiration->format("Y-m-d H:i:s");
                } else {
                    $printableExpiration = null;
                }
                throw new Exception("Token->__construct2($purpose, $data, $printableExpiration, $user) - Unable to construct Token object; \$user may not be null");
            }
        }
        $result = [
            $this->setTokenID(),
            $this->setPurpose($purpose),
            $this->setData($data),
            $this->setExpiration($expiration),
            $this->setUser($user)
        ];
        if (in_array(false, $result, true)) {
            if (isset($expiration)) {
                $printableExpiration = $expiration->format("Y-m-d H:i:s");
            } else {
                $printableExpiration = null;
            }
            throw new Exception("Token->__construct2($purpose, $data, $printableExpiration, $user) - Unable to construct Token object; variable assignment failure - (" . implode(" ", array_keys($result, false, true)) . ")");
        }
        $this->inDatabase = false;
    }

    /**
     * Returns the data stored in this Token instance only if the provided $purpose and $user match the $purpose and
     * $user stored internally. This is the preferred function for accessing the $data attribute of the Token class.
     *
     * @param string $purpose
     * @param User $user
     * @return mixed|bool
     */
    public function getDataIfValid(string $purpose, User $user): mixed
    {
        if ($this->getPurpose() === $purpose and $this->getUser()->getEmail() === $user->getEmail()) {
            return $this->getData();
        } else {
            return false;
        }
    }

    /**
     * @return DateTime
     */
    public function getExpiration(): DateTime
    {
        return $this->expiration;
    }

    /**
     * Returns a JSON formatted string containing both the $purpose and $data of the current Token instance stored as
     * follows: ["purpose":$purpose, "data":$data]
     *
     * @return string
     */
    public function getJSONData(): string
    {
        return json_encode(["purpose" => $this->getPurpose(), "data" => $this->getData()]);
    }

    /**
     * @return string
     */
    public function getPurpose(): string
    {
        return $this->purpose;
    }

    /**
     * @return string
     */
    public function getTokenID(): string
    {
        return $this->tokenID;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function setData($data): bool
    {
        $this->data = $data;
        return true;
    }

    /**
     * @param int|string|DateTime|null $expiration
     * @return bool
     */
    public function setExpiration($expiration = null): bool
    {
        if (isset($expiration)) {
            if (gettype($expiration) == "object") {
                $this->expiration = $expiration;
            } else if (gettype($expiration) == "int") {
                $this->expiration = new DateTime(date('Y-m-d H:i:s', $expiration));
            } else if (gettype($expiration) == "string") {
                $this->expiration = new DateTime($expiration);
            } else {
                return false;
            }
        } else {
            $this->expiration = new DateTime();
        }
        return true;
    }

    /**
     * @param string $purpose
     * @return bool
     */
    public function setPurpose(string $purpose): bool
    {
        $this->purpose = $purpose;
        return true;
    }

    /**
     * @param string|null $tokenID
     * @return bool
     */
    public function setTokenID(string $tokenID = null): bool
    {
        if($this->isInDatabase()) {
            return false;
        } else {
            if(isset($tokenID)) {
                $dbc = new DatabaseConnection();
                if (strlen($tokenID) == $dbc->getMaximumLength("token", "pkTokenID")) {
                    $this->tokenID = $tokenID;
                    return true;
                } else {
                    return false;
                }
            } else {
                $this->tokenID = Hasher::randomHash();
                return true;
            }
        }
    }

    /**
     * @param User $user
     * @return bool
     */
    public function setUser(User $user): bool
    {
        $this->user = $user;
        return true;
    }

    /**
     * Pulls data stored in the database to the current Token instance.
     * Returns true on success, false otherwise.
     *
     * @return bool
     */
    public function updateFromDatabase(): bool
    {
        if ($this->isInDatabase()) {
            $this->__construct1($this->getTokenID());
            return true;
        } else {
            return false;
        }
    }

    /**
     * Pushes data stored in current Token instance to the database.
     * Returns true if the update was completed successfully, false otherwise.
     *
     * @return bool
     */
    public function updateToDatabase(): bool
    {
        $dbc = new DatabaseConnection();
        if ($this->isInDatabase()) {
            $params = [
                "ssss",
                $this->getJSONData(),
                $this->getExpiration()->format("Y-m-d H:i:s"),
                $this->getUser()->getEmail(),
                $this->getTokenID()
            ];
            $result = $dbc->query("update", "UPDATE `token` SET `blGet` = ?, `dtExpire` = ?, `txEmail` = ? WHERE `pkTokenID` = ?", $params);
        } else {
            $params = [
                "ssss",
                $this->getTokenID(),
                $this->getJSONData(),
                $this->getExpiration()->format("Y-m-d H:i:s"),
                $this->getUser()->getEmail()
            ];
            $result = $dbc->query("insert", "INSERT INTO `token` (`pkTokenID`, `blGet`, `dtExpire`, `txEmail`) VALUES (?,?,?,?)", $params);
        }
        return (bool)$result;
    }

    /**
     * @return mixed
     */
    private function getData(): mixed
    {
        return $this->data;
    }

}