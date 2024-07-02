<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $appointment_id = $_POST['appointment_id'];

    // Delete appointment query
    $sql = "DELETE FROM appointments WHERE id = $appointment_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to admin_panel.php after successful deletion
        header("Location: admin_panel.php");
        exit();
    } else {
        echo "Error deleting appointment: " . $conn->error;
    }
}

$conn->close();
?>
