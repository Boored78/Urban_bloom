<?php
session_start();
require '../db_connection.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$product_id = $_GET['id'];
$error = '';
$success = '';

// Fetch product data
$product_stmt = $connection->prepare("SELECT p.*, pd.description FROM products p LEFT JOIN product_descriptions pd ON p.id = pd.product_id WHERE p.id = ?");
$product_stmt->bind_param("i", $product_id);
$product_stmt->execute();
$product = $product_stmt->get_result()->fetch_assoc();

if (!$product) {
    header("Location: products.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $gender = $_POST['gender'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    
    $image = $product['image']; // keep current image by default
    
    // Handle image upload if new image is provided
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $target_dir = "../img/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            // Generate unique filename
            $new_filename = uniqid() . '.' . $imageFileType;
            $target_file = $target_dir . $new_filename;
            
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Delete old image if it's not the default
                if ($image !== 'img/default_product.jpg') {
                    @unlink("../" . $image);
                }
                $image = 'img/' . $new_filename;
            }
        }
    }
    
    // Update product
    $stmt = $connection->prepare("UPDATE products SET name = ?, image = ?, price = ?, gender = ?, type = ?, quantity = ? WHERE id = ?");
    $stmt->bind_param("ssdssii", $name, $image, $price, $gender, $type, $quantity, $product_id);
    
    if ($stmt->execute()) {
        // Update description
        $desc_stmt = $connection->prepare("UPDATE product_descriptions SET description = ? WHERE product_id = ?");
        $desc_stmt->bind_param("si", $description, $product_id);
        $desc_stmt->execute();
        
        $success = "Product updated successfully!";
        // Refresh product data
        $product_stmt->execute();
        $product = $product_stmt->get_result()->fetch_assoc();
    } else {
        $error = "Error updating product: " . $connection->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="../css/my_bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'admin_navbar.php'; ?>
    
    <div class="container mt-4">
        <h1>Edit Product</h1>
        
        <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        
        <form action="edit_product.php?id=<?= $product_id ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= $product['price'] ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender" required>
                    <option value="male" <?= $product['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
                    <option value="female" <?= $product['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
                    <option value="unisex" <?= $product['gender'] === 'unisex' ? 'selected' : '' ?>>Unisex</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="woody" <?= $product['type'] === 'woody' ? 'selected' : '' ?>>Woody</option>
                    <option value="floral" <?= $product['type'] === 'floral' ? 'selected' : '' ?>>Floral</option>
                    <option value="oriental" <?= $product['type'] === 'oriental' ? 'selected' : '' ?>>Oriental</option>
                    <option value="fresh" <?= $product['type'] === 'fresh' ? 'selected' : '' ?>>Fresh</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="<?= $product['quantity'] ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="5" required><?= htmlspecialchars($product['description']) ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" class="form-control" id="image" name="image">
                <small class="text-muted">Current image: <?= $product['image'] ?></small>
                <?php if ($product['image']): ?>
                <div class="mt-2">
                    <img src="../<?= $product['image'] ?>" alt="Current product image" style="max-height: 200px;">
                </div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="products.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>