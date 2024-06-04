<?php
// Include database connection file
require_once '../../../config/database.php';

// Initialize variables to store form data and messages
$patientID = $doctorID = $appointmentDate = $appointmentTime = $status = $notes = '';
$successMessage = $errorMessage = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $patientID = intval($_POST['patient_ID']); // Convert to integer
    $doctorID = intval($_POST['doctor_ID']); // Convert to integer
    $appointmentDate = htmlspecialchars($_POST['appointment_date']);
    $appointmentTime = htmlspecialchars($_POST['appointment_time']);
    $status = htmlspecialchars($_POST['status']);
    $notes = htmlspecialchars($_POST['notes']);

    // Create a new instance of the Database class
    $database = new Database();
    $conn = $database->getConnection();

    // SQL query to insert appointment data into the database
    $query = "INSERT INTO appointments (patient_ID, doctor_ID, appointment_date, appointment_time, status, notes) VALUES (:patient_ID, :doctor_ID, :appointment_date, :appointment_time, :status, :notes)";
    $stmt = $conn->prepare($query);

    // Bind parameters
    $stmt->bindParam(':patient_ID', $patientID, PDO::PARAM_INT);
    $stmt->bindParam(':doctor_ID', $doctorID, PDO::PARAM_INT);
    $stmt->bindParam(':appointment_date', $appointmentDate);
    $stmt->bindParam(':appointment_time', $appointmentTime);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':notes', $notes);

    // Execute the query
    if ($stmt->execute()) {
        $successMessage = "Appointment scheduled successfully!";
    } else {
        $errorMessage = "Error: Failed to schedule appointment.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Appointment</title>
    <link rel="stylesheet" href="/hospital_management/public/css/schedule_appointment.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <h1>Manage Appointments</h1>
    <div class="container">
        <section class="section">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <h2>Schedule Appointment</h2>
                <?php if (!empty($successMessage)) : ?>
                    <p class="success-message"><?php echo $successMessage; ?></p>
                <?php elseif (!empty($errorMessage)) : ?>
                    <p class="error-message"><?php echo $errorMessage; ?></p>
                <?php endif; ?>
                <label for="patient_ID">Patient ID:</label>
                <input type="number" id="patient_ID" name="patient_ID" required><br>

                <label for="doctor_ID">Doctor ID:</label>
                <input type="number" id="doctor_ID" name="doctor_ID" required><br>

                <label for="appointment_date">Appointment Date:</label>
                <input type="date" id="appointment_date" name="appointment_date" required><br>

                <label for="appointment_time">Appointment Time:</label>
                <input type="time" id="appointment_time" name="appointment_time" required><br>

                <label for="status">Status:</label>
                <input type="text" id="status" name="status" required><br>

                <label for="notes">Notes:</label>
                <textarea id="notes" name="notes" rows="4" cols="50"></textarea><br>

                <input type="submit" value="Schedule Appointment">
            </form>
        </section>
    </div>
    <div class="footer">
        &copy; 2024 Hospital Management System. All rights reserved.
    </div>
</body>
</html>
