<?php
require '../config/database.php';
require '../src/helpers/Auth.php';

$url = isset($_GET['url']) ? $_GET['url'] : '';

switch ($url) {
    case '':
        include '../src/views/home.html';
        break;
    case 'admin/dashboard':
        Auth::check();
        include '../src/views/admin/dashboard.html';
        break;
    case 'doctor/dashboard':
        Auth::check();
        include '../src/views/doctor/dashboard.html';
        break;
    case 'patient/dashboard':
        Auth::check();
        include '../src/views/patient/dashboard.html';
        break;
    case 'login':
        include '../src/views/login.html';
        break;
    case 'login_action':  // Handle login form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $result = Auth::login($username, $password);
            if (isset($result['message'])) {
                header('Location: /public/index.php?url=login&error=' . urlencode($result['message']));
            }
        } else {
            header('Location: /public/index.php?url=login');
        }
        break;
    case 'logout':
        Auth::logout();
        break;
    default:
        include '../src/views/404.html';
        break;
}
?>
