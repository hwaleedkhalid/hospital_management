<?php
// Include database configuration file
require_once('../../../config/database.php');

// Establish a database connection
$database = new Database();
$conn = $database->getConnection();

// Check if user ID is provided in the URL query string
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';

// Initialize an empty array to store users
$users = [];

// Fetch users based on the provided user ID or fetch all users if no user ID is provided
if ($user_id) {
    // Prepare and execute a statement to select a user by ID
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bindParam(1, $user_id);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Fetch all users
    $stmt = $conn->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search By ID</title>
    <link rel="stylesheet" href="/public/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e0f7fa;
            color: #333;
        }

        h1 {
            text-align: center;
            padding: 20px;
            color: #fff;
            background-color: #0288d1;
            margin: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .section {
            width: 100%;
            margin-bottom: 10px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .section h2 {
            margin-top: 0;
            color: #00796b;
            border-bottom: 2px solid #0288d1;
            padding-bottom: 10px;
            text-align: left;
        }

        .search-form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-form input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px 0 0 4px;
            outline: none;
        }

        .search-form button {
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #0288d1;
            color: white;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }

        .search-form button:hover {
            background-color: #0277bd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            color: #333;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background-color: #0288d1;
            color: white;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <h1>Manage Users</h1>
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
                        <th>Role</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['phone']); ?></td>
                        
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
