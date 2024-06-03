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
        <h1>Users</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>Address</th>
                    <th>User Email</th>
                    <th>User Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch users from the database
                $sql = "SELECT * FROM users"; // Assuming your table name is 'users'
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['user_name'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['user_email'] . "</td>";
                        echo "<td>" . ($row['user_status'] == 'a' ? 'active' : 'inactive') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
