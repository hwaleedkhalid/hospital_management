<?php
// Include database connection file
require_once '../../../config/database.php';

// Initialize variables
$department = null;
$user_entered_id = '';

// Create a new instance of the Database class
$database = new Database();
$conn = $database->getConnection();

// Check if department ID is provided in the URL query parameter
if (isset($_GET['department_id'])) {
    $user_entered_id = $_GET['department_id'];

    // SQL query to fetch department by ID
    $query = "SELECT * FROM departments WHERE department_id = :department_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':department_id', $user_entered_id);
    $stmt->execute();

    // Fetch the department data
    $department = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Department</title>
    <link rel="stylesheet" href="/hospital_management/public/css/view_departments_by_id.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <h1 class="manage-department">Manage Department</h1>
    <div class="container">
        <section class="section">
            <h2>Search Department by ID</h2>
            <form method="GET" action="" class="search-form">
                <input type="text" name="department_id" placeholder="Enter Department ID" value="<?php echo htmlspecialchars($user_entered_id); ?>" required>
                <button type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </section>

        <section class="section">
            <h2>Department Information</h2>
            <div class="department-info">
                <?php if ($department): ?>
                    <table>
                        <tr>
                            <th>Department ID</th>
                            <td><?php echo htmlspecialchars($department['department_id']); ?></td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td><?php echo htmlspecialchars($department['name']); ?></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td><?php echo htmlspecialchars($department['description']); ?></td>
                        </tr>
                    </table>
                <?php elseif ($user_entered_id !== ''): ?>
                    <p>No department found with the provided ID.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>
    <div class="footer">
        &copy; 2024 Hospital Management System. All rights reserved.
    </div>
</body>
</html>
