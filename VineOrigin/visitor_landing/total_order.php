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
    <h1>Received Orders</h1>
    <?php
    // Calculate total sales
    $total_sales_query = "SELECT SUM(price_total) AS total_sales FROM orders WHERE status = 'R'";
    $total_sales_result = mysqli_query($conn, $total_sales_query);
    $total_sales_row = mysqli_fetch_assoc($total_sales_result);
    $total_sales = $total_sales_row['total_sales'];
    echo "<p>Total Sales: PHP " . number_format($total_sales, 2) . "</p>";
    ?>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Full Name</th>
                <th>Contact No</th>
                <th>Address</th>
                <th>City</th>
                <th>Payment Method</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch received orders from the database
            $received_orders_query = "SELECT * FROM orders WHERE status = 'R'";
            $received_orders_result = mysqli_query($conn, $received_orders_query);

            if (mysqli_num_rows($received_orders_result) > 0) {
                while ($row = mysqli_fetch_assoc($received_orders_result)) {
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
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='13'>No received orders found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
        </div>
</body>
</html>
