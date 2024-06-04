<?php
// Include database connection file
require_once '../../../config/database.php';

// Initialize variables
$patient = null;
$user_entered_id = '';

// Create a new instance of the Database class
$database = new Database();
$conn = $database->getConnection();

// Check if patient ID is provided in the URL query parameter
if (isset($_GET['patient_id'])) {
    $user_entered_id = $_GET['patient_id'];

    // SQL query to fetch patient by ID
    $query = "SELECT * FROM patients WHERE patient_id = :patient_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':patient_id', $user_entered_id);
    $stmt->execute();

    // Fetch the patient data
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient</title>
    <link rel="stylesheet" href="/hospital_management/public/css/view_patients_by_id.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <h1 class="manage-patient">Manage Patient</h1>
    <div class="container">
        <section class="section">
            <h2>Search Patient by ID</h2>
            <form method="GET" action="" class="search-form">
                <input type="text" name="patient_id" placeholder="Enter Patient ID" value="<?php echo htmlspecialchars($user_entered_id); ?>" required>
                <button type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </section>

        <section class="section">
            <h2>Patient Information</h2>
            <div class="patient-info">
                <?php if ($patient): ?>
                    <table>
                        <tr>
                            <th>Patient ID</th>
                            <td><?php echo htmlspecialchars($patient['patient_id']); ?></td>
                        </tr>
                        <tr>
                            <th>User ID</th>
                            <td><?php echo htmlspecialchars($patient['user_id']); ?></td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td><?php echo htmlspecialchars($patient['name']); ?></td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td><?php echo htmlspecialchars($patient['dob']); ?></td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td><?php echo htmlspecialchars($patient['gender']); ?></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><?php echo htmlspecialchars($patient['address']); ?></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td><?php echo htmlspecialchars($patient['phone']); ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo htmlspecialchars($patient['email']); ?></td>
                        </tr>
                        <tr>
                            <th>Emergency Contact</th>
                            <td><?php echo htmlspecialchars($patient['emergency_contact']); ?></td>
                        </tr>
                    </table>
                <?php elseif ($user_entered_id !== ''): ?>
                    <p>No patient found with the provided ID.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>
    <div class="footer">
        &copy; 2024 Hospital Management System. All rights reserved.
    </div>
</body>
</html>
