<?php
// Include database connection file
require_once '../../config/database.php';

// Check if doctor ID is provided via GET request
if(isset($_GET['id'])) {
    $doctor_id = $_GET['id'];

    // Create a new instance of the Database class
    $database = new Database();
    $conn = $database->getConnection();

    // SQL query to delete doctor data by ID
    $query = "DELETE FROM doctors WHERE doctor_id = :doctor_id";
    $stmt = $conn->prepare($query);

    // Bind parameter values
    $stmt->bindParam(':doctor_id', $doctor_id);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to a success page or display a success message
        echo json_encode(array("message" => "Doctor deleted successfully."));
    } else {
        // Handle the error, redirect to an error page or display an error message
        echo json_encode(array("message" => "Unable to delete doctor."));
    }
} else {
    // Handle the case where doctor ID is not provided
    echo json_encode(array("message" => "Doctor ID not provided."));
}
?>
