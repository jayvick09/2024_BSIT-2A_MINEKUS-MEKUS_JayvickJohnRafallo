<?php
session_start();
include('server/connection.php');

// Check if user is not logged in or not an admin, then redirect to login page
if (!isset($_SESSION["logged_in"]) || $_SESSION["user_type"] !== 'a') {
    header("location: ./login.php");
    exit;
}

// Logout logic
if(isset($_POST['logout'])) {
    session_destroy(); // Destroy the session
    header("location: ./index.php"); // Redirect to login page
    exit;
}

// Accept or Decline Order Logic
if(isset($_POST['action']) && isset($_POST['order_id'])) {
    $action = $_POST['action'];
    $order_id = $_POST['order_id'];
    
    if($action === 'accept') {
        // Update order status to 't' for accepted
        $update_query = "UPDATE orders SET status = 't' WHERE order_id = '$order_id'";
    } elseif($action === 'decline') {
        // Update order status to 'c' for declined
        $update_query = "UPDATE orders SET status = 'c' WHERE order_id = '$order_id'";
    }
    
    if(mysqli_query($conn, $update_query)) {
        // Success message or redirect to the same page
        header("location: ".$_SERVER['PHP_SELF']);
        exit;
    } else {
        // Error message
        echo "Error updating order status: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php'); ?>
    <link rel="stylesheet" href="assets/css/admin.css">
    <?php include('admin_navbar.php'); ?>
    <style>
        /* Add your custom CSS styles here */
    </style>
</head>

<body>
    <div class="boxt">
        <h1>Pending Orders</h1>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Full Name</th>
                    <th>Contact No.</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Payment Method</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>GCash Reference</th>
                    <th>Account Name</th>
                    <th>Account Number</th>
                    <th>Amount Paid</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch pending and to receive orders from the database
                $query = "SELECT * FROM orders WHERE status IN ('p', 't')";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['order_id']}</td>";
                        echo "<td>{$row['product_name']}</td>";
                        echo "<td>{$row['product_price']}</td>";
                        echo "<td>{$row['quantity']}</td>";
                        echo "<td>{$row['price_total']}</td>";
                        echo "<td>{$row['full_name']}</td>"; // Debugging statement
                        echo "<td>{$row['contact_no']}</td>";
                        echo "<td>{$row['address']}</td>";
                        echo "<td>{$row['city']}</td>";
                        echo "<td>{$row['payment_method']}</td>";
                        echo "<td>{$row['order_date']}</td>";
                        // Check if status is 'p' and replace with 'Pending', or 't' and replace with 'To Receive'
                        if ($row['status'] === 'p') {
                            echo "<td>Pending</td>";
                        } elseif ($row['status'] === 't') {
                            echo "<td>To Receive</td>";
                        } else {
                            echo "<td>{$row['status']}</td>";
                        }
                        echo "<td>{$row['gcash_reference']}</td>";
                        echo "<td>{$row['acc_name']}</td>";
                        echo "<td>{$row['acc_number']}</td>";
                        echo "<td>{$row['amount_paid']}</td>";
                        echo "<td>";
                        if ($row['status'] === 'p') {
                            echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>";
                            echo "<input type='hidden' name='order_id' value='".$row['order_id']."'>";
                            // Accept button
                            echo "<button type='submit' name='action' value='accept' class='action-button' id='accept-button'>Accept</button>";
                            // Decline button
                            echo "<button type='submit' name='action' value='decline' class='action-button' id='decline-button'>Decline</button>";
                            echo "</form>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='16'>No pending or to receive orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
