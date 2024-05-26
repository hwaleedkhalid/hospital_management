<?php
Auth::check();  // Ensure the user is authenticated
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Appointment</title>
</head>
<body>
    <h1>Cancel Appointment</h1>
    <p><?php echo $message; ?></p>
    <a href="?url=doctor/appointments">Back to Appointments</a>
</body>
</html>
