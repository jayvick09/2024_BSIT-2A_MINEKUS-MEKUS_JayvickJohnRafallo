<?php
session_start();
include('server/connection.php');

// Check if product ID is provided in the URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    
    // Fetch product details from the database based on the product ID
    $sql_product = "SELECT * FROM products WHERE product_id = $product_id";
    $result_product = $conn->query($sql_product);
    
    if ($result_product->num_rows > 0) {
        $product = $result_product->fetch_assoc();

        // Get available stock only if quantity is added
        $available_stock = ($product['product_stock'] > 0) ? $product['product_stock'] : 0;
    } else {
        // Product not found, handle this case accordingly
        echo "Product not found.";
        header("location: ./login.php");
        exit;
    }
} else {
    // Product ID not provided in the URL, handle this case accordingly
    echo "Product ID not provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <?php include('header.php'); ?>
<body>
    <?php include('navbar.php'); ?>
    <div class="container my-5">
        <div class="row">
        <div class="col-md-6">
    <!-- Display selected image -->
    <img class="img-fluid rounded mb-3" src="assets/images/<?php echo $product['category']; ?>/<?php echo $product['product_image']; ?>"/>
</div>

            <div class="col-md-6">
                <h1 class="arrive"><?php echo $product['product_name']; ?></h1>
                <h4 class="tite">Php <?php echo $product['product_price']; ?></h4>
                <p class="selos"><?php echo $product['description']; ?></p>
                <p class="selosa">Available Stock: <?php echo $available_stock; ?></p> <!-- Display available stock -->
                <form id="addToCartForm" method="post" action="add_to_cart_process.php">
                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="<?php echo $available_stock; ?>"> <!-- Set maximum value to available stock -->
                    </div>
                    <button type="submit" class="btn-oblong btn-primary mt-3">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
