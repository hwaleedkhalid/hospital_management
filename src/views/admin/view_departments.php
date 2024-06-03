<?php
include '../../../config/database.php';

// Fetch departments from the database
$sql = "SELECT * FROM departments";
$result = $conn->query($sql);
$departments = $result->fetch_all(MYSQLI_ASSOC);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Departments</title>
    <link rel="stylesheet" href="/public/css/view_department.css">
</head>
<body>

    <h1>Manage Departments</h1>
    <div class="container">
        <section class="section">
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
                        <td><?php echo $department['department_id']; ?></td>
                        <td><?php echo $department['name']; ?></td>
                        <td><?php echo $department['description']; ?></td>
                        <td>
                            <a href="edit_department.php?id=<?php echo $department['department_id']; ?>">Edit</a>
                            <a href="delete_department.php?id=<?php echo $department['department_id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>

    <div class="footer">
        &copy; 2024 Hospital Management System. All rights reserved.
    </div>

</body>
</html>
