<?php
// Include database connection file
require_once '../../../config/database.php';

// Initialize variables
$appointments = [];

// Create a new instance of the Database class
$database = new Database();
$conn = $database->getConnection();

// SQL query to fetch appointments with patient and doctor names
$query = "
    SELECT 
        a.appointment_ID,
        p.name AS patient_name,
        d.name AS doctor_name,
        a.appointment_date,
        a.appointment_time,
        a.status,
        a.notes
    FROM 
        appointments a
        LEFT JOIN patients p ON a.patient_ID = p.patient_id
        LEFT JOIN doctors d ON a.doctor_ID = d.doctor_id
    ORDER BY 
        a.appointment_date DESC,
        a.appointment_time DESC
";
$stmt = $conn->prepare($query);
$stmt->execute();

// Fetch all appointments as an associative array
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    <link rel="stylesheet" href="/hospital_management/public/css/view_appointments.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <h1>Manage Appointments</h1>
    <div class="container">
        <section class="section">
            <h2>Appointments List</h2>
            <table>
                <thead>
                    <tr>
                        <th>Appointment ID</th>
                        <th>Patient Name</th>
                        <th>Doctor Name</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Status</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($appointment['appointment_ID']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['doctor_name']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['status']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['notes']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
    <div class="footer">
        &copy; 2024 Hospital Management System. All rights reserved.
    </div>
</body>
</html>
