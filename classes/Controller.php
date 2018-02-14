<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/6/2018
 * Time: 1:20 PM
 */

class Controller
{
    const MODE_COMP_AND = 2;
    const MODE_COMP_OR = 1;
    const MODULE_DIR = "pages" . DIRECTORY_SEPARATOR;

    /**
     * Page-wide connection to the database. To be used throughout the Controller class, instead of continually
     * instantiating new instances of DatabaseConnection.
     *
     * @var DatabaseConnection
     */
    private $dbc;
    /**
     * Relative path to the root directory of the site (of the site, not the web-server)
     *
     * @var string
     */
    private $homeDir;
    /**
     * String containing a relative path to the subdirectory of the "pages" directory that the current page lies within.
     *
     * @var string
     */
    private $moduleDir;
    /**
     * An array that contains the output of the spamScrubber function after it has been applied to the content of an
     * HTTP POST or HTTP GET request.
     *
     * @var mixed[]
     */
    private $scrubbed;
    /**
     * Integer storing a counter that can be used to indicate the order that the user will traverse inputs by pressing
     * the tab key.
     *
     * @var int
     */
    private $tabIncrement;

    /**
     * Controller constructor. A new Constructor instance should be created on each page in the site.
     *
     * @param string $pageTitle
     */
    public function __construct(string $pageTitle)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->scrubbed = array_map(array($this, "spamScrubber"), $_POST);
        $this->dbc = new DatabaseConnection();
        $this->tabIncrement = 1;
        $this->setHomeDir();
    }

    /**
     * Returns the currently logged in user's User object or null if no user is logged in.
     *
     * @return User|null
     */
    public static function getLoggedInUser()
    {
        if (self::isUserLoggedIn()) {
            return $_SESSION["user"];
        } else {
            return null;
        }
    }

    /**
     * Returns the current count of login failures. If unable to access the loginFails SESSION variable, then
     * the function will return false.
     *
     * WARNING: it may be difficult to distinguish the return value of this function using ==
     * (as 0 and false are equivalent). If checking the output of the function, it is recommended for you to use
     * the identity operator, ===, instead of the equivalence operator.
     *
     * @return int|bool
     */
    public static function getLoginFails()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            if (isset($_SESSION["loginFails"])) {
                return $_SESSION["loginFails"];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Returns the last time login lockout was initiated (should be a UNIX timestamp). If the variable that stores
     * the timestamp cannot be accessed, false will be returned.
     *
     * WARNING: it may be difficult to distinguish the return value of this function using ==
     * (as 0 and false are equivalent). If checking the output of the function, it is recommended for you to use
     * the identity operator, ===, instead of the equivalence operator.
     *
     * @return int|bool
     */
    public static function getLoginLockout()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            if (isset($_SESSION["loginLockout"])) {
                return $_SESSION["loginLockout"];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Indicates whether or not the currently connected client has logged in as a user of the site.
     *
     * @return bool
     */
    public static function isUserLoggedIn(): bool
    {
        return isset($_SESSION["user"]);
    }

    /**
     * Sets the current client's User object to the one specified, or null if none are given.
     * Returns true on success, throws a LogicException/InvalidArgumentException on failure.
     *
     * @param User|null $user
     * @return bool
     * @throws LogicException
     */
    public static function setLoggedInUser(User $user = null): bool
    {
        if ($user === null) {
            unset($_SESSION["user"]);
            return true;
        } else if ($user->isSynced()) {
            $_SESSION["user"] = $user;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sets the number of login fails to the specified $fails value. If no value is passed, the function will unset
     * the current fail counter.
     * Returns true on success, false on failure. (only fails if a Php session has not been started)
     *
     * @param int|null $fails
     * @return bool
     */
    public static function setLoginFails(int $fails = null): bool
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            if (isset($fails)) {
                $_SESSION["loginFails"] = $fails;
            } else {
                unset($_SESSION["loginFails"]);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sets the login lockout variable to the specified $lockout value. If the value of $lockout is null, then the
     * login lockout variable will be unset.
     * Returns true on success, false on failure.
     *
     * @param int|null $lockout
     * @return bool
     */
    public static function setLoginLockout(int $lockout = null): bool
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            if (isset($lockout)) {
                $_SESSION["loginLockout"] = $lockout;
            } else {
                unset($_SESSION["loginLockout"]);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * A string sanitizer that removes undesirable selections of text from the input string. Returns an empty string if
     * any of the following are found in the input string:
     * 'to:', 'cc:', 'bcc:', 'content-type:', 'mime-version:', 'multipart-mixed:', 'content-transfer-encoding:'
     * Otherwise, returns the input string with the following replaced by a single space, and all HTML tags removed:
     * "\r", "\n", "%0a", "%0d"
     *
     * @param $value
     * @return string
     */
    private static function spamScrubber(string $value): string
    {
        // This function is useful for preventing spam in form results.  Should be used on all $_POST arrays.
        // To Use:  $scrubbed=array_map('spam_scrubber',ARRAY_NAME);  Where ARRAY_NAME might be equal to an array such as $_POST
        // Then refer to the item in the array as $scrubbed['item_name']

        // List of very bad values:

        $very_bad = array('to:', 'cc:', 'bcc:', 'content-type:', 'mime-version:', 'multipart-mixed:', 'content-transfer-encoding:');
        // IF any of the very bad strings are in the submitted value, return an empty string:
        foreach ($very_bad as $v) {
            if (stripos($value, $v) !== false) {
                return '';
            }
        }
        // Replace any newline characters with spaces:
        //strip_tags() will remove all HTML and PHP tags. Safe, but remove if HTML formatting required.
        $value = strip_tags(str_replace(array("\r", "\n", "%0a", "%0d"), ' ', $value));
        return trim($value);
    }

    /**
     * This function (enum2options) retrieves an enum field from a table and echoes
     * the possible values for that enum field as options for an HTML select
     * element.
     *
     * Warning: this function uses direct SQL injection with its function parameters,
     * so you MUST ensure user data never gets passed to this function.
     *
     * @param $table
     * @param $field
     * @return bool|string false on failure; string otherwise
     */
    function enum2Options($table, $field)
    {
        $column = $this->dbc->query("select", "SHOW COLUMNS FROM `$table` WHERE FIELD = '$field'");

        if ($column) {

            $enum = $column["Type"];

            if (substr($enum, 0, 4) == "enum") {
                preg_match_all("~\'(.*)\'~U", $enum, $values);
                $values = $values[1];

                $output = "";
                foreach ($values as $value) {
                    $output .= "<option value='$value'>$value</option>\n";
                }
                return $output;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * field2options, does the same as enum2options, but
     * instead of getting all possible values of enums, it retrieves all of values
     * of a given field stored in a given table. This may be useful for foreign
     * key constraints requiring select elements.
     *
     * Warning: this function uses direct SQL injection with its function parameters,
     * so you MUST ensure user data never gets passed to this function.
     *
     * @param $table
     * @param $field
     * @return bool|string false on failure; string otherwise
     */
    function field2Options($table, $field)
    {

        $columns = $this->dbc->query("select multiple", "SELECT `$field` FROM `$table`");

        if ($columns) {

            $output = "";
            foreach ($columns as $column) {
                $value = $column[$field];
                $output .= "<option value='$value'>$value</option>";
            }
            return $output;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getAbsoluteHomeDir(): string
    {
        return $_SERVER["DOCUMENT_ROOT"] . $this->homeDir;
    }

    /**
     * @return string
     */
    public function getHomeDir(): string
    {
        return $this->homeDir;
    }

    /**
     * @return string
     */
    public function getModuleDir(): string
    {
        return $this->moduleDir;
    }

    /**
     * @return int
     */
    public function getTabIncrement(): int
    {
        return $this->tabIncrement;
    }

    /**
     * @return string
     */
    public function getWindowsHomeDir(): string
    {
        return str_replace("\\", "/", $this->getHomeDir());
    }

    /**
     * @return bool
     */
    public function initModuleDir(): bool
    {
        $stack = debug_backtrace();
        $pathToCaller = $stack[0]['file'];
        if (stripos($pathToCaller, rtrim(Controller::MODULE_DIR, "/"))) {
            $pathArr = explode(DIRECTORY_SEPARATOR, $pathToCaller);
            $nextDir = array_search(rtrim(Controller::MODULE_DIR, "/"), $pathArr) + 1;
            $this->moduleDir = Controller::MODULE_DIR . $pathArr[$nextDir] . "/";
            return true;
        }
        return false;
    }

    /**
     * A middle-man to handle requests of the http variety
     * @return bool
     */
    public function processREQUEST(): bool
    {
        switch (strtoupper($_SERVER["REQUEST_METHOD"])) {
            case "POST":
                return $this->processPOST();
                break;
            case "GET":
                return $this->processGET();
                break;
            default:
                return false;
        }
    }

    /**
     * @param int $tabIncrement
     * @return bool
     */
    public function setTabIncrement(int $tabIncrement): bool
    {
        if ($filtered = filter_var($tabIncrement, FILTER_VALIDATE_INT)) {
            $this->tabIncrement = $filtered;
            return true;
        }
        return false;
    }

    /**
     * @return int
     */
    public function useTabIncrement(): int
    {
        return $this->tabIncrement++;
    }

    /**
     * Indicates whether the current user has any or all of the required permissions  listed in $permissions.
     * The use of either "any" or "all" depends on the comparison mode, specified by $mode.
     * $permissions must be an array of Permission objects.
     *
     * @param Permission[] $permissions
     * @param int $mode
     * @return bool
     */
    public function userHasAccess(array $permissions, int $mode = self::MODE_COMP_AND): bool
    {
        $user = self::getLoggedInUser();
        if (isset($user) and $mode === self::MODE_COMP_AND) {
            $result = true;
            foreach ($permissions as $perm) {
                $result = ($result and $user->hasPermission($perm));
            }
            return $result;
        } else if (isset($user) and $mode === self::MODE_COMP_OR) {
            $result = false;
            foreach ($permissions as $perm) {
                $result = ($result or $user->hasPermission($perm));
            }
            return $result;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    private function processGET(): bool
    {
        $this->scrubbed = array_map(array("Controller", "spamScrubber"), $_GET);
        //TODO: Finish implementation via switch-case for various GET submit types.
        //reset the password
        if (isset($this->scrubbed["token"])) {
            //Check if token is in database
            $token = null;
            try {
                $token = new Token($this->scrubbed["token"]);
            } catch (Exception $e) {
                $_SESSION["resetToken"] = false;
                return false;
            }
            //check if token has expired by subtracting current time from experation time
            $timeDiff = $token->getExpiration()->diff(new DateTime("now"));
            //if token is expired kick out
            if ($timeDiff <= 0) {
                $result = false;
            } else {
                $result = true;
            }
            //remove token
            $token->removeFromDatabase();
            unset($token);
            $_SESSION["resetToken"] = $result;
            return (bool)$result; //temporary return value
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    private function processPOST(): bool
    {
        $this->scrubbed = array_map(array("Controller", "spamScrubber"), $_POST);
        switch ($this->scrubbed["requestType"]) {
            /**
             * Required POST variables for this case:
             *      requestType : "registerStudent"
             *        firstName : string
             *         lastName : string
             *            email : string (email format)
             *         altEmail : string (email format)
             *    streetAddress : string
             *             city : string
             *         province : string (ISO code)
             *       postalCode : string <=10 characters in length
             *      phoneNumber : int <=15 digits in length
             *         gradYear : int 4 digits in length
             *         password : string
             *  confirmPassword : string
             */
            case "registerStudent":
                $args = [
                    $this->scrubbed["firstName"],
                    $this->scrubbed["lastName"],
                    $this->scrubbed["email"],
                    $this->scrubbed["altEmail"],
                    $this->scrubbed["streetAddress"],
                    $this->scrubbed["city"],
                    $this->scrubbed["province"],
                    $this->scrubbed["postalCode"],
                    $this->scrubbed["phoneNumber"],
                    $this->scrubbed["gradYear"],
                    $this->scrubbed["password"],
                    $this->scrubbed["confirmPassword"]
                ];
                try {
                    $success = call_user_func_array("Authenticator::registerStudent", $args);
                    if ($success) {
                        $_SESSION["localNotifications"][] = "Yay! You have an account on MyCollege now! Be sure to activate your email via the link we just sent you.";
                    } else {
                        $_SESSION["localWarnings"][] = "Warning: unable to register a new account; passwords may not match, user may already be registered";
                    }
                } catch (Exception | Error $e) {
                    $_SESSION["localErrors"][] = $e;
                }
                break;
            /**
             * Required POST variables for this case:
             *      requestType : "registerRepresentative"
             * //TODO: fill in other required fields
             */
            case "registerRepresentative":
                //TODO: complete representative registration handling
                $args = [

                ];
//                call_user_func_array("Authenticator::registerRepresentative", $args);
                break;
            /**
             * Required POST variables for this case:
             *      requestType : "login"
             *            email : string
             *         password : string
             */
            case "login":
                $args = [
                    $this->scrubbed["email"],
                    $this->scrubbed["password"]
                ];
                try {
                    $success = call_user_func_array("Authenticator::login", $args);
                    if (!$success) {
                        $_SESSION["localWarnings"][] = "Warning: Login failure; account inactive";
                    }
                } catch (Exception | Error $e) {
                    $_SESSION["localErrors"][] = $e;
                }
                break;
            /**
             * Required POST variables for this case:
             *      requestType : "logout"
             */
            case "logout":
                try {
                    $success = Authenticator::logout();
                    if (!$success) {
                        $_SESSION["localWarnings"][] = "Warning: Logout failure; no user logged in; How'd you even manage to trigger this error???";
                    }
                } catch (Exception | Error $e) {
                    $_SESSION["localErrors"][] = $e;
                }
                break;

            /**
             * Required POST variables for this case:
             *     requestType : "sentResetEmail"
             *           email : string (email format)
             */
            case "sentResetEmail":
                $email = $this->scrubbed["email"];
                //check if user exists
                $user = User::load($email);
                if ($user == null) {
                    $_SESSION["resetFail"] = true;
                    break;
                }
                //create a DateTime representing 24 hours in the future
                $expiration = (new DateTime())->add(new DateInterval("P1D"));
                //Create a token representing a temporary link to reset password
                $token = new Token("resetPasswordLink", $expiration, $user);
                //send email to user
                try {
                    $mail = new PHPMailer();
                    $mail->setFrom("myCollegeOfficial@gmail.com", "MyCollege");
                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    $mail->Subject = "MyCollege Password Reset";
                    //create a link to password reset page with the token ID as a parameter
                    $path = "http://localhost/mycollege/pages/passwordreset/passwordreset.php?tokenID={$token->getTokenID()}";
                    //create the body of the email
                    $body = "Congrats on losing your password, here is your second chance don't screw it up this time.\n";
                    $body .= "<a href=\"{$path}\">Click Me!";
                    $mail->Body = $body;
                    if ($mail->send() == false) {
                        $success = false;
                    } else {
                        $success = true;
                    }
                } catch (phpmailerException $e) {
                    $success = false;
                }
                $_SESSION["resetFail"] = !$success;
                break;
            case "resetPassword":
                $args = [
                    $this->scrubbed["password"],
                    $this->scrubbed["confirmPassword"]
                ];
                $success = call_user_func_array("Authenticator::resetPassword", $args);
                $_SESSION["resetPasswordFail"] = !$success;
        }
        return true; //temporary return value
    }

    /**
     * @return bool
     */
    private function setHomeDir(): bool
    {
        //Although DIRECTORY_SEPARATOR should be used here, $_SERVER["SCRIPT_NAME'] only reports paths using, "/",
        //even if the OS doesn't use it as the DIRECTORY_SEPARATOR
        $path = explode("/", dirname($_SERVER["SCRIPT_NAME"]));
        $homeDir = "";
        foreach ($path as $dir) {
            if ($dir != "" and $dir != rtrim(AutoLoader::PROJECT_DIR(), DIRECTORY_SEPARATOR)) {
                $homeDir .= ".." . DIRECTORY_SEPARATOR;
            }
        }
        $this->homeDir = $homeDir;
        return true;
    }
}