<?php
include('connection.php');

$stmt = $conn->prepare("SELECT * FROM products WHERE category = 'bbshoes' AND status = 'a' LIMIT 3");
$stmt->execute();
$bbshoes_products = $stmt->get_result();
?>
