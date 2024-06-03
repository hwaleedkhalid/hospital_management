<?php
// Include database and user model
require_once '../../../config/database.php'; // Corrected path
require_once '../../models/User.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Initialize User object
$user = new User($db);

// Fetch all users
$stmt = $user->read();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link rel="stylesheet" href="/hospital_management/public/css/view-users.css">
</head>
<body>
    <h1>Manage Users</h1>
    <div class="container">
        <section class="section">
            <h2>Users list</h2>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['phone']); ?></td>
                        <td>
                            <a href="../../helpers/edit_doctor.php?id=<?php echo $doctor['doctor_id']; ?>">Edit</a>
                            <a href="../../helpers/delete_doctor.php?id=<?php echo $doctor['doctor_id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
    <div class="footer">
        &copy; 2024 Hospital Management System. All rights reserved.
    </div>
</body>
</html>
