<?php
session_start();
include('server/connection.php');

// Check if user is logged in
    // Redirect to login page if user is not logged in
if (!isset($_SESSION["logged_in"])) {
    header("location: ./login.php");
    exit;
}

// Check if product ID and quantity are provided
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    // Sanitize input data
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

    // Check if product exists
    $sql_check_product = "SELECT * FROM products WHERE product_id = '$product_id'";
    $result_check_product = $conn->query($sql_check_product);

    if ($result_check_product->num_rows > 0) {
        // Product exists, proceed to add to cart

        // Retrieve user ID from session
        $user_id = $_SESSION["user_id"];

        // Check if the product is already in the cart for the user
        $sql_check_cart_item = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
        $result_check_cart_item = $conn->query($sql_check_cart_item);

        if ($result_check_cart_item->num_rows > 0) {
            // Product already exists in the cart, update quantity
            $row = $result_check_cart_item->fetch_assoc();
            $new_quantity = $row['quantity'] + $quantity;
            $sql_update_cart_item = "UPDATE cart SET quantity = '$new_quantity' WHERE user_id = '$user_id' AND product_id = '$product_id'";
            $conn->query($sql_update_cart_item);
        } else {
            // Product does not exist in the cart, insert new record
            $sql_insert_cart_item = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')";
            $conn->query($sql_insert_cart_item);
        }

        // Redirect back to shop page or cart page
        header("location: ./shop.php");
        exit;
    } else {
        // Product does not exist, redirect back to shop page with error message
        header("location: ./shop.php?error=product_not_found");
        exit;
    }
} else {
    // Product ID or quantity not provided, redirect back to shop page with error message
    header("location: ./shop.php?error=missing_data");
    exit;
}

// Close connection
$conn->close();
?>
