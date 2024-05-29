<?php
require_once '../../config/database.php';
require_once '../../src/models/Appointment.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize database connection
    $database = new Database();
    $db = $database->getConnection();

    // Initialize Appointment object
    $appointment = new Appointment($db);

    // Get form data
    $id = isset($_POST['id']) ? $_POST['id'] : die('Appointment ID is required');
    $patient_id = isset($_POST['patient_id']) ? $_POST['patient_id'] : die('Patient ID is required');
    $doctor_id = isset($_POST['doctor_id']) ? $_POST['doctor_id'] : die('Doctor ID is required');
    $date = isset($_POST['date']) ? $_POST['date'] : die('Date is required');
    $time = isset($_POST['time']) ? $_POST['time'] : die('Time is required');
    $status = isset($_POST['status']) ? $_POST['status'] : die('Status is required');

    // Update appointment details
    if ($appointment->updateAppointment($id, $patient_id, $doctor_id, $date, $time, $status)) {
        header('Location: /hospital_management/public/index.php?url=admin/dashboard');
        exit();
    } else {
        echo "Failed to update appointment.";
    }
}
?>
