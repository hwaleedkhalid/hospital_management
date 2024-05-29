<?php
// Define the root directory
define('ROOT_PATH', dirname(dirname(__DIR__)));

// Include the necessary files
include_once ROOT_PATH . '/config/database.php';
include_once ROOT_PATH . '/src/models/Doctor.php';
include_once ROOT_PATH . '/src/helpers/Auth.php';

// Check if the user is authenticated and is an admin
Auth::startSession();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /hospital_management/public/index.php?url=login');
    exit();
}

// Check if the required POST data is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = htmlspecialchars(strip_tags($_POST['id']));

    // Create database connection
    $database = new Database();
    $db = $database->getConnection();

    // Create an instance of the Doctor class
    $doctor = new Doctor($db);

    // Delete the doctor
    if ($doctor->deleteDoctor($id)) {
        echo json_encode(["message" => "Doctor was deleted."]);
    } else {
        echo json_encode(["message" => "Unable to delete doctor."]);
    }
} else {
    echo json_encode(["message" => "Invalid request."]);
}
?>
