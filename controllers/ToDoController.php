<?php

namespace Controllers;

use Classes\ToDo;

class ToDoController {
	private $todo;

	public function __construct() {
		$conn = getConnection();
		$this->todo = new ToDo($conn);
	}

	public function index() {
		header('Content-Type: application/json');
		return json_encode($this->todo->all());
	}

	public function store($request) {
		$data = [
			'title' => $request['title'],
		];
		$inserted = $this->todo->store($data);
		header('Content-Type: application/json');
		return json_encode($inserted);
	}

	public function show($id) {
		header('Content-Type: application/json');
		return json_encode($this->todo->show($id));
	}

	public function destroy($id) {
		header('Content-Type: application/json');
		return json_encode($this->todo->destroy($id));
	}

	public function destroyByStatus($status) {
		header('Content-Type: application/json');
		return json_encode($this->todo->destroyByStatus($status));
	}

	public function getAllByStatus($status) {
		header('Content-Type: application/json');
		return json_encode($this->todo->getAllByStatus($status));
	}

	public function updateStatus($id, $status) {
		header('Content-Type: application/json');
		return json_encode($this->todo->updateStatus($id, $status));
	}
}
