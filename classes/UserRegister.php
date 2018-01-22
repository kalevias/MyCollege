<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 20/01/18
 * Time: 16:38
 */
require_once "DatabaseConnection.php";
class UserRegister{
	public static function register($userFirstName, $userLastName, $userEmail, $userAddress, $userCity, $userProvince, $userZip, $userPhone, $userGradYear, $userPassword){
		//hash and unset passowrd field as soon as possible
		$userHash = password_hash($userPassword, PASSWORD_DEFAULT);
		unset($userPassword);
		//Open connection to database
		$conn = DatabaseConnection::databaseConnect();
		//check if user exists
		$query = $conn->prepare("SELECT pkuserid FROM tbluser WHERE txemail = ?");
		$query->bind_param("s", $userEmail);
		$query->execute();
		$result = $query->get_result();
		//handle error if can't query database
		if($result == false){
			die("Failed to query user from database 'mycollege'\nConnect Error: " . $conn->connect_errno . "\nError Message: " . $conn->connect_error);
		}
		if($result->num_rows == 1){
			//user already exists in database
			//TODO: spit out message asking user try a different email
			//redirect back to original page hopefully with all the same data in the fields
			return false;
		}
		//create query from user
		$query = $conn->prepare("INSERT INTO tbluser (nmfirst, nmlast, txemail, txstreetaddress, txcity, fkprovinceid, nzip, nphone, dtgradyear, txhash) VALUES (?, ?, ?, ?, ?, 1, ?, 1234567890, ?, ?)");
		$query->bind_param("sssssiis", $userFirstName, $userLastName, $userEmail, $userAddress, $userCity, $userZip, $userGradYear, $userHash);
		$result = $query->execute();
		$query->close();
		//$result = $query->get_result();
		//check if insert failed
		if($result == false){
			//Guess I'll die
			//TODO: redirect to error page
			die("Failed to insert user to database 'mycollege'\nConnect Error: " . $conn->connect_errno . "\nError Message: " . $conn->connect_error);
		}else{

			return true;
		}
		//send confirmation message and redirect user to login screen
		//send email

	}

}