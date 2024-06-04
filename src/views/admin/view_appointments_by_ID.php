<?php
// Include database connection file
require_once '../../../config/database.php';

// Initialize variables
$appointmentID = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['appointment_id'])) {
    // Sanitize appointment ID input
    $appointmentID = intval($_GET['appointment_id']); // Convert to integer for security

    // Create a new instance of the Database class
    $database = new Database();
    $conn = $database->getConnection();

    // SQL query to fetch appointment by appointment ID with patient and doctor names
    $query = "
        SELECT 
            a.appointment_id, 
            a.appointment_date, 
            a.appointment_time, 
            a.patient_id, 
            p.name AS patient_name, 
            d.name AS doctor_name, 
            a.status
        FROM 
            appointments a
        INNER JOIN 
            patients p ON a.patient_id = p.patient_id
        INNER JOIN 
            doctors d ON a.doctor_id = d.doctor_id
        WHERE 
            a.appointment_id = :appointmentID
    ";

    // Prepare the SQL query
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':appointmentID', $appointmentID, PDO::PARAM_INT);
    
    // Execute the query
    $stmt->execute();
    
    // Fetch the appointment as associative array
    $appointment = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Appointment</title>
    <link rel="stylesheet" href="/hospital_management/public/css/view_appointments_by_ID.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <h1>Search Appointment by ID</h1>
    <div class="container">
        <section class="section">
            <h2>Appointment Details</h2>
            <form method="GET" action="" class="search-form">
                <input type="number" name="appointment_id" placeholder="Enter Appointment ID" required>
                <button type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </section>

        <div class="section">
            <?php if (isset($appointment) && !empty($appointment)) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Appointment ID</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Patient ID</th>
                            <th>Patient Name</th>
                            <th>Doctor Name</th>
                            <th>Status</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $appointment['appointment_id']; ?></td>
                            <td><?php echo $appointment['appointment_date']; ?></td>
                            <td><?php echo $appointment['appointment_time']; ?></td>
                            <td><?php echo $appointment['patient_id']; ?></td>
                            <td><?php echo $appointment['patient_name']; ?></td>
                            <td><?php echo $appointment['doctor_name']; ?></td>
                            <td><?php echo $appointment['status']; ?></td>
                           
                        </tr>
                    </tbody>
                </table>
            <?php elseif (isset($_GET['appointment_id'])) : ?>
                <p>No appointment found for Appointment ID <?php echo $_GET['appointment_id']; ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="footer">
        &copy; 2024 Hospital Management System. All rights reserved.
    </div>
</body>
</html>
