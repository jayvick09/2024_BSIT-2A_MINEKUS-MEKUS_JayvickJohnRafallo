<?php
session_start();
include('server/connection.php');

if(isset($_POST['register'])){
  $user_name = $_POST['name'];
  $user_email = $_POST['email'];
  $user_password = $_POST['password'];
  $confirmPassword = $_POST['confirmpassword'];
  $address = $_POST['address'];  
  
  // Check password match and length
  if($user_password !== $confirmPassword){
    header('location: register.php?error=passwords%20don%27t%20match');
    exit();
  } else if(strlen($user_password) < 6){
    header('location: register.php?error=password%20must%20be%20at%20least%206%20characters');
    exit();
  } else {
    // Check if email already exists
    $stmt1 = $conn->prepare("SELECT count(*) FROM users where user_email=?");
    $stmt1->bind_param('s',$user_email);
    $stmt1->execute();
    $stmt1->bind_result($num_rows);
    $stmt1->store_result();
    $stmt1->fetch();

    if($num_rows != 0){
      header('location: register.php?error=user%20with%20this%20email%20already%20exists');
      exit();
    } else {
      // Create a new user
      $stmt = $conn->prepare("INSERT INTO users (user_name,user_email,user_password,address) VALUES (?,?,?,?)");
      $stmt->bind_param('ssss',$user_name,$user_email,$user_password,$address);

      if($stmt->execute()){
        $_SESSION['user_email'] = $user_email;
        $_SESSION['user_name'] = $user_name;
        $_SESSION['logged_in'] = true;
        // header('location: account.php?register=You%20registered%20successfully');
        header('location: ./login.php');
        exit();
      } else {
        header('location: register.php?error=Could%20not%20create%20an%20account%20at%20the%20moment');
        exit();
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">


<?php include('header.php'); ?>
<body>

<!--Register-->
    <section class="">
    <div class="container text-center mt-2 pt-3">
       <img src="./assets/images/logo.jpeg"  height="150px" width="150px"/>
        <h2 class="form-weight-bold">Register</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container">
   
   <form id="register-form" method="POST" action="register.php">
  <p style="color: red;"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
    <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" id="register-name" name="name" placeholder="Name" required/>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="text" class="form-control" id="register-email" name="email" placeholder="Email" required/>
          </div>
<div class="form-group">
    <label>Address</label>
    <input type="text" class="form-control" id="register-address" name="address" placeholder="Address" required/>
</div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required/>
    </div>
    <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" class="form-control" id="register-confirm-password" name="confirmpassword" placeholder="Confirm Password" required/>
    </div>
    <div class="form-group">
        <input type="submit" class="btn" id="register-btn" name="register" value="Register"/>
    </div>
    <div class="form-group">
        <a id="login-url" href="login.php" class="btn">Do you have an account? Login</a>
          </div>

</form>
      </div>
</section>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
