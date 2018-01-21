<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 20/01/18
 * Time: 16:44
 */

class DatabaseConnection{
	public static function databaseConnect(){
		$conn = new mysqli("localhost", "root", "", "mycollege");
			//Check if connection has failed
		if($conn->connect_errno){
			//If connection failed print error number and message
			error_log("Failed to connect to MySQL database 'mycollege', Connect Error: " . $conn->connect_errno . ", Error Message: " . $conn->connect_error);
			//TODO: Redirect to error page
			$conn = "error";
		}
		return $conn;
	}
}