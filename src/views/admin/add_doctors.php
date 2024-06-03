<?php
// Include database connection file
require_once '../../../config/database.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $specialty = $_POST['specialty'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Create a new instance of the Database class
    $database = new Database();
    $conn = $database->getConnection();

    // SQL query to insert new doctor data into the database
    $query = "INSERT INTO doctors (name, specialty, phone, email, address) VALUES (:name, :specialty, :phone, :email, :address)";
    $stmt = $conn->prepare($query);

    // Bind parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':specialty', $specialty);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':address', $address);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to a success page or display a success message
        echo "Doctor added successfully.";
    } else {
        // Handle the error, redirect to an error page or display an error message
        echo "Unable to add doctor.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor</title>
    <link rel="stylesheet" href="/hospital_management/public/css/add-doctor.css">
</head>
<body>
    <h1>Add Doctor</h1>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="specialty">Specialty:</label>
            <input type="text" id="specialty" name="specialty" required>
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="address">Address:</label>
            <textarea id="address" name="address" required></textarea>
            <button type="submit">Add Doctor</button>
        </form>
    </div>
</body>
</html>
