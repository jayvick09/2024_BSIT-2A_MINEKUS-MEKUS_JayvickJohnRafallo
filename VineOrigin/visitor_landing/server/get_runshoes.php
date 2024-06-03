<?php
include('connection.php');

$stmt = $conn->prepare("SELECT * FROM products WHERE category = 'running_shoes' AND status = 'a' LIMIT 3");
$stmt->execute();
$runshoes_products = $stmt->get_result();
?>
