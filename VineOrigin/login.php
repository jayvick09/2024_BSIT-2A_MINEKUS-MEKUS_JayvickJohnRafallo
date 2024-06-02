<?php
session_start(); // Start the session

// Include your database connection file
include('server/connection.php');

// Check if form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Collect form data
    $user_email = mysqli_real_escape_string($conn, $_POST['email']);
    $user_password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Prepare a SQL query to fetch user details
    $sql = "SELECT * FROM users WHERE user_email = '$user_email' AND user_password = '$user_password'";
    $result = mysqli_query($conn, $sql);
    
    // Check if query executed successfully
    if($result) {
        // Check if user exists
        if(mysqli_num_rows($result) == 1) {
            // Fetch user data
            $row = mysqli_fetch_assoc($result);
            
            // Store user data in session variables
            $_SESSION["user_id"] = $row['user_id'];
            $_SESSION["user_name"] = $row['user_name'];
            $_SESSION["address"] = $row['address'];
            $_SESSION["user_email"] = $row['user_email'];
            $_SESSION["user_type"] = $row['user_type'];
            $_SESSION["logged_in"] = true; // Set logged_in to true
            
            // Redirect user based on user_type
            if ($row['user_type'] == 'u') {
                header("location: index.php"); // Redirect user to index.php for regular users
            } elseif ($row['user_type'] == 'a') {
                header("location: adminpage.php"); // Redirect admin user to adminpage.php
            } else {
                // Handle other user types here if needed
            }
            exit;
        } else {
            // User not found
            $error_message = "Invalid email or password";
        }
    } else {
        // Error in executing the query
        $error_message = "Oops! Something went wrong. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <?php include('header.php'); ?>
<body>


<!--Login-->
    <section class="">
    <div class="container text-center mt-2 pt-2">
      <img src="./assets/images/logo.jpeg"  height="200px" width="200px"/>
        <h2 class="form-weight-bold">Login</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container">
        <form id="login-form" method="POST" action="login.php">
          <p style="color: red" class="text-center"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" id="login-email" name="email" placeholder="Email" required/>
            </div>
            <div class="form-group">
                <label>Passsword</label>
                <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required/>
        </div>
        <div class="form-group">
            <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login"/>
        </div>
        <div class="form-group">
            <a id="register-url" href="register.php" class="btn-oblong">Don't have an account? Register</a>
        </div>
        </form>
    </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
