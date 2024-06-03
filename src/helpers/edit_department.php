<?php
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $department_id = $_POST['department_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Update the department in the database
    $sql = "UPDATE departments SET name = ?, description = ? WHERE department_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $description, $department_id);

    if ($stmt->execute()) {
        header('Location: view_departments.php');
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    // Fetch the department data for the given ID
    $department_id = $_GET['id'];
    $sql = "SELECT * FROM departments WHERE department_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $department_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $department = $result->fetch_assoc();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Department</title>
    <link rel="stylesheet" href="/public/css/dashboard.css">
</head>
<body>

    <h1>Edit Department</h1>
    <div class="container">
        <section class="section">
            <form method="post" action="edit_department.php">
                <input type="hidden" name="department_id" value="<?php echo $department['department_id']; ?>">
                <div>
                    <label for="name">Department Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $department['name']; ?>" required>
                </div>
                <div>
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required><?php echo $department['description']; ?></textarea>
                </div>
                <div>
                    <button type="submit">Update Department</button>
                </div>
            </form>
        </section>
    </div>

</body>
</html>
