<?php
// Include database connection file
require_once '../../../config/database.php';

// Initialize variables
$patients = [];

// Create a new instance of the Database class
$database = new Database();
$conn = $database->getConnection();

// SQL query to fetch all patients
$query = "SELECT * FROM patients";
$stmt = $conn->prepare($query);
$stmt->execute();

// Fetch all patients as an associative array
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Patients</title>
    <link rel="stylesheet" href="/hospital_management/public/css/view-patient.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <h1 class="manage-patient">Manage Patients</h1>
    <div class="container">
        <section class="section">
            <h2>Patients List</h2>
            <table>
                <thead>
                    <tr>
                        <th>Patient ID</th>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Emergency Contact</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($patients as $patient): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($patient['patient_id']); ?></td>
                            <td><?php echo htmlspecialchars($patient['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($patient['name']); ?></td>
                            <td><?php echo htmlspecialchars($patient['dob']); ?></td>
                            <td><?php echo htmlspecialchars($patient['gender']); ?></td>
                            <td><?php echo htmlspecialchars($patient['address']); ?></td>
                            <td><?php echo htmlspecialchars($patient['phone']); ?></td>
                            <td><?php echo htmlspecialchars($patient['email']); ?></td>
                            <td><?php echo htmlspecialchars($patient['emergency_contact']); ?></td>
                            <td>
                                <a href="edit_patient.php?id=<?php echo htmlspecialchars($patient['patient_id']); ?>" class="action-btn edit-btn">
                                     Edit
                                </a>
                                <a href="delete_patient.php?id=<?php echo htmlspecialchars($patient['patient_id']); ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure?')">
                                     Delete
                                </a>
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
