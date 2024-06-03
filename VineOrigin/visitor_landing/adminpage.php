<?php
session_start();
include('server/connection.php');

// Check if user is not logged in or not an admin, then redirect to login page
if (!isset($_SESSION["logged_in"]) || $_SESSION["user_type"] !== 'a') {
    header("location: ./login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include('header.php'); ?>

 

 </head>

<body>

<?php include('admin_navbar.php'); ?>

<div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM `products`")->num_rows; ?></h3>
                
                <p>Total Products</p>
              </div>
              <div class="icon">
              <i class='fas fa-shoe-prints'></i>
              </div>
            </div>
          </div>
       </div>

       <div class="row">
          <div class="col-md-3">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM `users`")->num_rows; ?></h3>

                <p>Total Users</p>
              </div>
              <div class="icon">
              <i class='fas fa-user-alt'></i>
              </div>
            </div>
          </div>
       </div>

       <div class="row">
          <div class="col-md-3">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM `orders`")->num_rows; ?></h3>

                <p>Total Orders</p>
              </div>
              <div class="icon">
              <i class='fas fa-shopping-basket'></i>
              </div>
            </div>
          </div>
       </div>

       <div class="row">
    <div class="col-md-3">
        <div class="small-box bg-light shadow-sm border">
            <div class="inner">
            <?php
@include 'server/connection.php';


// Query to select total sales from orders where payment_status is '1'
$result = $conn->query("SELECT SUM(price_total) AS total_sales FROM `orders` WHERE `status` = 'r'");

// Check if the query executed successfully
if ($result) {
    // Fetch the total sales value
    $row = $result->fetch_assoc();
    $totalPaidSales = $row["total_sales"];
} else {
    // If the query fails, set total sales to 0
    $totalPaidSales = 0;
}
?>

                <h3>₱<?= number_format($totalPaidSales, 2) ?></h3>
                <p>Total Sales: </p>
            </div>
            <div class="icon">
            <i class='fas fa-dollar-sign'></i>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
</body>
</html>