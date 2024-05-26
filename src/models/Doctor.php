<?php
class Doctor {
    private $conn;
    private $table_name = "doctors";

    public $id;
    public $name;
    public $email;
    public $phone;
    public $specialization;
    public $department_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all doctors
    public function getAllDoctors() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get doctor by ID
    public function getDoctorById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Add a new doctor
    public function addDoctor($name, $email, $phone, $specialization, $department_id) {
        $query = "INSERT INTO " . $this->table_name . " (name, email, phone, specialization, department_id) VALUES (:name, :email, :phone, :specialization, :department_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':specialization', $specialization);
        $stmt->bindParam(':department_id', $department_id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Update doctor
    public function updateDoctor($id, $name, $email, $phone, $specialization, $department_id) {
        $query = "UPDATE " . $this->table_name . " SET name = :name, email = :email, phone = :phone, specialization = :specialization, department_id = :department_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':specialization', $specialization);
        $stmt->bindParam(':department_id', $department_id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Delete doctor
    public function deleteDoctor($id) {
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
