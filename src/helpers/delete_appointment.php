<?php
require_once '../../config/database.php';
require_once '../../src/models/Appointment.php';

// Check if appointment ID is provided
if (!isset($_GET['id'])) {
    die('Appointment ID is required');
}

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Initialize Appointment object
$appointment = new Appointment($db);

// Get appointment ID from the URL parameter
$id = $_GET['id'];

// Delete the appointment
if ($appointment->cancel($id)) {
    header('Location: /hospital_management/public/index.php?url=admin/dashboard');
    exit();
} else {
    echo "Failed to delete appointment.";
}
?>
