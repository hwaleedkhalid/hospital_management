<?php
class MedicalRecord {
    private $conn;
    private $table_name = "medical_records";

    public $id;
    public $patient_id;
    public $date;
    public $description;
    public $treatment;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get medical history by patient ID
    public function getMedicalHistoryByPatient($patient_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE patient_id = :patient_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':patient_id', $patient_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
