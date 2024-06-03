<?php
include('connection.php');

$stmt = $conn->prepare("SELECT * FROM products WHERE category = 'cashoes' AND status = 'a' LIMIT 3");
$stmt->execute();
$cashoes_products = $stmt->get_result();
?>
