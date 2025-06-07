<?php
session_start();
require 'db_connection.php'; // Ensure MySQLi connection
require_once 'auth_user.php';

// Redirect if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Fetch cart items using MySQLi
$sql = "SELECT products.id, products.name, products.image, products.price, cart.quantity 
        FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.user_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/main.js"></script>

    
    

    <meta charset="utf-8">
    <title>Cart</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/logo1.ico" rel="icon">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    
    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    

    <!-- Customized Bootstrap Stylesheet -->
     
    <link href="css/my_bootstrap.min.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet">

</head> 

<body>


<!-- Topbar Start -->
<div class="container-fluid bg-dark p-0 topbar">
    <div class="container-fluid bg-dark text-light py-2 px-4">
        <div class="row align-items-center">
            <!-- Left Side: Address & Phone -->
            <div class="col-lg-6 d-none d-lg-flex justify-content-start">
                <small>
                    <i class="fa fa-map-marker-alt text-primary me-2 ms-2"></i>123 Street, New York, USA
                    <i class="fa fa-phone-alt text-primary me-2 ms-4"></i>+359 889 455 535
                </small>
            </div>

            <!-- Right Side: Social Icons + Cart/Profile -->
            <div class="col-lg-6 d-flex justify-content-lg-end justify-content-center align-items-center">
                <!-- Social Media Icons -->
                <a class="btn btn-sm-square text-primary me-1" style="background-color: black;" href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-sm-square text-primary me-1" style="background-color: black;" href="https://www.instagram.com/perfumesde_glamour/"><i class="fab fa-instagram"></i></a>

                <!-- Cart and Profile/Login -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="btn btn-sm-square text-primary me-1" style="background-color: black;" href="my_cart.php">
                        <i class="fa fa-shopping-cart"></i><span id="cart-count">0</span>
                    </a>
                    <a href="account.php" style="display: inline-block;">
                        <img src="<?php echo htmlspecialchars($profileImage); ?>"alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; margin-left: 5px;">
                    </a>
                <?php else: ?>
                    <a class="btn btn-sm-square text-primary me-1" style="background-color: black;" href="login.php">
                        <i class="fas fa-user-alt"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->



<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg navbar-white p-0 burger-menu" style="background-color: black; padding: 10px; opacity: calc(80%);">
    <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <img src="img/logo.png" alt="logo" style="width: 95px; height: 60px;">
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <!-- Nav links for mobile (centered) -->
        <div class="d-flex flex-row justify-content-center gap-3 w-100 d-lg-none" style="margin-top: 10px; font-family: 'Courier New'; font-weight: bolder;">
            <a href="index.php" class="nav-item nav-link text-primary">Home</a>
            <a href="index.php#About" class="nav-item nav-link text-primary">About</a>
            <a href="my_service.php" class="nav-item nav-link text-primary">Service</a>
            <a href="contact.php" class="nav-item nav-link text-primary">Contact</a>
        </div>

        <!-- Nav links for desktop (right-aligned) -->
        <div class="navbar-nav ms-auto d-none d-lg-flex flex-row gap-3 align-items-center" style="margin-top: 10px; margin-right: -10px; font-family: 'Courier New'; font-weight: bolder;">
            <a href="index.php" class="nav-item nav-link text-primary">Home</a>
            <a href="index.php#About" class="nav-item nav-link text-primary">About</a>
            <a href="my_service.php" class="nav-item nav-link text-primary">Service</a>
            <a href="contact.php" class="nav-item nav-link text-primary">Contact</a>
        </div>

        <!-- Shop Now button (desktop only) -->
        <a href="my_shop2.php" 
           class="btn btn-primary py-md-3 px-md-5 me-3 d-none d-lg-inline-block animated slideInLeft text-white" 
           style="color: white; margin-left: 20px; font-family: 'Courier New'; font-weight: bolder;">
            Shop Now
        </a>

        <!-- Shop Now button (mobile centered) -->
        <div class="w-100 text-center mt-3 d-lg-none">
            <a href="my_shop2.php" 
               class="btn btn-primary py-md-3 px-md-5 animated slideInLeft text-white" 
               style="color: white; font-family: 'Courier New'; font-weight: bolder;">
                Shop Now
            </a>
        </div>
    </div>
</nav>
<!-- Navbar End -->

    <!-- Shopping Cart -->
    <div class="container mt-5">
    <h1 class="text-center">Your Cart</h1>

    <?php if (empty($cart_items)) : ?>
        <div id="emptyCartMessage" class="empty-cart-message">
            Your cart is empty.
        </div>
    <?php else : ?>
        <div class="table-responsive">
            <table id="cartTable" class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="cartItems">
                    <?php
                    $subtotal = 0;
                    foreach ($cart_items as $item) {
                        $total_price = $item['price'] * $item['quantity'];
                        $subtotal += $total_price;
                    ?>
                        <tr>
                            <td>
                                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" width="50">
                                <?= htmlspecialchars($item['name']) ?>
                            </td>
                            <td><?= number_format($item['price'], 2) ?>лв.</td>
                            <td>
                            <input type="number" class="quantity-input" data-product-id="<?= $item['id'] ?>" value="<?= $item['quantity'] ?>" min="1">
                            </td>
                            <td><span id="total-<?= $item['id'] ?>"><?= number_format($total_price, 2) ?></span>лв.</td>
                            <td>
                                <button class="btn btn-danger btn-sm remove-btn" data-product-id="<?= $item['id'] ?>">Remove</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Subtotal Section -->
        <div class="subtotal-section">
            <h4>Total: <span id="cartSubtotal"><?= number_format($subtotal, 2) ?>лв.</span></h4>
            <a href="checkout.php" class="btn btn-lg btn-primary">Proceed to Checkout</a>
            </form>

            </div>
    <?php endif; ?>
</div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>









</body>

</html>
