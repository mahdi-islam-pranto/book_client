<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Handle mechanic addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_mechanic'])) {
    $name = $_POST['name'];
    $max_clients = $_POST['max_clients'];

    $sql = "INSERT INTO mechanics (name, max_clients) VALUES ('$name', $max_clients)";
    $conn->query($sql);
}

// Existing code for displaying appointments
$sql = "SELECT a.id, a.client_name, a.phone, a.car_license, a.appointment_date, a.mechanic_id, m.name as mechanic_name 
        FROM appointments a 
        JOIN mechanics m ON a.mechanic_id = m.id";
$appointments = $conn->query($sql);

$sql = "SELECT * FROM mechanics";
$mechanics = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
        <nav>
            <ul>
                <li><a href="index.php">Car Workshop</a></li>
                
                <li><a href="index.php">Book Appointment</a></li>
            </ul>
        </nav>
        
    </header>
    <h1>Admin Panel</h1>
    
    <!-- Form to add mechanics -->
    <h2>Add Mechanic</h2>
    <form method="POST">
        <label for="name">Mechanic Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="max_clients">Max Clients:</label>
        <input type="number" id="max_clients" name="max_clients" required>
        
        <input type="submit" name="add_mechanic" value="Add Mechanic">
    </form>
    
    <h2>Appointments</h2>
    <table>
        <tr>
            <th>Client Name</th>
            <th>Phone</th>
            <th>Car License</th>
            <th>Appointment Date</th>
            <th>Mechanic</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $appointments->fetch_assoc()): ?>
        <tr>
            <td><?= $row['client_name'] ?></td>
            <td><?= $row['phone'] ?></td>
            <td><?= $row['car_license'] ?></td>
            <td><?= $row['appointment_date'] ?></td>
            <td><?= $row['mechanic_name'] ?></td>
            <td>
    <form method="POST" action="update_appointment.php">
        <input type="hidden" name="appointment_id" value="<?= $row['id'] ?>">
        <input type="date" name="new_date" value="<?= $row['appointment_date'] ?>" required>
        <select name="new_mechanic_id" required>
            <?php foreach ($mechanics as $mechanic): ?>
                <option value="<?= $mechanic['id'] ?>" <?= $mechanic['id'] == $row['mechanic_id'] ? 'selected' : '' ?>>
                    <?= $mechanic['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" name="update" value="Update">
    </form>
    <form method="POST" class = "delete" action="delete_appointment.php" style="display:block;">
        <input type="hidden" name="appointment_id" value="<?= $row['id'] ?>">
        <input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this appointment?');">
    </form>
</td>
<!-- delete appoinment -->

<!-- <td>
    <form method="POST" action="update_appointment.php">
        <input type="hidden" name="appointment_id" value="<?= $row['id'] ?>">
        <input type="date" name="new_date" value="<?= $row['appointment_date'] ?>" required>
        <select name="new_mechanic_id" required>
            <?php foreach ($mechanics as $mechanic): ?>
                <option value="<?= $mechanic['id'] ?>" <?= $mechanic['id'] == $row['mechanic_id'] ? 'selected' : '' ?>>
                    <?= $mechanic['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" name="update" value="Update">
    </form>
    
</td> -->

        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
