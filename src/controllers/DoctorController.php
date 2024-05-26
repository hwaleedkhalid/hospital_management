<?php
require_once '../models/Doctor.php';
require_once '../models/Appointment.php';
require_once '../models/MedicalRecord.php';

class DoctorController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // View doctor dashboard
    public function dashboard() {
        Auth::check();
        include '../src/views/doctor/dashboard.php';
    }

    // View appointments for the doctor
    public function viewAppointments() {
        Auth::check();
        $doctor_id = $_SESSION['user_id'];
        $appointment = new Appointment($this->conn);
        $appointments = $appointment->getAppointmentsByDoctor($doctor_id);
        include '../src/views/doctor/appointments.php';
    }

    // View a specific appointment
    public function viewAppointment($appointment_id) {
        Auth::check();
        $appointment = new Appointment($this->conn);
        $appointmentDetails = $appointment->getAppointmentById($appointment_id);
        include '../src/views/doctor/view_appointment.php';
    }

    // Update appointment details
    public function updateAppointment($appointment_id) {
        Auth::check();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $appointment = new Appointment($this->conn);
            $appointment->id = $appointment_id;
            $appointment->date = $_POST['date'];
            $appointment->time = $_POST['time'];
            $appointment->status = $_POST['status'];

            if ($appointment->update()) {
                $message = "Appointment updated successfully.";
            } else {
                $message = "Failed to update appointment.";
            }
            include '../src/views/doctor/update_appointment.php';
        } else {
            $appointment = new Appointment($this->conn);
            $appointmentDetails = $appointment->getAppointmentById($appointment_id);
            include '../src/views/doctor/update_appointment.php';
        }
    }

    // Cancel appointment
    public function cancelAppointment($appointment_id) {
        Auth::check();
        $appointment = new Appointment($this->conn);
        if ($appointment->cancel($appointment_id)) {
            $message = "Appointment cancelled successfully.";
        } else {
            $message = "Failed to cancel appointment.";
        }
        include '../src/views/doctor/cancel_appointment.php';
    }

    // View patient's medical history
    public function viewPatientHistory($patient_id) {
        Auth::check();
        $medicalRecord = new MedicalRecord($this->conn);
        $history = $medicalRecord->getMedicalHistoryByPatient($patient_id);
        include '../src/views/doctor/patient_history.php';
    }

    // Other doctor-related methods
}
?>
