<?php
// Include database connection file
require_once '../../../config/database.php';

// Initialize the $doctor variable
$doctor = [];

// Check if doctor ID is provided in the URL
if (isset($_GET['doctor_id'])) {
    // Get the doctor ID from the URL
    $doctor_id = $_GET['doctor_id'];

    // Create a new instance of the Database class
    $database = new Database();
    $conn = $database->getConnection();

    // Prepare and execute a SQL query to fetch the doctor details based on the provided ID
    $query = "SELECT * FROM doctors WHERE doctor_id = :doctor_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':doctor_id', $doctor_id);
    $stmt->execute();

    // Fetch the doctor details
    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Doctor By ID</title>
    <link rel="stylesheet" href="/public/css/dashboard.css">
    <link rel="stylesheet" href="/hospital_management/public/css/view-doctor-by-id.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <h1>View Doctor By ID</h1>
    <div class="container">
        <section class="section">
            <h2>Search Doctor by ID</h2>
            <form method="GET" action="" class="search-form">
                <input type="text" name="doctor_id" placeholder="Enter Doctor ID" required>
                <button type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </section>

        <section class="section">
            <table>
                <thead>
                    <tr>
                        <th>Doctor ID</th>
                        <th>Name</th>
                        <th>Specialty</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if doctor details are available
                    if (!empty($doctor)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($doctor['doctor_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($doctor['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($doctor['specialty']) . "</td>";
                        echo "<td>" . htmlspecialchars($doctor['phone']) . "</td>";
                        echo "<td>" . htmlspecialchars($doctor['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($doctor['address']) . "</td>";
                       
                        echo "</tr>";
                    } else {
                        // Display a message if the doctor details are not found
                        echo "<tr><td colspan='7'>Doctor not found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>

    <div class="footer">
        &copy; 2024 Hospital Management System. All rights reserved.
    </div>
</body>
</html>
