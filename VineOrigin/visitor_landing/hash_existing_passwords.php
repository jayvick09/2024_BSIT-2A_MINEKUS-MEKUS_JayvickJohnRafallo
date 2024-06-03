<?php
include('server/connection.php');

// Fetch all users
$query = "SELECT user_id, user_password FROM users";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $user_id = $row['user_id'];
        $hashed_password = password_hash($row['user_password'], PASSWORD_DEFAULT);

        // Update the user password with hashed password
        $update_query = "UPDATE users SET user_password = ? WHERE user_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("si", $hashed_password, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

echo "Passwords updated successfully.";
?>
