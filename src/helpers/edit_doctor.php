<?php
// Include database connection file
require_once '../../config/database.php';

// Check if doctor ID is provided via GET request
if(isset($_GET['id'])) {
    $doctor_id = $_GET['id'];

    // Create a new instance of the Database class
    $database = new Database();
    $conn = $database->getConnection();

    // SQL query to fetch doctor data by ID
    $query = "SELECT * FROM doctors WHERE doctor_id = :doctor_id";
    $stmt = $conn->prepare($query);

    // Bind parameter values
    $stmt->bindParam(':doctor_id', $doctor_id);

    // Execute the query
    $stmt->execute();

    // Fetch the doctor data
    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the doctor exists
    if(!$doctor) {
        // Redirect to an error page with a message
        header("Location: error.php?message=Doctor not found!");
        exit;
    }
} else {
    // Redirect to an error page with a message
    header("Location: error.php?message=Doctor ID not provided!");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor</title>
    <link rel="stylesheet" href="/hospital_management/public/css/edit-doctor.css">
</head>
<body>
    <h1>Edit Doctor</h1>
    <div class="container">
        <form action="update_doctor.php" method="POST">
            <input type="hidden" name="doctor_id" value="<?php echo htmlspecialchars($doctor['doctor_id']); ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($doctor['name']); ?>" required>
            <label for="specialty">Specialty:</label>
            <input type="text" id="specialty" name="specialty" value="<?php echo htmlspecialchars($doctor['specialty']); ?>" required>
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($doctor['phone']); ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($doctor['email']); ?>" required>
            <label for="address">Address:</label>
            <textarea id="address" name="address" required><?php echo htmlspecialchars($doctor['address']); ?></textarea>
            <button type="submit" onclick="return confirm('Are you sure you want to update this doctor?')">Update Doctor</button>
        </form>
    </div>
</body>
</html>
