<?php
// Include database connection file
require_once '../../config/database.php';

// Check if patient ID is provided via GET request
if(isset($_GET['id'])) {
    $patient_id = $_GET['id'];

    // Create a new instance of the Database class
    $database = new Database();
    $conn = $database->getConnection();

    // SQL query to fetch patient data by ID
    $query = "SELECT * FROM patients WHERE patient_id = :patient_id";
    $stmt = $conn->prepare($query);

    // Bind parameter values
    $stmt->bindParam(':patient_id', $patient_id);

    // Execute the query
    $stmt->execute();

    // Fetch the patient data
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the patient exists
    if(!$patient) {
        // Redirect to error page or handle the error accordingly
        echo "Patient not found!";
        exit;
    }
} else {
    // Redirect to error page or handle the error accordingly
    echo "Patient ID not provided!";
    exit;
}

// Check if form is submitted for updating patient record
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // SQL query to update patient record
    $query = "UPDATE patients SET name = :name, phone = :phone, gender = :gender, email = :email, address = :address WHERE patient_id = :patient_id";
    $stmt = $conn->prepare($query);

    // Bind parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':patient_id', $patient_id);

    // Execute the query
    if($stmt->execute()) {
        // Redirect to view patients page or any other page as needed
        header("location: /hospital_management/src/views/admin/view_Patients.php");
        exit;
    } else {
        // Handle the error if the query fails
        echo "Error updating patient record!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient</title>
    <link rel="stylesheet" href="/hospital_management/public/css/edit-doctor.css">
</head>
<body>
    <h1>Edit Patient</h1>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $patient_id; ?>" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $patient['name']; ?>" required>
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $patient['phone']; ?>" required>
            <label for="gender">Gender:</label>
            <input type="text" id="gender" name="gender" value="<?php echo $patient['gender']; ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $patient['email']; ?>" required>
            <label for="address">Address:</label>
            <textarea id="address" name="address" required><?php echo $patient['address']; ?></textarea>
            <button type="submit">Update Patient</button>
        </form>
    </div>
</body>
</html>
