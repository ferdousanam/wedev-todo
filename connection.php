<?php
require_once 'vendor/autoload.php';

function getConnection() {
	$dbConnection = env('DB_CONNECTION', 'mysql');
	$servername = env('DB_HOST', 'localhost');
	$port = env('DB_PORT', '3306');
	$username = env('DB_USERNAME', 'root');
	$password = env('DB_PASSWORD', '');
	$dbname = env('DB_DATABASE', 'todo');
	try {
		$conn = new PDO("$dbConnection:host=$servername;port=$port;dbname=$dbname", $username, $password);
		// Set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
		return $e->getMessage();
	}
}

?>
