<?php
session_start();
include('server/connection.php');

// Check if the user is logged in and is of type 'u'
if (!isset($_SESSION["logged_in"]) || $_SESSION["user_type"] !== 'u') {
    header("location: ./login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checkout'])) {
    $user_id = $_SESSION['user_id'];
    
    // Retrieve and sanitize POST data
    $full_name = $_POST['full_name'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $payment_method = $_POST['payment_method'];
    $selected_products = $_SESSION['selected_products']; // Retrieve selected products

    // Prepare the SQL statement to insert the order into the database
    $insert_order_sql = "INSERT INTO orders (user_id, product_name, product_price, quantity, price_total, full_name, contact_no, address, city, payment_method, status, order_date)
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'p', NOW())";

    $stmt = $conn->prepare($insert_order_sql);
    foreach ($selected_products as $cart_id) { // Iterate over selected products
        // Retrieve product details from cart based on cart_id
        $cart_item_stmt = $conn->prepare("SELECT products.product_name, products.product_price, cart.quantity 
                                          FROM products 
                                          INNER JOIN cart ON products.product_id = cart.product_id 
                                          WHERE cart.cart_id = ?");
        $cart_item_stmt->bind_param("i", $cart_id);
        $cart_item_stmt->execute();
        $cart_item_result = $cart_item_stmt->get_result();
        
        if ($cart_item_result->num_rows > 0) {
            $item = $cart_item_result->fetch_assoc();
            
            // Calculate total price
            $total_price = $item['product_price'] * $item['quantity'];

            // Insert order into database
            $stmt->bind_param("isdiisssss", $user_id, $item['product_name'], $item['product_price'], $item['quantity'], $total_price, $full_name, $contact_number, $address, $city, $payment_method);
            $stmt->execute();

            // Update product stock
            $update_stock_sql = "UPDATE products p
                                 INNER JOIN cart c ON p.product_id = c.product_id
                                 SET p.product_stock = p.product_stock - c.quantity
                                 WHERE c.cart_id = ?";
            $update_stock_stmt = $conn->prepare($update_stock_sql);
            $update_stock_stmt->bind_param("i", $cart_id);
            $update_stock_stmt->execute();

            // Delete selected item from cart
            $delete_cart_sql = "DELETE FROM cart WHERE cart_id = ?";
            $delete_stmt = $conn->prepare($delete_cart_sql);
            $delete_stmt->bind_param("i", $cart_id);
            $delete_stmt->execute();
        } else {
            // Handle case where product details couldn't be retrieved
            // For simplicity, we'll just skip this iteration
            continue;
        }
    }

    // Redirect to the orders page
    header("Location: orders.php");
    exit;
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/checkout.css">
    <title>Checkout</title>
</head>
<body>
<div class="container">
    <form action="" method="post">
        <div class="row">
            <div class="col">
                <h3 class="title">Address</h3>
                <div class="inputBox">
                    <span>Full Name:</span>
                    <input type="text" name="full_name" placeholder="Full Name" required>
                </div>
                <div class="inputBox">
                    <span>Contact Number:</span>
                    <input type="text" name="contact_number" placeholder="Contact Number" pattern="^\+63\d{10}$" title="Enter a valid Philippine number (e.g., +639123456789)" required>
                </div>
                <div class="inputBox">
                    <span>Address:</span>
                    <input type="text" name="address" placeholder="Street Name, Building, House No." required>
                </div>
                <div class="inputBox">
                    <span>City:</span>
                    <input type="text" name="city" placeholder="City" required>
                </div>
                <div class="inputBox">
                    <span>Payment Method:</span>
                    <select name="payment_method">
                        <option value="Cash on Delivery">Cash on Delivery</option>
                    </select>
                </div>
            </div>
        </div>
        <input type="submit" value="Proceed to Checkout" class="submit-btn" name="checkout">
    </form>
</div>
</body>
</html>
