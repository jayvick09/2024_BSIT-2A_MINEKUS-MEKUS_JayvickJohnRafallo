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

$message = array();

if (isset($_POST['add_product'])) {
    // Retrieve form data
    $p_name = $_POST['p_prod_name'];
    $p_price = $_POST['p_prod_price'];
    $p_category = $_POST['p_prod_category'];
    $p_stock = $_POST['p_prod_stock'];
    $p_description = $_POST['p_prod_description'];

    // Single image upload for main product display
    $p_image = $_FILES['p_prod_image']['name'];
    $p_image_tmp_name = $_FILES['p_prod_image']['tmp_name'];

    // Construct folder path based on category
    $image_folder = 'assets/images/' . $p_category . '/';
    $p_image_folder = $image_folder . $p_image;

    // Insert product details into database using prepared statement
    $status = 'a'; // Default status for a new product
    $insert_query = $conn->prepare("INSERT INTO `products` (product_name, description, category, product_price, product_image, product_stock, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insert_query->bind_param("sssssss", $p_name, $p_description, $p_category, $p_price, $p_image, $p_stock, $status);
    $insert_query->execute();           

    if ($insert_query) {
        // Create category folder if it doesn't exist
        if (!is_dir($image_folder)) {
            mkdir($image_folder, 0777, true);
        }

        // Move uploaded image to the category folder
        move_uploaded_file($p_image_tmp_name, $p_image_folder);

        $message[] = 'Product Added Successfully.';
    } else {
        $message[] = 'Could not add the product';
    }
}

if (isset($_GET['delete'])) {
    // Your delete code remains unchanged
}

if (isset($_POST['update_product'])) {
    // Your update code remains unchanged
}

// Fetch product details for editing via AJAX
if(isset($_GET['get_product_details'])) {
    $productId = $_GET['get_product_details'];
    $select_query = mysqli_query($conn, "SELECT * FROM `products` WHERE product_id = '$productId'");
    if(mysqli_num_rows($select_query) > 0) {
        $product = mysqli_fetch_assoc($select_query);
        echo json_encode($product);
        exit; // Terminate script after sending response
    }
}

// Toggle product status via AJAX
if (isset($_POST['toggle_status'])) {
    $productId = $_POST['product_id'];
    $currentStatus = $_POST['current_status'];
    $newStatus = $currentStatus === 'a' ? 'i' : 'a'; // Toggle status

    $update_query = $conn->prepare("UPDATE `products` SET status = ? WHERE product_id = ?");
    $update_query->bind_param("ss", $newStatus, $productId);
    $update_query->execute();

    if ($update_query) {
        echo 'Status updated successfully';
    } else {
        echo 'Failed to update status';
    }
    exit; // Terminate script after sending response
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('header.php'); ?> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        #edit-product-image:hover {
            opacity: 0.7;
        }
    </style>
</head>

<body>

    <?php include('admin_navbar.php'); ?>

    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<div class="message"><span>' . $msg . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
        };
    };
    ?>

    <div class="container">
        <!-- Add product button -->
        <button id="add-product-btn" class="buton">Add Product</button>

        <section class="add-product-form" style="display: none;">
            <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
                <h3>Add a New Product</h3>
                <label for="p_prod_name">Product Name</label>
                <input type="text" id="p_prod_name" name="p_prod_name" placeholder="Enter the product name" class="box" required>

                <label for="p_prod_description">Product Description</label>
                <textarea id="p_prod_description" name="p_prod_description" placeholder="Enter the product description" class="box" required></textarea>

                <label for="p_prod_price">Product Price</label>
                <input type="number" id="p_prod_price" name="p_prod_price" min="0" placeholder="Enter the product price" class="box" required>

                <label for="p_prod_stock">Product Stock</label>
                <input type="number" id="p_prod_stock" name="p_prod_stock" min="0" placeholder="Enter the product stock" class="box" required>

                <label for="p_prod_category">Product Category</label>
                <select id="p_prod_category" name="p_prod_category" class="box" required>
                    <option value="featured">Featured</option>
                    <option value="bbshoes">Basketball Shoes</option>
                    <option value="cashoes">Casual Shoes</option>
                    <option value="running_shoes">Running Shoes</option>
                </select>

                <label for="p_prod_image">Main Product Image</label>
                <input type="file" id="p_prod_image" name="p_prod_image" accept="image/png, image/jpg, image/jpeg" class="box" required>

                <input type="submit" value="Add the Product" name="add_product" class="bton">
            </form>
        </section>


        <section class="display-product-table">
            <table>
                <thead>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                    $categories = ['featured', 'bbshoes', 'cashoes', 'running_shoes'];
                    foreach ($categories as $category) {
                        $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE category = '$category'");
                        if (mysqli_num_rows($select_products) > 0) {
                            while ($row = mysqli_fetch_assoc($select_products)) {
                                // Determine the folder based on the category
                                $image_folder = 'assets/images/' . $category . '/' . $row['product_image'];
                    ?>
                                <tr>
                                    <td><img src="<?php echo $image_folder; ?>" height="100" alt=""></td>
                                    <td><?php echo $row['product_name']; ?></td>
                                    <td>₱<?php echo $row['product_price']; ?></td>
                                    <td><?php echo $row['product_stock']; ?></td>
                                    <td><?php echo $row['status'] === 'a' ? 'Active' : 'Inactive'; ?></td>
                                    <td>
                                        <a href="#" class="toggle-status" data-product-id="<?php echo $row['product_id']; ?>" data-current-status="<?php echo $row['status']; ?>">
                                            <?php echo $row['status'] === 'a' ? 'Deactivate' : 'Activate'; ?>
                                        </a>
                                        <a href="addproducts.php?delete=<?php echo $row['product_id']; ?>" class="delete-bton" onclick="return confirm('Are you sure you want to delete this?');">
                                            <i class="fas fa trash"></i> Delete
                                        </a>
                                        <a href="#" class="edit-product-btn" data-product-id="<?php echo $row['product_id']; ?>">
                                            <i class="fas fa-edit"></i> Update
                                        </a>
                                    </td>
                                </tr>
                    <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' class='empty'>No product added</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
        <section class="edit-form-container" style="display: none;">
            <div class="edit-form">
                <form action="" method="post" enctype="multipart/form-data">
                    <h3>Edit Product</h3>
                    <div class="image-container">
                        <!-- Display image that can be clicked to select a new image -->
                        <img src="" id="edit-product-image" alt="" onclick="document.getElementById('edit-product-image-input').click();" style="cursor: pointer;">
                        <!-- Hidden input field to trigger file selection dialog -->
                        <input type="file" id="edit-product-image-input" style="display: none;" accept="image/png, image/jpg, image/jpeg" onchange="updatePreview(event)">
                    </div>
                    <input type="hidden" id="edit-product-id" name="edit_product_id" value="">
                    <label for="edit-product-name">Product Name</label>
                    <input type="text" id="edit-product-name" class="box" required name="edit_product_name">

                    <label for="edit-product-price">Product Price</label>
                    <input type="number" id="edit-product-price" min="0" class="box" required name="edit_product_price">

                    <label for="edit-product-stock">Product Stock</label>
                    <input type="number" id="edit-product-stock" name="edit_product_stock" min="0" class="box" required>

                    <label for="edit-product-description">Product Description</label>
                    <textarea id="edit-product-description" name="edit_product_description" class="box" required></textarea>

                    <div class="buttons">
                        <input type="submit" value="Update" name="update_product" class="bton">
                        <input type="button" value="Cancel" id="close-edit" class="option-bton">
                    </div>
                </form>
            </div>
        </section>

    </div>

    <script>
        // Function to update the image preview when a new image is selected
        function updatePreview(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var dataURL = reader.result;
                document.getElementById('edit-product-image').src = dataURL;
            };
            reader.readAsDataURL(input.files[0]);
        }

        document.getElementById('add-product-btn').addEventListener('click', function() {
            var form = document.querySelector('.add-product-form');
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
        });

        document.querySelectorAll('.edit-product-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                var productId = this.getAttribute('data-product-id');
                showEditForm(productId);
            });
        });

        function showEditForm(productId) {
            var formContainer = document.querySelector('.edit-form-container');
            formContainer.style.display = 'block';

            // Make AJAX request to fetch product details
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var product = JSON.parse(xhr.responseText);
                    populateEditForm(product);
                }
            };
            xhr.open('GET', '<?php echo $_SERVER['PHP_SELF']; ?>?get_product_details=' + productId, true);
            xhr.send();
        }

        function populateEditForm(product) {
            document.getElementById('edit-product-id').value = product.product_id;
            document.getElementById('edit-product-name').value = product.product_name;
            document.getElementById('edit-product-description').value = product.description;
            document.getElementById('edit-product-price').value = product.product_price;
            document.getElementById('edit-product-stock').value = product.product_stock;
            // Set image source
            document.getElementById('edit-product-image').src = 'assets/images/' + product.category + '/' + product.product_image;
        }

        document.getElementById('close-edit').addEventListener('click', function() {
            document.querySelector('.edit-form-container').style.display = 'none';
        });

        // Toggle status via AJAX
        document.querySelectorAll('.toggle-status').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                var productId = this.getAttribute('data-product-id');
                var currentStatus = this.getAttribute('data-current-status');
                toggleStatus(productId, currentStatus);
            });
        });

        function toggleStatus(productId, currentStatus) {
            // Make AJAX request to update status
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText;
                    // Refresh page or update UI as needed
                    window.location.reload(); // Reload the page for simplicity
                }
            };
            xhr.open('POST', '<?php echo $_SERVER['PHP_SELF']; ?>', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('toggle_status=true&product_id=' + productId + '&current_status=' + currentStatus);
        }
    </script>
</body>

</html>
