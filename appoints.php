<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_name = $_POST['client_name'];
    $phone = $_POST['phone'];
    $car_color = $_POST['car_color'];
    $car_license = $_POST['car_license'];
    $car_engine = $_POST['car_engine'];
    $appointment_date = $_POST['appointment_date'];
    $mechanic_id = $_POST['mechanic_id'];

    // Check if the client already has an appointment on the same date
    $sql = "SELECT * FROM appointments WHERE car_license = '$car_license' AND appointment_date = '$appointment_date'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "You already have an appointment on this date.";
    } else {
        // Check mechanic's availability
        $sql = "SELECT COUNT(*) as count FROM appointments WHERE mechanic_id = $mechanic_id AND appointment_date = '$appointment_date'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $sql = "SELECT max_clients FROM mechanics WHERE id = $mechanic_id";
        $mechanic = $conn->query($sql)->fetch_assoc();

        if ($row['count'] >= $mechanic['max_clients']) {
            echo "Selected mechanic is fully booked on this date.";
        } else {
            // Insert appointment
            $sql = "INSERT INTO appointments (client_name, phone, car_color, car_license, car_engine, appointment_date, mechanic_id) 
                    VALUES ('$client_name', '$phone', '$car_color', '$car_license', '$car_engine', '$appointment_date', $mechanic_id)";
            if ($conn->query($sql) === TRUE) {
                echo "Appointment booked successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

$conn->close();
?>
