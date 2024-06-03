<?php
// Include database connection file
require_once '../../../config/database.php';

// Initialize the $patient variable
$patient = null;

// Check if the patient ID is provided in the URL
if (isset($_GET['patient_id'])) {
    // Retrieve the patient ID from the URL
    $patient_id = $_GET['patient_id'];

    // Create a new instance of the Database class
    $database = new Database();
    $conn = $database->getConnection();

    // SQL query to fetch the patient data by ID
    $query = "SELECT * FROM patients WHERE patient_id = :patient_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':patient_id', $patient_id);
    $stmt->execute();

    // Fetch the patient data
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Initialize a variable to hold the patient ID entered by the user
$user_entered_id = isset($_GET['patient_id']) ? $_GET['patient_id'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="/hospital_management/public/css/patient-by-id.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <h1>View Patient</h1>
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
                    <p><strong>Patient ID:</strong> <?php echo $patient['patient_id']; ?></p>
                    <p><strong>User ID:</strong> <?php echo $patient['user_id']; ?></p>
                    <p><strong>Name:</strong> <?php echo $patient['name']; ?></p>
                    <p><strong>Date of Birth:</strong> <?php echo $patient['dob']; ?></p>
                    <p><strong>Gender:</strong> <?php echo $patient['gender']; ?></p>
                    <p><strong>Address:</strong> <?php echo $patient['address']; ?></p>
                    <p><strong>Phone:</strong> <?php echo $patient['phone']; ?></p>
                    <p><strong>Email:</strong> <?php echo $patient['email']; ?></p>
                    <p><strong>Emergency Contact:</strong> <?php echo $patient['emergency_contact']; ?></p>
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
