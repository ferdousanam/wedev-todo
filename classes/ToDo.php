<?php

namespace Classes;


use PDO;

class ToDo {
	private $connection;
	private $table;

	public function __construct($connection) {
		$this->connection = $connection;
		$this->table = 'todos';
	}

	public function all() {
		$stmt = $this->connection->prepare("SELECT * FROM `$this->table`");
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt->fetchAll();
	}

	public function store($data) {
		$stmt = $this->connection->prepare("INSERT INTO `$this->table` (`title`) VALUES (:title)");
		$stmt->bindParam(':title', $data['title']);
		$stmt->execute();
		$id = $this->connection->lastInsertId();
		if ($id) {
			return $this->show($id);
		} else {
			return false;
		}
	}

	public function show($id) {
		$stmt = $this->connection->prepare("SELECT * FROM `$this->table` WHERE `id` = :id");
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt->fetch();
	}

	public function destroy($id) {
		$stmt = $this->connection->prepare("DELETE FROM `$this->table` WHERE `id` = :id");
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$count = $stmt->rowCount();
		if ($count > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function destroyByStatus($status) {
		$stmt = $this->connection->prepare("DELETE FROM `$this->table` WHERE `status` = :status");
		$stmt->bindParam(':status', $status);
		$stmt->execute();
		$count = $stmt->rowCount();
		if ($count > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getAllByStatus($status) {
		$stmt = $this->connection->prepare("SELECT * FROM `$this->table` WHERE `status` = :status");
		$stmt->bindParam(':status', $status);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt->fetchAll();
	}

	public function updateStatus($id, $status) {
		$stmt = $this->connection->prepare("UPDATE `$this->table` SET `status` = :status WHERE `id` = :id");
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':status', $status);
		$stmt->execute();
		$count = $stmt->rowCount();
		if ($count > 0) {
			return true;
		} else {
			return false;
		}
	}
}
