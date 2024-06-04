<?php
// Include database connection file
require_once '../../../config/database.php';

// Initialize the $appointments variable
$appointments = [];

// Fetch appointments from the database
try {
    // Create a new instance of the Database class
    $database = new Database();
    $conn = $database->getConnection();

    // Prepare and execute a SQL query to fetch appointments for the doctor
    // Assuming you have a doctor_id stored in session or passed as a parameter
    $doctor_id = 1; // Example doctor_id, replace with actual logic to get the doctor ID
    $query = "SELECT a.appointment_date, a.appointment_time, p.name as patient_name, d.name as doctor_name, a.status, a.appointment_id 
              FROM appointments a
              JOIN patients p ON a.patient_id = p.patient_id
              JOIN doctors d ON a.doctor_id = d.doctor_id
              WHERE a.doctor_id = :doctor_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':doctor_id', $doctor_id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the appointments
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    <link rel="stylesheet" href="/hospital_management/public/css/view_appointments_doctor.css">
</head>
<body>
    <h1>View Appointments</h1>
    <div class="container">
        <div class="section">
            <h2>Appointments List</h2>
            <table>
                <thead>
                    <tr>
                        <th>Appointment ID</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Patient Name</th>
                        <th>Doctor Name</th>
                        <th>Status</th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($appointments) > 0): ?>
                    <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($appointment['appointment_id']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['doctor_name']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['status']); ?></td>
                        
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6">No appointments found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="footer">
        &copy; 2024 Hospital Management System. All rights reserved.
    </div>
</body>
</html>
