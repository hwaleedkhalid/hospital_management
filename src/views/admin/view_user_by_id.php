<?php
// Include database connection file
require_once '../../../config/database.php';

// Initialize the $user variable
$user = [];

// Check if user ID is provided in the URL
if (isset($_GET['user_id'])) {
    // Get the user ID from the URL
    $user_id = $_GET['user_id'];

    // Create a new instance of the Database class
    $database = new Database();
    $conn = $database->getConnection();

    // Prepare and execute a SQL query to fetch the user details based on the provided ID
    $query = "SELECT * FROM users WHERE user_id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    // Fetch the user details
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User By ID</title>
    <link rel="stylesheet" href="/public/css/dashboard.css">
    <link rel="stylesheet" href="/hospital_management/public/css/view-user-by-id.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <h1>View User By ID</h1>
    <div class="container">
        <section class="section">
            <h2>Search User by ID</h2>
            <form method="GET" action="" class="search-form">
                <input type="text" name="user_id" placeholder="Enter User ID" required>
                <button type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </section>

        <section class="section">
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                       
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if user details are available
                    if (!empty($user)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($user['user_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['phone']) . "</td>";
                        
                        echo "<td>" . htmlspecialchars($user['role']) . "</td>";
                        echo "</tr>";
                    } else {
                        // Display a message if the user details are not found
                        echo "<tr><td colspan='6'>User not found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>

    <div class="footer">
        &copy; 2024 Hospital Management System. All rights reserved.
    </div>
</body>
</html>
