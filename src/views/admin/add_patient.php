<?php
// Include database connection file
require_once '../../../config/database.php';

// Initialize variables to hold form input values and error messages
$user_id = $name = $dob = $gender = $phone = $email = $address = $emergency_contact = "";
$user_id_err = $name_err = $dob_err = $gender_err = $phone_err = $email_err = $address_err = $emergency_contact_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate user_id
    if (empty(trim($_POST["user_id"]))) {
        $user_id_err = "Please enter a user ID.";
    } else {
        $user_id = trim($_POST["user_id"]);
    }

    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate dob
    if (empty(trim($_POST["dob"]))) {
        $dob_err = "Please enter a date of birth.";
    } else {
        $dob = trim($_POST["dob"]);
    }

    // Validate gender
    if (empty(trim($_POST["gender"]))) {
        $gender_err = "Please enter a gender.";
    } else {
        $gender = trim($_POST["gender"]);
    }

    // Validate phone
    if (empty(trim($_POST["phone"]))) {
        $phone_err = "Please enter a phone number.";
    } else {
        $phone = trim($_POST["phone"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email address.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate address
    if (empty(trim($_POST["address"]))) {
        $address_err = "Please enter an address.";
    } else {
        $address = trim($_POST["address"]);
    }

    // Validate emergency contact
    if (empty(trim($_POST["emergency_contact"]))) {
        $emergency_contact_err = "Please enter an emergency contact.";
    } else {
        $emergency_contact = trim($_POST["emergency_contact"]);
    }

    // Check input errors before inserting in database
    if (empty($user_id_err) && empty($name_err) && empty($dob_err) && empty($gender_err) && empty($phone_err) && empty($email_err) && empty($address_err) && empty($emergency_contact_err)) {
        // Create a new instance of the Database class
        $database = new Database();
        $conn = $database->getConnection();

        // SQL query to insert new patient data
        $query = "INSERT INTO patients (user_id, name, dob, gender, phone, email, address, emergency_contact) VALUES (:user_id, :name, :dob, :gender, :phone, :email, :address, :emergency_contact)";
        $stmt = $conn->prepare($query);

        // Bind parameter values
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':emergency_contact', $emergency_contact);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to view patients page or any other page as needed
            header("location: view_patients.php");
            exit;
        } else {
            // Handle the error if the query fails
            echo "Something went wrong. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient</title>
    <link rel="stylesheet" href="/hospital_management/public/css/add-doctor.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <h1>Manage Patient</h1>
    <div class="container">
        <section class="section">
            <h2>Add New Patient</h2>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="add-form">
                <label for="user_id">User ID:</label>
                <input type="text" id="user_id" name="user_id" value="<?php echo $user_id; ?>" required>
                <span class="error"><?php echo $user_id_err; ?></span>

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
                <span class="error"><?php echo $name_err; ?></span>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo $dob; ?>" required>
                <span class="error"><?php echo $dob_err; ?></span>

                <label for="gender">Gender:</label>
                <input type="text" id="gender" name="gender" value="<?php echo $gender; ?>" required>
                <span class="error"><?php echo $gender_err; ?></span>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" required>
                <span class="error"><?php echo $phone_err; ?></span>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                <span class="error"><?php echo $email_err; ?></span>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo $address; ?>" required>
                <span class="error"><?php echo $address_err; ?></span>

                <label for="emergency_contact">Emergency Contact:</label>
                <input type="text" id="emergency_contact" name="emergency_contact" value="<?php echo $emergency_contact; ?>" required>
                <span class="error"><?php echo $emergency_contact_err; ?></span>

                <button type="submit" name="add_patient">Add Patient</button>
            </form>
        </section>
    </div>
    <div class="footer">
        &copy; 2024 Hospital Management System. All rights reserved.
    </div>
</body>
</html>
