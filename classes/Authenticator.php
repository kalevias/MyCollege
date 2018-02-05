<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 20/01/18
 * Time: 15:01
 */
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
require_once $homedir . "classes/DatabaseConnection.php";
class Authenticator{

    /**
     * Logs the user into the website
     *
     * @param $userEmail
     * @param $password
     */
	public static function login($userEmail, $password){
	    global $homedir;
		//connect to database
		$dbc = new DatabaseConnection();
		//find user
        $userExists = $dbc->query("exists", "SELECT pkuserid FROM tbluser WHERE txemail = ?", ["s", $userEmail]);
		//check if user exists
		if(!$userExists){
			//TODO: make message somehow?
			//Guess I'll die
			die("User not found");
		}else{
			//get values from user in database
			$user = $dbc->query("select", "SELECT pkuserid, txemail, txhash FROM tbluser WHERE txemail = ?", ["s", $userEmail]);
		}
		//verify password to stored hashed password
		if(password_verify($password, $user["txhash"])){
			//User has valid password and now permissions will be set
			$_SESSION["userPermission"] = self::getPermissions($user["pkuserid"]);
		}else{
			//TODO: make incorrect password message
			//Guess I'll die
			die("User not found?");
		}
		//if everything is successful show that the user is logged in with a session variable
		$_SESSION["userLoggedIn"] = true;
        header("Location: ".$homedir);
	}

    /**
     * Logs the user out of the website
     */
	public static function logout(){
	    global $homedir;
		unset($_SESSION["userPermission"]);
		unset($_SESSION["userLoggedIn"]);
		header("Location: ".$homedir);
	}

    public static function register($fName, $lName, $email, $address, $city, $province, $zip, $phone, $gradYear, $password){
        //hash and unset passowrd field as soon as possible
        $userHash = password_hash($password, PASSWORD_DEFAULT);
        //Open connection to database
        $dbc = new DatabaseConnection();
        $userExists = $dbc->query("exists", "SELECT pkuserid FROM tbluser WHERE txemail = ?", ["s", $email]);
        if($userExists){
            //TODO: spit out message asking user try a different email
            //TODO: redirect back to original page hopefully with all the same data in the fields
            return false;
        }
        //create query from user
        $params = ["sssssiis", $fName, $lName, $email, $address, $city, $zip, $gradYear, $userHash];
        $insert = $dbc->query("insert", "INSERT INTO tbluser (nmfirst, nmlast, txemail, txstreetaddress, txcity, fkprovinceid, nzip, nphone, dtgradyear, txhash) VALUES (?, ?, ?, ?, ?, 1, ?, 1234567890, ?, ?)", $params);
        if(!$insert){
            //Guess I'll die
            //TODO: redirect to error page
            die("Unable to insert new user into the database");
        }else{
            return true;
        }
        //TODO: send confirmation message and redirect user to login screen
    }

    /**
     * Gets the permissions assigned to a user
     *
     * @param $userID
     * @return mixed
     */
	private static function getPermissions($userID){
		//setup query to join the permissions table and the user-permssions table
        $dbc = new DatabaseConnection();
        $params = ["s", $userID];
		$permissions = $dbc->query("select", "SELECT nmname FROM tblpermission JOIN tbluserpermissions ON tblpermission.pkpermissionid = tbluserpermissions.fkpermissionid WHERE fkuserid = ?", $params);
		return $permissions["nmname"];
	}
}