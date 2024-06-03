<?php
// Include database connection file
require_once '../../../config/database.php';

// Initialize an empty array to store doctor data
$doctors = [];

// Assuming you have a function to fetch doctors from the database
// You can replace this with your actual implementation
function fetchDoctors() {
    // Create a new instance of the Database class
    $database = new Database();
    $conn = $database->getConnection();

    // SQL query to fetch doctors data
    $query = "SELECT * FROM doctors";
    $stmt = $conn->query($query);

    // Check if there are any rows returned
    if ($stmt->rowCount() > 0) {
        // Fetch all rows and store them in the $doctors array
        $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $doctors;
}

// Call the fetchDoctors function to retrieve doctor data
$doctors = fetchDoctors();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Doctors</title>
    <link rel="stylesheet" href="/hospital_management/public/css/view-users.css">

</head>
<body>
    <h1>Manage Doctors</h1>
    <div class="container">
        <section class="section">
            <h2>Doctors List</h2>
            <table>
                <thead>
                    <tr>
                        <th>Doctor ID</th>
                        <th>Name</th>
                        <th>Speciality</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($doctors as $doctor): ?>
                    <tr>
                        <td><?php echo $doctor['doctor_id']; ?></td>
                        <td><?php echo $doctor['name']; ?></td>
                        <td><?php echo $doctor['specialty']; ?></td>
                        <td><?php echo $doctor['phone']; ?></td>
                        <td><?php echo $doctor['email']; ?></td>
                        <td><?php echo $doctor['address']; ?></td>
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
