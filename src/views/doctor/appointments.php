<?php
Auth::check();  // Ensure the user is authenticated
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Appointments</title>
</head>
<body>
    <h1>Your Appointments</h1>
    <table>
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Patient Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
            <tr>
                <td><?php echo $appointment['id']; ?></td>
                <td><?php echo $appointment['patient_name']; ?></td>
                <td><?php echo $appointment['date']; ?></td>
                <td><?php echo $appointment['time']; ?></td>
                <td><?php echo $appointment['status']; ?></td>
                <td>
                    <a href="?url=doctor/view_appointment&id=<?php echo $appointment['id']; ?>">View</a>
                    <a href="?url=doctor/update_appointment&id=<?php echo $appointment['id']; ?>">Update</a>
                    <a href="?url=doctor/cancel_appointment&id=<?php echo $appointment['id']; ?>">Cancel</a>
                    <a href="?url=doctor/view_patient_history&id=<?php echo $appointment['patient_id']; ?>">View Patient History</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="?url=doctor/dashboard">Back to Dashboard</a>
</body>
</html>
