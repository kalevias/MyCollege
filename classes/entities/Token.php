<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/6/2018
 * Time: 1:22 PM
 */

class Token extends DataBasedEntity{
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
            $this->synced = true;
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
        $this->synced = false;
    }

    /**
     * Returns the data stored in this Token instance only if the provided $purpose and $user match the $purpose and
     * $user stored internally. This is the preferred function for accessing the $data attribute of the Token class.
     *
     * @param string $purpose
     * @param User $user
     * @return mixed|bool
     */
    public function getDataIfValid(string $purpose, User $user)
    {
        if ($this->getPurpose() === $purpose and $this->getUser()->getEmail() === $user->getEmail()) {
            return $this->getData();
        } else {
            return false;
        }
    }

    /**
     * @return DateTime|null
     */
    public function getExpiration()
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
     * @return string|null
     */
    public function getPurpose()
    {
        return $this->purpose;
    }

    /**
     * @return string|null
     */
    public function getTokenID()
    {
        return $this->tokenID;
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function setData($data): bool
    {
        $this->syncHandler($this->data, $this->getData(), $data);
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
                $this->syncHandler($this->expiration, $this->getExpiration(), $expiration);
            } else if (gettype($expiration) == "int") {
                $this->syncHandler($this->expiration, $this->getExpiration(), new DateTime(date('Y-m-d H:i:s', $expiration)));
            } else if (gettype($expiration) == "string") {
                $this->syncHandler($this->expiration, $this->getExpiration(), new DateTime($expiration));
            } else {
                return false;
            }
        } else {
            $this->syncHandler($this->expiration, $this->getExpiration(), new DateTime());
        }
        return true;
    }

    /**
     * @param string $purpose
     * @return bool
     */
    public function setPurpose(string $purpose): bool
    {
        $this->syncHandler($this->purpose, $this->getPurpose(), $purpose);
        return true;
    }

    /**
     * @param string|null $tokenID
     * @return bool
     */
    public function setTokenID(string $tokenID = null): bool
    {
        if ($this->isInDatabase()) {
            return false;
        } else {
            if (isset($tokenID)) {
                $dbc = new DatabaseConnection();
                if (strlen($tokenID) <= $dbc->getMaximumLength("tbltokens", "pktokenid")) {
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
        $this->syncHandler($this->user, $this->getUser(), $user);
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
            try {
                $this->__construct1($this->getTokenID());
            } catch (Exception $e) {
                return false;
            }
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
            $result = $dbc->query("update", "UPDATE `tbltokens` SET `jsonget` = ?, `dtexpire` = ?, `txemail` = ? WHERE `pktokenid` = ?", $params);
        } else {
            $params = [
                "ssss",
                $this->getTokenID(),
                $this->getJSONData(),
                $this->getExpiration()->format("Y-m-d H:i:s"),
                $this->getUser()->getEmail()
            ];
            $result = $dbc->query("insert", "INSERT INTO `tbltokens` (`pktokenid`, `jsonget`, `dtexpire`, `txemail`) VALUES (?,?,?,?)", $params);
        }
        $this->inDatabase = $this->synced = (bool)$result;
        return (bool)$result;
    }

	/**
	 * Removes this token from the database.
	 * Returns true if the update was completed successfully, false otherwise.
	 *
	 * @return bool
	 */
	public function removeFromDatabase(): bool
	{
		$dbc = new DatabaseConnection();
		if ($this->isInDatabase()) {
			$params = [
				"i",
				$this->getTokenID()
			];
			$result = $dbc->query("update", "DELETE FROM `tbltokens` WHERE `pktokenid` = ?", $params);
		}else{
			$result = true;
		}
		return (bool)$result;
	}

    /**
     * @return mixed|null
     */
    private function getData()
    {
        return $this->data;
    }

}