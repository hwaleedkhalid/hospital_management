<?php
include_once '../config/database.php';
include_once '../models/User.php';

class Auth {
    public static function check() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login.php');
            exit();
        }
    }

    public static function login($username, $password) {
        $database = new Database();
        $db = $database->getConnection();

        $user = new User($db);
        $user->username = $username;

        if ($user->usernameExists()) {
            // Verify password
            if (password_verify($password, $user->password)) {
                session_start();
                $_SESSION['user_id'] = $user->user_id;
                $_SESSION['username'] = $user->username;
                $_SESSION['role'] = $user->role;
                
                // Redirect based on user role
                switch ($user->role) {
                    case 'admin':
                        header('Location: /admin/dashboard.php');
                        break;
                    case 'doctor':
                        header('Location: /doctor/dashboard.php');
                        break;
                    case 'patient':
                        header('Location: /patient/dashboard.php');
                        break;
                    default:
                        header('Location: /login.php');
                        break;
                }
                exit();
            } else {
                // Password is incorrect
                return array("message" => "Invalid password.");
            }
        } else {
            // Username does not exist
            return array("message" => "Username does not exist.");
        }
    }

    public static function logout() {
        session_start();
        session_destroy();
        header('Location: /login.php');
        exit();
    }
}
?>
