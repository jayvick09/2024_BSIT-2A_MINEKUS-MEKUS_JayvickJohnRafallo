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

?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include('header.php'); ?>
    <link rel="stylesheet" href="assets/css/admin.css">
    <?php include('admin_navbar.php'); ?>
</head>

<body>
    <div class="boxt">
    <h1>Cancelled Orders</h1>
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
            </tr>
        </thead>
        <tbody>
        <?php
        // Fetch cancelled orders from the database
        $query = "SELECT * FROM orders WHERE status = 'c'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['order_id']}</td>";
                echo "<td>{$row['product_name']}</td>";
                echo "<td>{$row['product_price']}</td>";
                echo "<td>{$row['quantity']}</td>";
                echo "<td>{$row['price_total']}</td>";
                echo "<td>{$row['full_name']}</td>";
                echo "<td>{$row['contact_no']}</td>";
                echo "<td>{$row['address']}</td>";
                echo "<td>{$row['city']}</td>";
                echo "<td>{$row['payment_method']}</td>";
                echo "<td>{$row['order_date']}</td>";
                echo "<td>Cancelled</td>";
                echo "<td>{$row['gcash_reference']}</td>";
                echo "<td>{$row['acc_name']}</td>";
                echo "<td>{$row['acc_number']}</td>";
                echo "<td>{$row['amount_paid']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='16'>No cancelled orders found.</td></tr>";
        }
        ?>
        </tbody>
    </table>
    </div>
</body>
</html>
