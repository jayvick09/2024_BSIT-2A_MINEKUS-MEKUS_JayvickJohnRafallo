<?php
session_start();
include('server/connection.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Check if the user is logged in and is of type 'u'
if (!isset($_SESSION["logged_in"]) || $_SESSION["user_type"] !== 'u') {
    header("location: ./login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checkout'])) {
    $user_id = $_SESSION['user_id'];
    
    // Retrieve and sanitize POST data
    $full_name = isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name'], ENT_QUOTES) : '';
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $payment_method = isset($_POST['payment_method']) ? htmlspecialchars($_POST['payment_method'], ENT_QUOTES) : '';
    $selected_products = $_SESSION['selected_products']; // Retrieve selected products

    // Prepare the SQL statement to insert the order into the database
    $insert_order_sql = "INSERT INTO orders (user_id, product_name, product_price, quantity, price_total, full_name, contact_no, address, city, payment_method, status, order_date, gcash_reference, acc_name, acc_number, amount_paid)
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'p', NOW(), ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($insert_order_sql)) {
        foreach ($selected_products as $cart_id) { // Iterate over selected products
            // Retrieve product details from cart based on cart_id
            if ($cart_item_stmt = $conn->prepare("SELECT products.product_name, products.product_price, cart.quantity 
                                                  FROM products 
                                                  INNER JOIN cart ON products.product_id = cart.product_id 
                                                  WHERE cart.cart_id = ?")) {
                $cart_item_stmt->bind_param("i", $cart_id);
                $cart_item_stmt->execute();
                $cart_item_result = $cart_item_stmt->get_result();

                if ($cart_item_result->num_rows > 0) {
                    $item = $cart_item_result->fetch_assoc();

                    // Calculate total price
                    $total_price = $item['product_price'] * $item['quantity'];

                    // Check if payment method is GCASH
                    if ($payment_method === 'GCASH') {
                        // Retrieve and sanitize GCASH payment details
                        $gcash_reference = htmlspecialchars($_POST['gcash_reference'], ENT_QUOTES);
                        $acc_name = htmlspecialchars($_POST['acc_name'], ENT_QUOTES);
                        $acc_number = htmlspecialchars($_POST['acc_number'], ENT_QUOTES);
                        $amount_paid = htmlspecialchars($_POST['amount_paid'], ENT_QUOTES);

                        // Check if the entered amount is sufficient
                        if ($amount_paid < $total_price) {
                            // Display error message and prevent checkout
                            echo "Insufficient amount paid.";
                            exit;
                        }
                    } else {
                        // If payment method is not GCASH or GCASH fields are empty, set GCASH fields to "N/A"
                        $gcash_reference = 'N/A';
                        $acc_name = 'N/A';
                        $acc_number = 'N/A';
                        $amount_paid = 'N/A';
                    }

                    // Insert order into database
                    $stmt->bind_param("isdiiisssssssi", $user_id, $item['product_name'], $item['product_price'], $item['quantity'], $total_price, $full_name, $contact_number, $address, $city, $payment_method, $gcash_reference, $acc_name, $acc_number, $amount_paid);

                    if (!$stmt->execute()) {
                        echo "Error: " . $stmt->error;
                    }

                    // Update product stock
                    if ($update_stock_stmt = $conn->prepare("UPDATE products p
                                                             INNER JOIN cart c ON p.product_id = c.product_id
                                                             SET p.product_stock = p.product_stock - c.quantity
                                                             WHERE c.cart_id = ?")) {
                        $update_stock_stmt->bind_param("i", $cart_id);
                        $update_stock_stmt->execute();
                    }

                    // Delete selected item from cart
                    if ($delete_stmt = $conn->prepare("DELETE FROM cart WHERE cart_id = ?")) {
                        $delete_stmt->bind_param("i", $cart_id);
                        $delete_stmt->execute();
                    }
                } else {
                    // Handle case where product details couldn't be retrieved
                    // For simplicity, we'll just skip this iteration
                    continue;
                }
            }
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
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
    <script>
    function toggleGcashFields() {
        var paymentMethod = document.getElementById("payment_method").value;
        var gcashFields = document.getElementById("gcash_fields");
        var amountPaidField = document.getElementById("amount_paid");

        if (paymentMethod === 'GCASH') {
            gcashFields.style.display = "block";
            // Reset GCASH fields to empty when switching to GCASH
            document.getElementById("gcash_reference").value = "";
            document.getElementById("acc_name").value = "";
            document.getElementById("acc_number").value = "";
            amountPaidField.value = ""; // Reset amount paid field
            amountPaidField.setAttribute("type", "number"); // Change input type to number
        } else {
            gcashFields.style.display = "none";
            // Set GCASH fields to "N/A" when switching to Cash on Delivery
            document.getElementById("gcash_reference").value = "N/A";
            document.getElementById("acc_name").value = "N/A";
            document.getElementById("acc_number").value = "N/A";
            amountPaidField.value = "N/A"; // Set amount paid field to "N/A"
            amountPaidField.setAttribute("type", "text"); // Change input type to text
        }
    }
</script>

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
                    <select name="payment_method" id="payment_method" onchange="toggleGcashFields()">
                        <option value="Cash on Delivery">Cash on Delivery</option>
                        <option value="GCASH">GCASH</option>
                    </select>
                </div>
                <!-- GCASH Fields (Initially Hidden) -->
                <div id="gcash_fields" style="display: none;">
                    <div class="inputBox">
                        <span>GCASH Reference Number:</span>
                        <input type="text" name="gcash_reference" id="gcash_reference" placeholder="GCASH Reference Number" >
                    </div>
                    <div class="inputBox">
                        <span>Account Name:</span>
                        <input type="text" name="acc_name" id="acc_name" placeholder="Account Name">
                    </div>
                    <div class="inputBox">
                        <span>Account Number:</span>
                        <input type="text" name="acc_number" id="acc_number" placeholder="Account Number">
                    </div>
                    <div class="inputBox">
                        <span>Amount Paid:</span>
                        <input type="number" name="amount_paid" id="amount_paid" placeholder="Amount Paid">
                    </div>
                </div>
            </div>
        </div>
        <input type="submit" value="Proceed to Checkout" class="submit-btn" name="checkout">
    </form>
</div>
</body>
</html>

