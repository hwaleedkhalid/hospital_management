<?php
class Department {
    private $conn;
    private $table_name = "departments";

    public $id;
    public $name;
    public $description;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all departments
    public function getAllDepartments() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get department by ID
    public function getDepartmentById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Add a new department
    public function addDepartment($name, $description) {
        $query = "INSERT INTO " . $this->table_name . " (name, description) VALUES (:name, :description)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Update department
    public function updateDepartment($id, $name, $description) {
        $query = "UPDATE " . $this->table_name . " SET name = :name, description = :description WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Delete department
    public function deleteDepartment($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
