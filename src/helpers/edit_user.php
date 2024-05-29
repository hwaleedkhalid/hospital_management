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

// Check if the required POST data is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = htmlspecialchars(strip_tags($_POST['user_id']));
    $username = htmlspecialchars(strip_tags($_POST['username']));
    $password = htmlspecialchars(strip_tags($_POST['password']));
    $role = htmlspecialchars(strip_tags($_POST['role']));
    $name = htmlspecialchars(strip_tags($_POST['name']));
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $phone = htmlspecialchars(strip_tags($_POST['phone']));

    // Create database connection
    $database = new Database();
    $db = $database->getConnection();

    // Create an instance of the User class
    $user = new User($db);
    $user->user_id = $user_id;
    $user->username = $username;
    $user->password = $password;
    $user->role = $role;
    $user->name = $name;
    $user->email = $email;
    $user->phone = $phone;

    // Update the user
    if ($user->update()) {
        echo json_encode(["message" => "User was updated."]);
    } else {
        echo json_encode(["message" => "Unable to update user."]);
    }
} else {
    echo json_encode(["message" => "Invalid request."]);
}
?>
