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

// Change password logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    // Validate password fields
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate current password and new password confirmation
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // TODO: Validate the current password and update the password in the database

        // Example query:
        $user_id = $_SESSION["user_id"];
        $update_query = "UPDATE users SET user_password = '$password' WHERE user_id = $user_id";
         $update_result = mysqli_query($conn, $update_query);

        // Redirect to account page or display success message
        if ($update_result) {
            header("location: ./admin_account.php"); // Redirect to account page
            exit;
        } else {
            $error = "Failed to change password. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('header.php'); ?>
<body>
<?php include('admin_navbar.php'); ?>
    
<section class="my-5 py-5">
    <div class="row container mx-auto">
        <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
            <h3 class="font-weight-bold">Account Information</h3>
            <hr class="mx-auto">
            <div class="account-info">
                <p class="tite">Name: <span><?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'N/A'; ?></span></p>
                <p class="tite">Email: <span><?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'N/A'; ?></span></p>

              <form method="POST" action="">
                <button type="submit" name="logout" class="btn-rounded">Logout</button>
              </form>
            </div>
        </div>

        <div class="opo col-lg-6 col-md-12 col-sm-12">
            <form id="account-form" method="POST" action="">
                <h3 class="chear">Change Password</h3>
                <hr class="mx-auto">
                <?php if(isset($error)): ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="account-password" name="password" placeholder="Password" required/>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" id="account-password-confirm" name="confirm_password" placeholder="Confirm Password" required/>
                </div>
                <div class="form-group">
                    <input type="submit" value="Change Password" class="btn-oblong" id="change-password-btn"/>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
<html>
