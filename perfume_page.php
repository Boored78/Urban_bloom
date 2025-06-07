<?php
session_start();
require 'db_connection.php';

// Handle the search query
$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';
$sql = "SELECT id, name, image, price FROM products";
if (!empty($searchQuery)) {
    $sql .= " WHERE name LIKE ?";
    $stmt = $connection->prepare($sql);
    $likeQuery = "%" . $searchQuery . "%";
    $stmt->bind_param("s", $likeQuery);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    $result = $connection->query($sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Shop</h2>
        <div class="d-flex">
            <input type="text" id="search-bar" class="form-control" placeholder="Search for products...">
            <button id="search-button" class="btn btn-primary ms-2">
                <i class="fas fa-search"></i> <!-- Magnifying Glass Icon -->
            </button>
        </div>
        <div class="shop-listing mt-3" id="shop-list">
            <?php while ($item = $result->fetch_assoc()): ?>
                <div class="shop">
                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                    <div class="shop-details">
                        <h3><?= htmlspecialchars($item['name']) ?></h3>
                        <p class="price"><?= number_format($item['price'], 2) ?> лв.</p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Include FontAwesome for the magnifying glass icon -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <script>
        $(document).ready(function () {
            // Function to update results
            function updateSearch() {
                let query = $('#search-bar').val();
                window.location.href = 'my_shop2.php?query=' + query;
            }

            // Trigger search when Enter is pressed in the search bar
            $('#search-bar').on('keypress', function (e) {
                if (e.which === 13) { // Enter key code
                    updateSearch();
                }
            });

            // Trigger search when magnifying glass icon or search button is clicked
            $('#search-button').on('click', function () {
                updateSearch();
            });
        });
    </script>
</body>
</html>
