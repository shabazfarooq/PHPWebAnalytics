<?php

class hitCounter {

	public $total_count;
	public $unique_count;

	public function __construct() {
	
	
		/**********************************************/
		/*                                            */
		/*         Establish an SQL connection        */
		/*                                            */
		/**********************************************/
	
		// Define SQL variables
		$servername = "localhost";
		$username   = "Enter your DB username";
		$password   = "Enter your DB password";
		$database   = "Enter your DB name";
		
		// Connect to the database
		$conn = new mysqli($servername, $username, $password, $database);
		
		// Throw an error if the SQL connection fails
		if ($conn->connection_error)
			die("SQL connection failed:" . $conn->connection_error);
		


		
		
		/**********************************************/
		/*                                            */
		/*         Update the count in the DB         */
		/*                                            */
		/**********************************************/
		
		
		// Retreive the connecting users IP address
		$clientIP = $_SERVER['REMOTE_ADDR'];
		
		// Retrieve the page name that the user is currently viewing
		$pageName =  basename($_SERVER['PHP_SELF']);
		
		
		// Create the necessary SQL statement to update the database
		// -- If the unique pair (ip address, page name) exists in the table then increase the count by 1
		//    otherwise, insert into the database as the first visit.
		$sql      = "INSERT INTO hit_counter (ip, page, count) VALUES('".$clientIP."', '".$pageName."', 1)
				     ON DUPLICATE KEY UPDATE count=count+1";
		

		// Throw an error if the SQL statement fails
		if ($conn->query($sql) === FALSE)
			die("SQL insert failed: " . $conn->error);	
		
		


		
		
		/**********************************************/
		/*                                            */
		/*  Calculate the Unique Count & Total Count  */
		/*                                            */
		/**********************************************/
		
		// Create the necessary SQL statement to retreive the counts
		// -- Total count  = Sum of the entire count column
		// -- Unique count = Sum of the row count of unique IP addresses found within the database
		$sql    = "SELECT 
				       tc.returnsum AS total_count, count(uc.returnsum) AS unique_count
				   FROM 
				       (SELECT sum(count) AS returnsum FROM hit_counter)             AS tc,
				       (SELECT count(ip)  AS returnsum FROM hit_counter GROUP BY ip) AS uc";
		
		
		// Execute the SQL query
		$result = $conn->query($sql);
		
		// Retreive the sum values from the query
		$row    = $result->fetch_assoc();
		
		
		// Store the unique count and total count as properties of the class
		$this->total_count  = $row['total_count'];
		$this->unique_count = $row['unique_count'];
		
		
		
		
		// Close the SQL connection
		$conn->close();
	}
	


}

?>