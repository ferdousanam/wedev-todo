<?php

require_once '../vendor/autoload.php';

use Controllers\ToDoController;

$todo = new ToDoController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (isset($_GET['id'])) {
		// Get To Do by id
		echo $todo->show($_GET['id']);
	} elseif (isset($_GET['status'])) {
		// Get To Do list by status
		echo $todo->getAllByStatus($_GET['status']);
	} else {
		// Get all To Do list
		echo $todo->index();
	}
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if (isset($_POST['delete']) && isset($_POST['id'])) {
		// Delete To Do
		if ($_POST['delete'] == true) {
			echo $todo->destroy($_POST['id']);
		} else {
			header('Content-Type: application/json');
			return json_encode(false);
		}
	} else if (isset($_POST['method']) && $_POST['method'] == 'PUT') {
		// Update Status
		if (isset($_POST['id']) && $_POST['status']) {
			echo $todo->updateStatus($_POST['id'], $_POST['status']);
		} else {
			header('Content-Type: application/json');
			echo json_encode(['error' => 'id and status field are required']);
		}
	} else if (isset($_POST['clear_completed']) && $_POST['clear_completed'] == true) {
		// Store To Do
		echo $todo->destroyByStatus(2);
	} else if (isset($_POST['title'])) {
		// Store To Do
		echo $todo->store($_POST);
	} else {
		header('Content-Type: application/json');
		echo json_encode(['error' => 'Invalid Request']);
	}
} else {
	header('Content-Type: application/json');
	echo json_encode(['error' => 'Whoops! Something Went Wrong']);
}
