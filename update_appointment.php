<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $appointment_id = $_POST['appointment_id'];
    $new_date = $_POST['new_date'];
    $new_mechanic_id = $_POST['new_mechanic_id'];

    // Update appointment query
    $sql = "UPDATE appointments SET appointment_date = '$new_date', mechanic_id = $new_mechanic_id WHERE id = $appointment_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to admin_panel.php after successful update
        header("Location: admin_panel.php");
        exit();
    } else {
        echo "Error updating appointment: " . $conn->error;
    }
}

$conn->close();
?>
