<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 20/01/18
 * Time: 15:01
 */

class UserLoginLogout{

	//Login method
	public static function userLogin($userEmail, $password){
		//connect to database
		$conn = DatabaseConnection::databaseConnect();
		//find user
		$query = "SELECT pkuserid, txemail, txhash FROM tbluser WHERE txemail = " . $userEmail;
		$result = $conn->query($query);
		//Check for query error
		if($result == false){
			die("Failed to query user from database 'mycollege'\nConnect Error: " . $conn->connect_errno . "\nError Message: " . $conn->connect_error);
		}
		//check if user exists
		if($result->num_rows == 0){
			//user not found in database
			//TODO: make message somehow?
			//Guess I'll die
			die("User not found?");
		}else{
			//get values from user in database
			$user = $result->fetch_row();
		}
		//verify password to stored hashed password
		if(password_verify($password, $user["txhash"])){
			//User has valid password and now permissions will be set
			$_SESSION["userPermission"] = self::getPermissions($user["pkuserid"], $conn);
		}else{
			//incorrect password
			//TODO: make incorrect password message
			//Guess I'll die
			die("User not found?");
		}
		//if everything is successful show that the user is logged in with a session variable
		$_SESSION["userLoggedIn"] = true;
		//TODO: reditect to user homepage
		header("Location: index.php");

	}


	//log out method
	public static function userLogout(){
		unset($_SESSION["userPermission"]);
		unset($_SESSION["userLoggedIn"]);
		//TODO: redirect to main public page
		header("Location: index.php");
	}

	//search the database for user permissions
	private static function getPermissions($userID, $conn){
		//setup query to join the permissions table and the user-permssions table
		$query = "SELECT nmname FROM tblpermission JOIN tbluserpermissions WHERE fkuserid = " . $userID;
		$result = $conn->query($query);
		//check if query failed
		if($result == false){
			die("Failed to query user permissions from database 'mycollege'\nConnect Error: " . $conn->connect_errno . "\nError Message: " . $conn->connect_error);
		}
		//Return the name of the permission that the user has
		return $result->fetch_row()["nmname"];
	}
}