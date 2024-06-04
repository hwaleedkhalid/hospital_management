<?php
// Include database connection file
require_once '../../../config/database.php';

// Create a new instance of the Database class
$database = new Database();
$conn = $database->getConnection();

// Retrieve departments from the database
$query = "SELECT * FROM departments";
$stmt = $conn->prepare($query);
$stmt->execute();
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Departments</title>
    <link rel="stylesheet" href="/hospital_management/public/css/view_departments.css">
</head>
<body>
    <h1 class="manage-department">Manage Departments</h1>
    <div class="container">
        <div class="section">
            <h2>Departments List</h2>
            <table>
                <thead>
                    <tr>
                        <th>Department ID</th>
                        <th>Department Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($departments as $department): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($department['department_id']); ?></td>
                        <td><?php echo htmlspecialchars($department['name']); ?></td>
                        <td><?php echo htmlspecialchars($department['description']); ?></td>
                        <td>
                            <a href="edit_department.php?id=<?php echo htmlspecialchars($department['department_id']); ?>">Edit</a>
                            <a href="delete_department.php?id=<?php echo htmlspecialchars($department['department_id']); ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
