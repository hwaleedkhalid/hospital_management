<?php
// Include database and user model (adjust paths if needed)
require_once '../../config/database.php';
require_once '../models/User.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Initialize User object
$user = new User($db);

// Check if a user ID is provided in the URL
$user_id = isset($_GET['id']) ? $_GET['id'] : null;

// Handle form submission (if submitted)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get user data from the form
  $user_data = [
    'id' => $_POST['id'], // Assuming a hidden field for user ID
    'username' => $_POST['username'],
    'role' => $_POST['role'], // Adjust field names based on your user model
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    // Add other user fields here (phone, etc.)
  ];

  // Update user information
  if ($user->update($user_data)) {
    // User updated successfully, redirect back to view users page
    header('Location: view_users.php');
    exit;
  } else {
    // Update failed, display error message
    $error_message = "Error updating user: " . $user->getError();
  }
}

// If user ID is provided, fetch user information for editing
if ($user_id) {
  $user_data = $user->readById($user_id);
  if (!$user_data) {
    // User not found, display error message
    $error_message = "User not found";
  }
} else {
  // No user ID provided, redirect back to view users page
  header('Location: view_users.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User</title>
  <link rel="stylesheet" href="/hospital_management/public/css/edit_user.css"> </head>
<body>
  <h1>Edit User</h1>
  <?php if (isset($error_message)): ?>
    <div class="error-message"><?php echo $error_message; ?></div>
  <?php endif; ?>

  <form action="" method="post">
    <input type="hidden" name="id" value="<?php echo $user_data['id']; ?>">  <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" value="<?php echo isset($user_data['username']) ? htmlspecialchars($user_data['username']) : ''; ?>">
    </div>

    <div class="form-group">
      <label for="role">Role:</label>
      <select name="role" id="role">
        <option value="admin">Admin</option>
        <option value="doctor">Doctor</option>
        <option value="patient">Patient</option>
        </select>
    </div>

    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" name="name" id="name" value="<?php echo isset($user_data['name']) ? htmlspecialchars($user_data['name']) : ''; ?>">
    </div>

    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" value="<?php echo isset($user_data['email']) ? htmlspecialchars($user_data['email']) : ''; ?>">
    </div>

    <div class="button-container">
      <button type="submit">Save</button>
      <a href="view_users.php">Cancel</a>
    </div>
  </form>

</body>
</html>
