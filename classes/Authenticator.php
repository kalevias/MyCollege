<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 20/01/18
 * Time: 15:01
 */

class Authenticator
{

    /**
     * Logs the user into the website
     *
     * @param $email
     * @param $password
     * @throws Exception
     * @return bool
     */
    public static function login($email, $password): bool
    {
        global $homedir;
        //connect to database
        if (Controller::isUserLoggedIn()) {
            return false;
        } else {
            /*
             * Determines whether the client connected to the current session should be locked out
             * of logging in to the system due to too many repeated log in attempts. This helps to
             * prevent dictionary attacks against the system by forcing a 60 second wait period after
             * 5 failed attempts to log in by the client.
             */
            if (Controller::getLoginLockout() !== false) {
                if (time() - Controller::getLoginLockout() >= 60) {
                    Controller::setLoginFails();
                    Controller::setLoginLockout();
                } else {
                    throw new Exception("Authenticator::login($email,$password) - Login failed too many times; wait 60 seconds to try again");
                }
            }
            $user = User::load($email);
            if (isset($user)) {
                $goodPass = Hasher::verifyCryptographicHash($password, $user->getHash());

                if ($goodPass) {
                    Controller::setLoggedInUser($user);
                    Controller::setLoginLockout();
                    Controller::setLoginFails();
                    $controller = $_SESSION["controller"];
                    header("Location: " . $controller->getHomeDir());
                    return true;
                } else {
                    if (Controller::getLoginFails() !== false) {
                        if (Controller::getLoginFails() > 5) {
                            Controller::setLoginLockout(time());
                        } else {
                            Controller::setLoginFails(Controller::getLoginFails() + 1);
                        }
                    } else {
                        Controller::setLoginFails(1);
                    }
                    throw new Exception("Authenticator:login($email,$password) - User credentials incorrect; bad password");
                }
            } else {
                throw new Exception("Authenticator::login($email,$password) - User credentials incorrect; unable to find email address");
            }
        }
    }

    /**
     * Logs the user out of the website
     */
    public static function logout(): bool
    {
        if (Controller::isUserLoggedIn()) {
            Controller::setLoggedInUser();
            $controller = $_SESSION["controller"];
            header("Location: " . $controller->getHomeDir());
            return true;
        } else {
            return false;
        }
    }

    public static function registerRepresentative($fName, $lName, $email, $altEmail, $address, $city, $province, $postalCode, $phone, $gradYear, $password)
    {
        //TODO: upon implementing email verification, the "true" below should be changed to false
        $user = new User($fName, $lName, $email, $altEmail, $address, $city, $province, $postalCode, $phone, $gradYear, $password, true);
        try {
            $user->addPermission(new Permission(Permission::PERMISSION_REPRESENTATIVE));
        } catch (Exception $e) {
            return false;
        }
        if (self::userExists($user)) {
            return false;
        } else {
            $user->updateToDatabase();
            return true;
        }
    }

    public static function registerStudent($fName, $lName, $email, $altEmail, $address, $city, $province, $postalCode, $phone, $gradYear, $password, $confirmPassword)
    {
        if($password === $confirmPassword) {
            //TODO: upon implementing email verification, the "true" below should be changed to false
            $user = new User($fName, $lName, $email, $altEmail, $address, $city, $province, $postalCode, $phone, $gradYear, $password, true);
            try {
                $user->addPermission(new Permission(Permission::PERMISSION_STUDENT));
            } catch (Exception $e) {
                return false;
            }
            if (self::userExists($user)) {
                return false;
            } else {
                $user->updateToDatabase();
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Checks whether the given user is registered in the system.
     * Returns true if the user is registered, false otherwise.
     *
     * @param User $user
     * @return bool
     */
    public static function userExists(User $user): bool
    {
        $loadedUser = User::load($user->getEmail());
        return isset($loadedUser);
    }
}