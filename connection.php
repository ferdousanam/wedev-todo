<?php

function getConnection() {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "todo";
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// Set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
		return $e->getMessage();
	}
}

?>
