<?php
// Include database connection file
require_once '../../config/database.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if doctor ID is provided
    if (isset($_POST['doctor_id'])) {
        $doctor_id = $_POST['doctor_id'];

        // Create a new instance of the Database class
        $database = new Database();
        $conn = $database->getConnection();

        // Update doctor information in the database
        $query = "UPDATE doctors SET name = :name, specialty = :specialty, phone = :phone, email = :email, address = :address WHERE doctor_id = :doctor_id";
        $stmt = $conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->bindParam(':name', $_POST['name']);
        $stmt->bindParam(':specialty', $_POST['specialty']);
        $stmt->bindParam(':phone', $_POST['phone']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':address', $_POST['address']);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to a success page or display a success message
            header("Location: /hospital_management/src/views/admin/view_Doctors.php");
            exit;
        } else {
            // Handle the error, redirect to an error page or display an error message
            header("Location: error.php");
            exit;
        }
    } else {
        // Handle the case where doctor ID is not provided
        header("Location: error.php");
        exit;
    }
} else {
    // Handle the case where the form is not submitted
    header("Location: error.php");
    exit;
}
?>
