<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 20/01/18
 * Time: 16:38
 */

class UserRegister{
	public static function userRegister($userFirstName, $userLastName, $userEmail, $userAddress, $userCity, $userProvince, $userZip, $userPhone, $userGradYear, $userPassword){
		//hash and unset passowrd field as soon as possible
		$userHash = password_hash($userPassword);
		unset($userPassword);
		//Open connection to database
		$conn = DatabaseConnection::databaseConnect();
		//check if user exists
		$query = "SELECT pkuserid FROM tbluser WHERE txemail = " . $userEmail;
		$result = $conn->query($query);
		//handle error if can't query database
		if($result == false){
			die("Failed to query user from database 'mycollege'\nConnect Error: " . $conn->connect_errno . "\nError Message: " . $conn->connect_error);
		}
		if($result->num_rows == 1){
			//user already exists in database
			//TODO: spit out message asking user try a different email
			//redirect back to original page hopefully with all the same data in the fields
		}
		//create query from user
		$query = "INSERT INTO tbluser (nmfirst, nmlast, txemail, txstreetaddress, txcity, nzip, nphone, dtgradyear, txhash) ";
		$query .= "VALUES ({$userFirstName},{$userLastName},{$userEmail},{$userAddress},{$userCity},";
		$query .= "{$userZip},{$userPhone},{$userGradYear},{$userHash})";
		$result = $conn->query($query);
		//check if insert failed
		if($result == false){
			//Guess I'll die
			//TODO: redirect to error page
			die("Failed to insert user to database 'mycollege'\nConnect Error: " . $conn->connect_errno . "\nError Message: " . $conn->connect_error);
		}
		//send confirmation message and redirect user to login screen
		//send email

	}

}