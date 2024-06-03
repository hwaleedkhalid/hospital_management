<?php
// Include database connection file
require_once '../../../config/database.php';

// Fetching patients from the database
$patients = [];

// Assuming you have a function to fetch patients from the database
function fetchPatients() {
    // Create a new instance of the Database class
    $database = new Database();
    $conn = $database->getConnection();

    // SQL query to fetch patients data
    $query = "SELECT * FROM patients";
    $stmt = $conn->query($query);

    // Check if there are any rows returned
    if ($stmt->rowCount() > 0) {
        // Fetch all rows and store them in the $patients array
        $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $patients;
}

// Call the fetchPatients function to retrieve patient data
$patients = fetchPatients();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patients</title>
    <link rel="stylesheet" href="/hospital_management/public/css/view-patient.css">
</head>
<body>

<h1>Manage Patients</h1>
<div class="container">
    <section class="section">
        <h2>Patients List</h2>
        <table>
            <thead>
            <tr>
                <th>Patient ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($patients as $patient): ?>
                <tr>
                    <td><?php echo $patient['patient_id']; ?></td>
                    <td><?php echo $patient['name']; ?></td>
                    <td><?php echo $patient['phone']; ?></td>
                    <td><?php echo $patient['gender']; ?></td>
                    <td><?php echo $patient['email']; ?></td>
                    <td><?php echo $patient['address']; ?></td>
                    <td>
                        <a href="../../helpers/edit_patient.php?id=<?php echo $patient['patient_id']; ?>">Edit</a>
                        <a href="../../helpers/delete_patient.php?id=<?php echo $patient['patient_id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
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
