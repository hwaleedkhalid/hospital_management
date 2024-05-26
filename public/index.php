<?php
require '../config/database.php';
require '../src/models/User.php';

$url = isset($_GET['url']) ? $_GET['url'] : '';

switch ($url) {
    case '':
        include '../src/views/home.html';
        break;
    case 'admin/dashboard':
        Auth::check();
        include '../src/views/admin/dashboard.php';
        break;
    case 'doctor/dashboard':
        Auth::check();
        include '../src/views/doctor/dashboard.php';
        break;
    case 'patient/dashboard':
        Auth::check();
        include '../src/views/patient/dashboard.php';
        break;
    case 'login':
        include '../src/views/login.php';
        break;
    case 'logout':
        Auth::logout();
        break;
    default:
        include '../src/views/404.php';
        break;
}
?>
