<?php
session_start();
include('server/connection.php');

// Check if user is not logged in or not an admin, then redirect to login page
if (!isset($_SESSION["logged_in"]) || $_SESSION["user_type"] !== 'u') {
    header("location: ./login.php");
    exit;
}

// Logout logic
if (isset($_POST['logout'])) {
    session_destroy(); // Destroy the session
    header("location: ./login.php"); // Redirect to the login page
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('header.php'); ?>

<body>
    <?php include('shop_navbar.php'); ?>

    <!-- Home -->
    <section id="home">
        <div class="container">
            <h1 class="arrive">NEW ARRIVALS</h1>
            <h1 class="best"><span class="best">Best Shoes</span> You Can Have!!</h1>
            <p class="text-white">Vine Origin offers the best shoes at affordable prices</p>
        </div>
    </section>

    <!-- Featured -->
    <section id="featured" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5">
            <h3 class="pamagat">Features</h3>
            <hr class="container text-center">
            <p class="sell">Here you can check out our Best Seller Shoes</p>
        </div>
        <div class="row mx-auto container-fluid">
            <?php include('server/get_featured_products.php'); ?>
            <?php while ($row = $featured_products->fetch_assoc()) { ?>
                <?php if ($row['status'] === 'a') { ?>
                    <div class="product text-center col-lg3 col-md-4 col-sm-12">
                        <a href="add_to_cart.php?product_id=<?php echo $row['product_id']; ?>">
                            <img class="img-fluid mb-3" src="assets/images/featured/<?php echo $row['product_image']; ?>" />
                        </a>
                        <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                        <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
                        <a href="add_to_cart.php?product_id=<?php echo $row['product_id']; ?>" class="buy-btn btn btn-primary">Buy Now</a>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </section>

    <!-- Banner -->
    <section id="banner" class="my-5 py-5">
        <div class="container">
            <h4 class="nika">VINE ORIGIN's CATEGORY SHOES SALE</h4>
            <h1>Divine Collection <br></h1>
            <button class="orders-btn"><a style="text-decoration: none;" href="shop.php">shop now</a></button>
        </div>
    </section>

    <!-- Basketball Shoes -->
    <section id="shoes" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5">
            <h3 class="pamagat">BASKETBALL SHOES</h3>
            <hr class="container text-center">
            <p class="sell">Here you can check out our basketball shoes</p>
        </div>
        <div class="row mx-auto container-fluid">
            <?php include('server/get_bbshoes.php'); ?>
            <?php while ($row = $bbshoes_products->fetch_assoc()) { ?>
                <?php if ($row['status'] === 'a') { ?>
                    <div class="product text-center col-lg3 col-md-4 col-sm-12">
                        <a href="add_to_cart.php?product_id=<?php echo $row['product_id']; ?>">
                            <img class="img-fluid mb-3" src="assets/images/bbshoes/<?php echo $row['product_image']; ?>" />
                        </a>
                        <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                        <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
                        <a href="add_to_cart.php?product_id=<?php echo $row['product_id']; ?>" class="buy-btn btn btn-primary">Buy Now</a>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </section>

    <!-- Casual Shoes -->
    <section id="shoes" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5">
            <h3 class="pamagat">CASUAL SHOES</h3>
            <hr class="container text-center">
            <p class="sell">Here you can check out our casual shoes</p>
        </div>
        <div class="row mx-auto container-fluid">
            <?php include('server/get_cashoes.php'); ?>
            <?php while ($row = $cashoes_products->fetch_assoc()) { ?>
                <?php if ($row['status'] === 'a') { ?>
                    <div class="product text-center col-lg3 col-md-4 col-sm-12">
                        <a href="add_to_cart.php?product_id=<?php echo $row['product_id']; ?>">
                            <img class="img-fluid mb-3" src="assets/images/cashoes/<?php echo $row['product_image']; ?>" />
                        </a>
                        <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                        <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
                        <a href="add_to_cart.php?product_id=<?php echo $row['product_id']; ?>" class="buy-btn btn btn-primary">Buy Now</a>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </section>

    <!-- Running Shoes -->
    <section id="shoes" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5">
            <h3 class="pamagat">RUNNING SHOES</h3>
            <hr class="container text-center">
            <p class="sell">Here you can check out our running shoes</p>
        </div>
        <div class="row mx-auto container-fluid">
            <?php include('server/get_runshoes.php'); ?>
            <?php while ($row = $runshoes_products->fetch_assoc()) { ?>
                <?php if ($row['status'] === 'a') { ?>
                    <div class="product text-center col-lg3 col-md-4 col-sm-12">
                        <a href="add_to_cart.php?product_id=<?php echo $row['product_id']; ?>">
                            <img class="img-fluid mb-3" src="assets/images/running_shoes/<?php echo $row['product_image']; ?>" />
                        </a>
                        <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                        <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
                        <a href="add_to_cart.php?product_id=<?php echo $row['product_id']; ?>" class="buy-btn btn btn-primary">Buy Now</a>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="mt-5 py-5">
        <!-- Footer content -->
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
