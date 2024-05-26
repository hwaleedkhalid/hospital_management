<?php
require_once '../models/Patient.php';

class PatientController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // View patient dashboard
    public function dashboard() {
        // Logic to fetch patient's information from the database
        $patientModel = new Patient($this->conn);
        $patient = $patientModel->getPatientById($_SESSION['user_id']);
        
        // Include view file for patient dashboard
        include '../src/views/patient/dashboard.php';
    }

    // View medical records
    public function viewMedicalRecords() {
        // Logic to fetch medical records for the patient
        include '../src/views/patient/medical_records.php';
    }

    // View appointments
    public function viewAppointments() {
        // Logic to fetch appointments for the patient
        include '../src/views/patient/appointments.php';
    }

    // Add a new patient
    public function addPatient($name, $email, $phone, $address, $gender, $dob) {
        $patient = new Patient($this->conn);
        if ($patient->addPatient($name, $email, $phone, $address, $gender, $dob)) {
            // Patient added successfully, redirect to dashboard or display success message
            header("location: ?url=patient/dashboard");
        } else {
            // Error adding patient, redirect to dashboard or display error message
            header("location: ?url=patient/dashboard");
        }
    }

    // Update patient information
    public function updatePatient($id, $name, $email, $phone, $address, $gender, $dob) {
        $patient = new Patient($this->conn);
        if ($patient->updatePatient($id, $name, $email, $phone, $address, $gender, $dob)) {
            // Patient information updated successfully, redirect to dashboard or display success message
            header("location: ?url=patient/dashboard");
        } else {
            // Error updating patient information, redirect to dashboard or display error message
            header("location: ?url=patient/dashboard");
        }
    }

    // Delete patient
    public function deletePatient($id) {
        $patient = new Patient($this->conn);
        if ($patient->deletePatient($id)) {
            // Patient deleted successfully, redirect to dashboard or display success message
            header("location: ?url=patient/dashboard");
        } else {
            // Error deleting patient, redirect to dashboard or display error message
            header("location: ?url=patient/dashboard");
        }
    }
}
?>
