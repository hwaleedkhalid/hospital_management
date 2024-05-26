<?php
class Patient {
    private $conn;
    private $table_name = "patients";

    public $id;
    public $name;
    public $email;
    public $phone;
    public $address;
    public $gender;
    public $dob;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all patients
    public function getAllPatients() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get patient by ID
    public function getPatientById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Add a new patient
    public function addPatient($name, $email, $phone, $address, $gender, $dob) {
        $query = "INSERT INTO " . $this->table_name . " (name, email, phone, address, gender, dob) VALUES (:name, :email, :phone, :address, :gender, :dob)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':dob', $dob);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Update patient
    public function updatePatient($id, $name, $email, $phone, $address, $gender, $dob) {
        $query = "UPDATE " . $this->table_name . " SET name = :name, email = :email, phone = :phone, address = :address, gender = :gender, dob = :dob WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':dob', $dob);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Delete patient
    public function deletePatient($id) {
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
