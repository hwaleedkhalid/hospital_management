<?php
// Define the root directory
define('ROOT_PATH', dirname(dirname(__DIR__)));

// Include the necessary files
include_once ROOT_PATH . '/config/database.php';
include_once ROOT_PATH . '/src/models/User.php';

class Auth {
    public static function startSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function check() {
        self::startSession();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /hospital_management/public/index.php?url=login');
            exit();
        }
    }

    public static function login($username, $password) {
        self::startSession();
        
        $database = new Database();
        $db = $database->getConnection();
    
        $user = new User($db);
        $user->username = $username;
    
        if ($user->usernameExists()) {
            // Verify password
            if (password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->user_id;
                $_SESSION['username'] = $user->username;
                $_SESSION['role'] = $user->role;
    
                // Redirect based on user role
                switch ($user->role) {
                    case 'admin':
                        header('Location: /hospital_management/public/index.php?url=admin/dashboard');
                        break;
                    case 'doctor':
                        header('Location: /hospital_management/public/index.php?url=doctor/dashboard');
                        break;
                    case 'patient':
                        header('Location: /hospital_management/public/index.php?url=patient/dashboard');
                        break;
                    default:
                        header('Location: /hospital_management/public/index.php?url=login&error=' . urlencode('Invalid role.'));
                        break;
                }
                exit();
            } else {
                // Password is incorrect
                header('Location: /hospital_management/public/index.php?url=login&error=' . urlencode('Invalid password.'));
            }
        } else {
            // Username does not exist
            header('Location: /hospital_management/public/index.php?url=login&error=' . urlencode('Username does not exist.'));
        }
        exit();
    }
    
    public static function logout() {
        self::startSession();
        session_destroy();
        header('Location: /hospital_management/public/index.php?url=login');
        exit();
    }
}
?>
