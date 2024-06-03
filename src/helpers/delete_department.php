<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $department_id = $_GET['id'];

    // Delete the department from the database
    $sql = "DELETE FROM departments WHERE department_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $department_id);

    if ($stmt->execute()) {
        header('Location: view_departments.php');
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>
