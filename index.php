<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Car Workshop Appointment</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
        <nav>
            <ul>
                <li><a href="index.php">Car Workshop</a></li>
                
                <li><a href="login.php">Are you an admin?</a></li>
            </ul>
        </nav>
        
    </header>
    <h1>Book an Appointment</h1>
    <form method="POST" action="appoints.php">
        <label for="client_name">Name:</label>
        <input type="text" id="client_name" name="client_name" required><br>
        
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required><br>
        
        <label for="car_color">Car Color:</label>
        <input type="text" id="car_color" name="car_color" required><br>
        
        <label for="car_license">Car License:</label>
        <input type="text" id="car_license" name="car_license" required><br>
        
        <label for="car_engine">Car Engine Number:</label>
        <input type="text" id="car_engine" name="car_engine" required><br>
        
        <label for="appointment_date">Appointment Date:</label>
        <input type="date" id="appointment_date" name="appointment_date" required><br>
        
        <label for="mechanic_id">Mechanic:</label>
        <select id="mechanic_id" name="mechanic_id" required>
            <?php
            include 'db.php';
            $sql = "SELECT * FROM mechanics";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['name']} (Available: {$row['max_clients']} cars)</option>";
            }
            $conn->close();
            ?>
        </select><br>
        
        <input type="submit" value="Book Appointment">
    </form>
</body>
</html>
