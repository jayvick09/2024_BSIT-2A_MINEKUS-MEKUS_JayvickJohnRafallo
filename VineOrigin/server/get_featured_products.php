<?php
include('connection.php');

$stmt = $conn->prepare("SELECT * FROM products WHERE category = 'featured' AND status = 'a' LIMIT 3");
$stmt->execute();
$featured_products = $stmt->get_result();
?>
