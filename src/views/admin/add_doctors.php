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
    $user_id = $_POST['user_id'];

    // Create a new instance of the Database class
    $database = new Database();
    $conn = $database->getConnection();

    // Check if the user_id exists in the users table
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Insert the doctor record
        $query = "INSERT INTO doctors (name, specialty, phone, email, address, user_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$name, $specialty, $phone, $email, $address, $user_id]);

        // Redirect to success page or display success message
        header("Location: /hospital_management/src/views/admin/dashboard.html");
        exit();
    } else {
        // Display an error message if the user_id doesn't exist
        $error_message = "User ID does not exist.";
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
            <label for="user_id">User ID:</label>
            <input type="text" id="user_id" name="user_id" required>
            <button type="submit">Add Doctor</button>
        </form>
        <?php if (isset($error_message)) : ?>
            <p><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
