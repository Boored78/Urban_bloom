class CartManager {
    static addToCart(productId, quantity = 1) {
        $.ajax({
            url: 'add_to_cart.php',
            type: 'POST',
            data: { product_id: productId, quantity: quantity },
            dataType: 'json',
            success: function(response) {
                console.log("Response from server:", response);
                if (response.success) {
                    alert("Product added to cart!");
                    if (response.newProduct) {
                        CartManager.updateCartCount();
                    }
                } else {
                    alert("Error adding to cart: " + response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("AJAX Error:", textStatus, errorThrown);
                alert("Failed to add product. Check console for errors.");
            }
        });
    }

    static updateCartCount() {
        $.ajax({
            url: 'fetch_cart_count.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log("Cart Count Response:", response);
                if (response.cartCount !== undefined) {
                    $("#cart-count").text(response.cartCount);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("AJAX Error:", textStatus, errorThrown);
            }
        });
    }

    static updateQuantity(productId, newQuantity) {
        $.ajax({
            url: "update_cart.php",
            type: "POST",
            data: { product_id: productId, quantity: newQuantity },
            dataType: 'json',
            success: function(response) {
                console.log("Response:", response);
                if (response.success) {
                    $("#total-" + productId).text(parseFloat(response.newTotal).toFixed(2));
                    $("#cartSubtotal").text(parseFloat(response.subtotal).toFixed(2));
                }
            }
        });
    }

    static removeFromCart(productId) {
        $.ajax({
            url: 'remove_from_cart.php',
            type: 'POST',
            data: { product_id: productId },
            success: function(response) {
                let data = JSON.parse(response);
                if (data.success) {
                    location.reload();
                } else {
                    alert("Failed to remove item!");
                }
            }
        });
    }
}

class UIManager {
    static attachEventListeners() {
        $(document).ready(function () {
            $("#search-bar").on("keypress", function (e) {
                if (e.which === 13) {
                    UIManager.updateSearch();
                }
            });
            $("#search-button").on("click", UIManager.updateSearch);
            UIManager.initCarousels();
            UIManager.initStickyNavbar();
            UIManager.initBackToTop();
        });
    }

    static updateSearch() {
        let query = $('#search-bar').val();
        window.location.href = 'my_shop2.php?query=' + query;
    }

    static initCarousels() {
        $(".header-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 1500,
            items: 1,
            dots: true,
            loop: true,
            nav: true,
            navText: ['<i class="bi bi-chevron-left"></i>', '<i class="bi bi-chevron-right"></i>']
        });
    }

    static initStickyNavbar() {
        var navbar = document.querySelector('.navbar');
        if (navbar) {
            var stickyOffset = navbar.offsetTop;
            window.onscroll = function () {
                if (window.pageYOffset > stickyOffset) {
                    navbar.classList.add('sticky');
                } else {
                    navbar.classList.remove('sticky');
                }
            };
        }
    }

    static initBackToTop() {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 300) {
                $('.back-to-top').fadeIn('slow');
            } else {
                $('.back-to-top').fadeOut('slow');
            }
        });
        $('.back-to-top').click(function () {
            $('html, body').animate({scrollTop: 0}, 500, 'linear');
            return false;
        });
    }
}

document.addEventListener("DOMContentLoaded", function () {
    UIManager.attachEventListeners();
    CartManager.updateCartCount();

    $(document).on("change", ".quantity-input", function () {
        let productId = $(this).data("product-id");
        let newQuantity = $(this).val();
        CartManager.updateQuantity(productId, newQuantity);
    });

    $(document).on("click", ".remove-btn", function () {
        let productId = $(this).data("product-id");
        CartManager.removeFromCart(productId);
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Spinner (page loading effect)
    var spinner = function () {
        setTimeout(function () {
            var spinnerElement = document.querySelector('#spinner');
            if (spinnerElement) {
                spinnerElement.classList.remove('show');
            }
        }, 1);
    };
    spinner();

});

function addToCart(productId, quantity = 1) {
    $.ajax({
        url: 'add_to_cart.php',
        type: 'POST',
        data: { product_id: productId, quantity: quantity },
        dataType: 'json',
        success: function(response) {
            console.log("Response from server:", response); // Debugging log

            if (response.success) {
                alert("Product added to cart!");

                // Only update cart count if it's a new product addition
                if (response.newProduct) {
                    updateCartCount(); // Update cart count dynamically
                }
            } else {
                alert("Error adding to cart: " + response.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error:", textStatus, errorThrown);
            alert("Failed to add product. Check console for errors.");
        }
    });
}



function updateCartCount() {
    $.ajax({
        url: 'fetch_cart_count.php', // Fetch latest cart count from the server
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log("Cart Count Response:", response); // Debugging log

            if (response.cartCount !== undefined) {
                $("#cart-count").text(response.cartCount); // Update UI
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error:", textStatus, errorThrown);
        }
    });
}

// Ensure cart count updates on page load
$(document).ready(function () {
    updateCartCount();
});

$(document).ready(function () {
    let debounceTimer;

    $(".quantity-input").on("input", function () {
        clearTimeout(debounceTimer);

        let $input = $(this);
        let productId = $input.data("product-id");
        let newQuantity = parseInt($input.val(), 10);

        if (isNaN(newQuantity) || newQuantity < 1) {
            console.warn("Invalid quantity entered:", newQuantity);
            return;
        }

        debounceTimer = setTimeout(() => {
            $.ajax({
                url: "update_cart.php",
                type: "POST",
                data: { product_id: productId, quantity: newQuantity },
                dataType: 'json', // Ensure correct response parsing
                success: function (response) {
                    console.log("Response:", response); // Debugging

                    if (response.success) {
                        // Ensure the total price does NOT already have a "$" before updating
                        $("#total-" + productId).text(parseFloat(response.newTotal).toFixed(2));
                        $("#cartSubtotal").text(parseFloat(response.subtotal).toFixed(2));
                        updateCartCount(); // Refresh cart count
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Update cart AJAX error:", textStatus, errorThrown);
                }
            });
        }, 500); // Debounce delay
    });
});
