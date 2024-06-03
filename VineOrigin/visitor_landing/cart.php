<?php
session_start();
include('server/connection.php');

if (!isset($_SESSION["logged_in"]) || $_SESSION["user_type"] !== 'u') {
    header("location: ./login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

// Modify the SQL query to include product price
$sql = "SELECT cart.cart_id, products.product_name, products.product_price, cart.quantity
        FROM cart
        INNER JOIN products ON cart.product_id = products.product_id
        WHERE cart.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

function removeFromCart($conn, $cart_id) {
    $delete_sql = "DELETE FROM cart WHERE cart_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $cart_id);
    $stmt->execute();
}

// Fetch cart items
$cart_items = [];
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
}

// Store cart items in session
$_SESSION['cart_items'] = $cart_items;

if(isset($_POST['checkout'])) {
    // Redirect to checkout page
    // Here you can process the selected products before redirecting
    $selectedProducts = isset($_POST['selected_products']) ? $_POST['selected_products'] : [];
    $_SESSION['selected_products'] = $selectedProducts; // Storing selected products in session
    header("Location: checkout.php");
    exit;
}

if(isset($_POST['remove'])) {
    $cart_id = $_POST['cart_id'];
    removeFromCart($conn, $cart_id);
    echo "<script>alert('Item removed from cart');</script>";
    echo "<script>window.location.href = 'cart.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('header.php'); ?>
<body>
    <?php include('navbar.php'); ?>
    <div id="long" class="container mt-5">
        <h1 class="text-center mb-4">Shopping Cart</h1>
        <?php if (empty($cart_items)): ?>
            <div class="alert alert-info" role="alert">
                Your cart is empty.
            </div>
        <?php else: ?>
            <form method="post" action="">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Select</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="selected_products[]" value="<?php echo $item['cart_id']; ?>" class="product-checkbox">
                                </td>
                                <td><?php echo $item['product_name']; ?></td>
                                <td>Php <?php echo $item['product_price']; ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td>Php <?php echo $item['product_price'] * $item['quantity']; ?></td>
                                <td>
                                    <form method="post">
                                        <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                        <button type="submit" class="btn btn-danger" name="remove">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary" name="checkout" id="checkout-button" style="display: none;">Checkout</button>
            </form>
        <?php endif; ?>
    </div>
    <?php include('footer.php'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            const checkoutButton = document.getElementById('checkout-button');

            function toggleCheckoutButton() {
                const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                checkoutButton.style.display = anyChecked ? 'block' : 'none';
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', toggleCheckoutButton);
            });

            toggleCheckoutButton(); // Initial check on page load
        });
    </script>
</body>
</html>
