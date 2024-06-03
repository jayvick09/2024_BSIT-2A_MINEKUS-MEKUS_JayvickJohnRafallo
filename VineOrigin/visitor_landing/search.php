<?php
session_start();
include('server/connection.php');

// Function to calculate available stock
function getAvailableStock($product_id, $conn) {
    $sql_product = "SELECT * FROM products WHERE product_id = $product_id";
    $result_product = $conn->query($sql_product);

    if ($result_product->num_rows > 0) {
        $product = $result_product->fetch_assoc();
        // Get available stock only if quantity is added
        return ($product['product_stock'] > 0) ? $product['product_stock'] : 0;
    } else {
        // Product not found
        return 0;
    }
}

$available_stock = 0; // Initialize the variable

if (isset($_GET['query'])) {
    $search_query = $_GET['query'];
    $sql_search = "SELECT * FROM products WHERE product_name LIKE '%$search_query%' OR description LIKE '%$search_query%'";
    $result_search = $conn->query($sql_search);
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('header.php'); ?>
<body>
    <?php include('navbar.php'); ?>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12">
              
                <?php
                if ($result_search->num_rows > 0) {
                    while ($product = $result_search->fetch_assoc()) {
                        $available_stock = getAvailableStock($product['product_id'], $conn);
                        ?>
                        <div class="card-oblong mb-3">
                            <div class="row g-0">
                                <div class="col-md-6">
                                    <img src="assets/images/<?php echo $product['category']; ?>/<?php echo $product['product_image']; ?>" class="img-fluid rounded-start" alt="<?php echo $product['product_name']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <h5 class="arrive"><?php echo $product['product_name']; ?></h5>
                                        <p class="selos"><?php echo $product['description']; ?></p>
                                        <p class="tite">Price: Php <?php echo $product['product_price']; ?></p>
                                        <p class="selosa">Available Stock: <?php echo $available_stock; ?></p>
                                        <form id="addToCartForm" method="post" action="add_to_cart_process.php"> <!-- Change the action to add_to_cart_process.php -->
                                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                            <input type="hidden" name="available_stock" value="<?php echo $available_stock; ?>"> <!-- Pass available stock as hidden input -->
                                            <div class="form-group">
                                                <label for="quantity">Quantity</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="<?php echo $available_stock; ?>"> <!-- Set maximum value to available stock -->
                                            </div>
                                            <button type="submit" class="btn-oblong btn-primary mt-3">Add to Cart</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p class='arrive text-center'>No products found.</p>";
                }
                ?>
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
