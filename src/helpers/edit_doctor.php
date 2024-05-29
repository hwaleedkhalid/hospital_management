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
    $name = htmlspecialchars(strip_tags($_POST['name']));
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $phone = htmlspecialchars(strip_tags($_POST['phone']));
    $specialization = htmlspecialchars(strip_tags($_POST['specialization']));
    $department_id = htmlspecialchars(strip_tags($_POST['department_id']));

    // Create database connection
    $database = new Database();
    $db = $database->getConnection();

    // Create an instance of the Doctor class
    $doctor = new Doctor($db);

    // Update the doctor
    if ($doctor->updateDoctor($id, $name, $email, $phone, $specialization, $department_id)) {
        header('Location: /hospital_management/public/index.php?url=admin/doctors');
        exit();
    } else {
        echo "Unable to update doctor.";
    }
} else {
    echo "Invalid request.";
}
?>
