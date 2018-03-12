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
                    if ($user->isActive()) {
                        if($user->hasPermission(new Permission(Permission::PERMISSION_STUDENT))) {
                            $student = new Student($email,Student::MODE_NAME);
                            if(isset($student)) {
                                Controller::setLoggedInUser($student);
                            } else {
                                return false;
                            }
                        } else {
                            Controller::setLoggedInUser($user);
                        }
                        Controller::setLoginLockout();
                        Controller::setLoginFails();
                        return true;
                    } else {
                        return false;
                    }
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
            return Controller::setLoggedInUser();
        } else {
            return false;
        }
    }

    /**
     * @param $fName
     * @param $lName
     * @param $email
     * @param $altEmail
     * @param $address
     * @param $city
     * @param $province
     * @param $postalCode
     * @param $phone
     * @param $gradYear
     * @param $password
     * @return bool
     * @throws Exception
     */
    public static function registerRepresentative($fName, $lName, $email, $altEmail, $address, $city, $province, $postalCode, $phone, $gradYear, $password)
    {
        //TODO: upon implementing email verification, the "true" below should be changed to false
        $user = new User($fName, $lName, $email, $altEmail, $address, $city, new Province($province, Province::MODE_ISO), $postalCode, $phone, $gradYear, $password, true);
        $user->addPermission(new Permission(Permission::PERMISSION_REPRESENTATIVE));
        if (self::userExists($user)) {
            return false;
        } else {
            $user->updateToDatabase();
            return true;
        }
    }

    /**
     * @param $fName
     * @param $lName
     * @param $email
     * @param $altEmail
     * @param $address
     * @param $city
     * @param $province
     * @param $postalCode
     * @param $phone
     * @param $gradYear
     * @param $password
     * @param $confirmPassword
     * @return bool
     * @throws Exception
     */
    public static function registerStudent($fName, $lName, $email, $altEmail, $address, $city, $province, $postalCode, $phone, $gradYear, $password, $confirmPassword)
    {
        if ($password === $confirmPassword) {
            //TODO: upon implementing email verification, the "true" below should be changed to false
            $user = new User($fName, $lName, $email, $altEmail, $address, $city, new Province($province, Province::MODE_ISO), $postalCode, $phone, $gradYear, $password, false);
            $user->addPermission(new Permission(Permission::PERMISSION_STUDENT));
            if (self::userExists($user)) {
                return false;
            } else {
                $user->updateToDatabase();
                return self::login($user->getEmail(), $password);
            }
        } else {
            return false;
        }
    }

    public static function sendRegistrationEmail($email){
		try{
			//check if user exists
			$user = User::load($email);
			if($user == null){
				$_SESSION["resetFail"] = true;
				$_SESSION["localNotifications"][] = "User with the given e-mail address is not found";
				break;
			}
			//Create a token representing a temporary link to reset password
			$token = new Token("loginFirstTime", null, $user);
			//send email to user
			$mailman = new Mailman();
			//create email body
			//create a link to password reset page with the token ID as a parameter
			$path = "http://localhost/mycollege/pages/login/login.php?tokenID={$token->getTokenID()}";
			//create the body of the email
			$body = "Welcome to MyCollege, click on the link to log in.\n";
			$body .= "<a href=\"{$path}\">Click Me!";
			//send email
			$success = $mailman->sendEmail($email, "Welcome to MyCollege", $body);
			$_SESSION["resetFail"] = !$success;
		} catch (Exception | Error $e) {
			$_SESSION["localErrors"][] = "Error: Unable to send registration email";
		}
	}

	public static function activateUser($email, $password, $tokenID){

	}


    /**
     * @param $email
     * @param $password
     * @param $confirmPassword
     * @return bool
     */
    public static function resetPassword($email, $password, $confirmPassword): bool
    {
        //check if password matches
        if ($password === $confirmPassword) {
            $user = User::load($email);
            if ($user != null) {
                //add the new password to the current user
                $user->updatePassword($password);
                //commit to database
                $result = $user->updateToDatabase();
                return $result;
            } else {
                return false;
            }
        } else {
			$_SESSION["localWarnings"][] = "Warning: Passwords do not match";
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