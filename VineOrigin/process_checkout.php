<?php
session_start();
include('server/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $payment_method = $_POST['payment_method'];

    $user_id = $_SESSION["user_id"];

    $sql = "INSERT INTO orders (user_id, full_name, contact_no, address, city, payment_method) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $user_id, $full_name, $contact_number, $address, $city, $payment_method);

    if ($stmt->execute()) {
        header("location: orders.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
