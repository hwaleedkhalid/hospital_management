<?php
// Define the root directory
define('ROOT_PATH', dirname(dirname(__DIR__)));

// Include the necessary files
include_once ROOT_PATH . '/config/database.php';
include_once ROOT_PATH . '/src/models/User.php';
include_once ROOT_PATH . '/src/helpers/Auth.php';

// Check if the user is authenticated and is an admin
Auth::startSession();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /hospital_management/public/index.php?url=login');
    exit();
}

// Check if the user_id is set in the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = htmlspecialchars(strip_tags($_POST['user_id']));

    // Create database connection
    $database = new Database();
    $db = $database->getConnection();

    // Create an instance of the User class
    $user = new User($db);
    $user->user_id = $user_id;

    // Delete the user
    if ($user->delete()) {
        echo json_encode(["message" => "User was deleted."]);
    } else {
        echo json_encode(["message" => "Unable to delete user."]);
    }
} else {
    echo json_encode(["message" => "Invalid request."]);
}
?>
