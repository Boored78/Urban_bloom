<?php
session_start();
require '../db_connection.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../login.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $gender = $_POST['gender'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    
    
    // Handle image upload
    $image = 'img/default_product.jpg'; // default image
    if (isset($_FILES['image'])) {
        $target_dir = "../img/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check if image file is a actual image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            // Generate unique filename
            $new_filename = uniqid() . '.' . $imageFileType;
            $target_file = $target_dir . $new_filename;
            
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = 'img/' . $new_filename;
            }
        }
    }
    
    // Insert product
    $stmt = $connection->prepare("INSERT INTO products (name, image, price, gender, type, quantity) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdssi", $name, $image, $price, $gender, $type, $quantity);
    
    if ($stmt->execute()) {
        $product_id = $stmt->insert_id;
        
        // Insert description
        $desc_stmt = $connection->prepare("INSERT INTO product_descriptions (product_id, description) VALUES (?, ?)");
        $desc_stmt->bind_param("is", $product_id, $description);
        $desc_stmt->execute();
        
        $success = "Product added successfully!";
    } else {
        $error = "Error adding product: " . $connection->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="../css/my_bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'admin_navbar.php'; ?>
    
    <div class="container mt-4">
        <h1>Add New Product</h1>
        
        <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        
        <form action="add_product.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>
            
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="unisex">Unisex</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="woody">Woody</option>
                    <option value="floral">Floral</option>
                    <option value="oriental">Oriental</option>
                    <option value="fresh">Fresh</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
            </div>
            
            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            
            <button type="submit" class="btn btn-primary">Add Product</button>
            <a href="products.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
