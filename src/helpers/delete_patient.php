<?php
// Include database connection file
require_once '../../config/database.php';

// Check if patient ID is provided via GET request
if(isset($_GET['id'])) {
    $patient_id = $_GET['id'];

    // Create a new instance of the Database class
    $database = new Database();
    $conn = $database->getConnection();

    // SQL query to delete patient data by ID
    $query = "DELETE FROM patients WHERE patient_id = :patient_id";
    $stmt = $conn->prepare($query);

    // Bind parameter values
    $stmt->bindParam(':patient_id', $patient_id);

    // Execute the query
    if($stmt->execute()) {
        // Redirect to view patients page or any other page as needed
        header("location: /hospital_management/src/views/admin/view_Patients.php");
        exit;
    } else {
        // Handle the error if the query fails
        echo "Error deleting patient record!";
    }
} else {
    // Redirect to error page or handle the error accordingly
    echo "Patient ID not provided!";
    exit;
}
?>
