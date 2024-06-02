<?php
session_start();
include('server/connection.php');

// Check if user is logged in
if (!isset($_SESSION["logged_in"]) || $_SESSION["user_type"] !== 'u') {
    header("location: ./login.php");
    exit;
}

// Fetch user ID
$user_id = $_SESSION["user_id"];

// Fetch orders for the user
$sql = "SELECT * FROM orders WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include('header.php'); ?>
<?php include('navbar.php'); ?>

<link rel="stylesheet" href="assets/css/orders.css">
<title>Order History</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Order History</h1>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Full Name</th>
                    <th>Contact Number</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Payment Method</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Calculate total price
                        $total_price = $row['quantity'] * $row['product_price'];

                        // Determine status label
                        $status_label = '';
                        switch ($row['status']) {
                            case 'r':
                                $status_label = 'Received';
                                break;
                            case 'p':
                                $status_label = 'Pending';
                                break;
                            case 't':
                                $status_label = 'To Receive';
                                break;
                            case 'c':
                                $status_label = 'Cancelled';
                                break;
                            default:
                                $status_label = 'Unknown';
                        }

                        echo "<tr>";
                        echo "<td>" . $row['order_id'] . "</td>";
                        echo "<td>" . $row['product_name'] . "</td>";
                        echo "<td>Php " . $row['product_price'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>Php " . $total_price . "</td>";
                        echo "<td>" . $row['full_name'] . "</td>";
                        echo "<td>" . $row['contact_no'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['city'] . "</td>";
                        echo "<td>" . $row['payment_method'] . "</td>";
                        echo "<td>" . $row['order_date'] . "</td>";
                        echo "<td>" . $status_label . "</td>";
                        echo "<td>";
                        if ($row['status'] == 't') {
                            echo "<form method='post'>";
                            echo "<input type='hidden' name='order_id' value='" . $row['order_id'] . "'>";
                            echo "<button type='submit' class='btn btn-success' name='received'>Receive</button>";
                            echo "</form>";
                        } elseif ($row['status'] == 'p') {
                            echo "<form method='post'>";
                            echo "<input type='hidden' name='order_id' value='" . $row['order_id'] . "'>";
                            echo "<button type='submit' class='btn btn-danger' name='cancel'>Cancel</button>";
                            echo "</form>";
                        } elseif ($row['status'] == 'r') {
                            echo "<button class='btn btn-success' disabled>Received</button>";
                        } elseif ($row['status'] == 'c') {
                            echo "<form method='post'>";
                            echo "<input type='hidden' name='order_id' value='" . $row['order_id'] . "'>";
                            echo "<button type='submit' class='btn btn-danger' name='delete'>Delete</button>";
                            echo "</form>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='13'>No orders found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <?php
    // Handle received, cancelled, or deleted orders
    if (isset($_POST['received'])) {
        $order_id = $_POST['order_id'];
        // Update the status of the order to 'Received'
        $update_sql = "UPDATE orders SET status = 'r' WHERE order_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        // Redirect to the same page to refresh the order history
        echo "<script>alert('Order marked as Received');</script>";
        echo "<script>window.location.href = 'orders.php';</script>";
        exit;
    } elseif (isset($_POST['cancel'])) {
        $order_id = $_POST['order_id'];
        // Update the status of the order to 'Cancelled'
        $update_sql = "UPDATE orders SET status = 'c' WHERE order_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        // Redirect to the same page to refresh the order history
        echo "<script>alert('Order cancelled');</script>";
        echo "<script>window.location.href = 'orders.php';</script>";
        exit;
    } elseif (isset($_POST['delete'])) {
        $order_id = $_POST['order_id'];
        // Delete the order
        $delete_sql = "DELETE FROM orders WHERE order_id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        // Redirect to the same page to refresh the order history
        echo "<script>alert('Order deleted');</script>";
        echo "<script>window.location.href = 'orders.php';</script>";
        exit;
    }
    ?>
</body>
</html>
