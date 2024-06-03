<?php
session_start();
include('server/connection.php');

// Check if user is not logged in or not an admin, then redirect to login page
if (!isset($_SESSION["logged_in"]) || $_SESSION["user_type"] !== 'u') {
    header("location: ./login.php");
    exit;
}

// SQL query to fetch distinct categories
$sql_categories = "SELECT DISTINCT category FROM products WHERE status='a'";
$result_categories = $conn->query($sql_categories);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php'); ?>
    <link rel="stylesheet" href="assets/css/search.css">
</head>
<body>
    <?php include('shop_navbar.php'); ?>
    <div class="container-fluid my-10 border">  
        <?php
        // Loop through each category
        if ($result_categories->num_rows > 0) {
            while ($row_category = $result_categories->fetch_assoc()) {
                $category = $row_category['category'];
                // Set appropriate category label based on category name
                switch ($category) {
                    case 'cashoes':
                        $category_label = 'Casual Shoes';
                        $folder_name = 'cashoes';
                        break;
                    case 'bbshoes':
                        $category_label = 'Basketball Shoes';
                        $folder_name = 'bbshoes';
                        break;
                    case 'featured':
                        $category_label = 'Featured';
                        $folder_name = 'featured';
                        break;
                    case 'running_shoes':
                        $category_label = 'Running Shoes';
                        $folder_name = 'running_shoes';
                        break;
                    default:
                        $category_label = ucfirst($category); // Capitalize first letter of category name
                        $folder_name = $category;
                        break;
                }
        ?>
        <!-- <?php echo ucfirst($category); ?> Shoes Section -->
        <section id="<?php echo $category; ?>" class="my-2">
            <div class="container text-center mt-3 py-1">
                <h1 class="pamagat"><?php echo $category_label; ?></h1> <!-- Output the category label -->
                <hr class="container text-center">
                <p class="sell">Check out our <?php echo $category_label; ?> shoes collection</p>
            </div>
            <div class="row mx-auto container-fluid">
                <?php
                // SQL query to fetch products for this category where status is 'a'
                $sql_products = "SELECT * FROM products WHERE category='$category' AND status='a'";
                $result_products = $conn->query($sql_products);
                // Loop through each product for this category
                if ($result_products->num_rows > 0) {
                    while ($row_product = $result_products->fetch_assoc()) {
                ?>
                <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                    <a href="add_to_cart.php?product_id=<?php echo $row_product['product_id']; ?>">
                        <img class="img-fluid mb-3" src="assets/images/<?php echo $folder_name; ?>/<?php echo $row_product['product_image']; ?>"/>
                    </a>
                    <h5 class="p-name"><?php echo $row_product['product_name']; ?></h5>
                    <h4 class="p-price"><?php echo $row_product['product_price']; ?></h4>
                    <a href="add_to_cart.php?product_id=<?php echo $row_product['product_id']; ?>" class="buy-btn btn btn-primary">Buy Now</a>
                </div>
                <?php
                    }
                } else {
                    echo "<p>No products found in this category.</p>";
                }
                ?>
            </div>
        </section>
        <?php
            }
        } else {
            echo "<p>No categories found.</p>";
        }
        ?>
    </div>
    <?php include('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
<?php
// Close connection
$conn->close();
?>
