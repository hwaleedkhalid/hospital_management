<?php
// Include database connection file
require_once '../../../config/database.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Create a new instance of the Database class
    $database = new Database();
    $conn = $database->getConnection();

    // Insert the department record
    $query = "INSERT INTO departments (name, description) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    if ($stmt->execute([$name, $description])) {
        // Redirect to success page or display success message
        header("Location: /hospital_management/src/views/admin/dashboard.html");
        exit();
    } else {
        // Display an error message if the insertion fails
        $error_message = "Failed to add department.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Department</title>
    <link rel="stylesheet" href="/hospital_management/public/css/add_department.css">
</head>
<body>
    <h1 class="manage-department">Manage Department</h1>
    <div class="container">
        <div class="section">
            <h2>Add Department</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-container">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <button type="submit">Add Department</button>
            </form>
            <?php if (isset($error_message)) : ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
