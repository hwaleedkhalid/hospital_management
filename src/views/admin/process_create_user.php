<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection and user model
    require_once '../../../config/database.php';
    require_once '../../models/User.php';

    // Get form data and sanitize inputs
    $userID = htmlspecialchars(strip_tags($_POST['userID']));
    $username = htmlspecialchars(strip_tags($_POST['username']));
    $password = htmlspecialchars(strip_tags($_POST['password']));
    $role = htmlspecialchars(strip_tags($_POST['role']));
    $name = htmlspecialchars(strip_tags($_POST['name']));
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $phone = htmlspecialchars(strip_tags($_POST['phone']));

    // Create database connection
    $database = new Database();
    $db = $database->getConnection();

    // Create new User instance
    $user = new User($db);

    // Set user properties
    $user->user_id = $userID;
    $user->username = $username;
    $user->password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
    $user->role = $role;
    $user->name = $name;
    $user->email = $email;
    $user->phone = $phone;

    // Create the user
    if ($user->create()) {
        // User created successfully
        header("Location: view_users.php"); // Redirect to view users page
        exit();
    } else {
        // Failed to create user
        echo json_encode(["message" => "Unable to create user."]);
    }
} else {
    // Invalid request method
    echo json_encode(["message" => "Invalid request method."]);
}
?>
