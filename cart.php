<?php
session_start();

if (isset($_POST['add_to_cart'])) {
    if (isset($_SESSION['cart'])) {
        $product_array_ids = array_column($_SESSION['cart'], "product_id");

        if (!in_array($_POST['product_id'], $product_array_ids)) {
            $product_id = $_POST['product_id'];
            $product_array = array(
                'product_id' => $_POST['product_id'],
                'product_name' => $_POST['product_name'],
                'product_price' => $_POST['product_price'],
                'product_image' => $_POST['product_image'],
                'product_quantity' => $_POST['product_quantity']
            );
            $_SESSION['cart'][$_POST['product_id']] = $product_array;
        } else {
            echo '<script>alert("Product was already added to cart");</script>';
        }
    } else {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = $_POST['product_quantity'];

        $product_array = array(
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
            'product_quantity' => $product_quantity,
        );
        $_SESSION['cart'][$product_id] = $product_array;
    }
    // Calculate total
    calculateTotalCart();

// Remove product from cart
} elseif (isset($_POST['remove_product'])) {
    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
    // Recalculate total after removing from cart
    calculateTotalCart();

} elseif (isset($_POST['edit_quantity'])) {
    // Get id and quantity from the form
    $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_quantity'];

    // Get the product array from the session
    $product_array = $_SESSION['cart'][$product_id];
    // Update product quantity
    $product_array['product_quantity'] = $product_quantity;
    // Return array back to its place
    $_SESSION['cart'][$product_id] = $product_array;
    // Recalculate total after editing quantity
    calculateTotalCart();

} else {
    //header('location: index.php');
}

function calculateTotalCart() {
    $total = 0;
    foreach ($_SESSION['cart'] as $key => $value) {
        $product = $_SESSION['cart'][$key];
        $price = $product['product_price'];
        $quantity = $product['product_quantity'];

        $total = $total + ($price * $quantity);
    }
    $_SESSION['total'] = $total;
}
?>


<!DOCTYPE html> 
<html lang="en"> 
<head>
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>cart</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/style.css"/>

</head> 
<body> 
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light py-3 fixed-top">
        <div class="container">
            <img src="assets/images/logo.png"/>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.html">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">ContactUs</a>
                    </li>
                    <li class="nav-item d-flex">
                        <a href="cart.php"><i class="fas fa-shopping-bag me-2"></i></a>
                        <a href="account.html"><i class="fas fa-user"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<!--cart-->
    <section class="cart container my-5 py-5">
        <div class="container mt-5">
            <h2 class="font-weight-bolde">Your Cart</h2>
            <hr>
        </div>
        <table class="mt-5 pt-5">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>

            <?php foreach($_SESSION['cart'] as $key => $value){ ?>
                <tr>
                    <td>
                        <div class="product-info">
                            <img src="assets/images/<?php echo $value['product_image'];?>"/>
                            <div>
                                <p><?php echo $value['product_name'];?></p>
                                <small><span>$</span><?php echo $value['product_price'];?></small>
                                <br>
                                <form method="POST" action="cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $value['product_id'];?>"/>
                                    <input type="submit" name="remove_product" class="remove-btn" value="remove"/>
                                </form>
                            </div>
                        </div>
                    </td>
                    <td class="quantity-column">
                        <form method="POST" action="cart.php"> 
                            <input type="hidden" name="product_id" value="<?php echo $value['product_id'];?>"/>
                            <input type="number" name="product_quantity" value="<?php echo $value['product_quantity']; ?>"/> 
                            <input type="submit" class="edit-btn" value="edit" name="edit_quantity"/>
                        </form> 
                    </td> 
                    <td>
                        <span>$</span>
                        <span class="product-price"><?php echo $value['product_quantity']* $value['product_price'];?></span>
                    </td>
                </tr>

            <?php }?>
        </table>

        <div class="cart-total">
            <table>
              
                <tr>
                    <td>Total</td>
                    <td>$<?php echo $_SESSION['total'];?></td>
                </tr>
            </table>
        </div>
        <div class="checkout-container">
            <form method="POST" action="checkout.php">
                <input type="submit" class="btn checkout-btn" value="Checkout" name="checkout">
            </form>
        </div>
    </section>












    <!--footer-->
<footer class="mt-5 py-5">
    <div class="row container mx-auto pt-5">
        <div class="footer one col-lg-3 col-md-6 col-sm-12">
            <img class="footer-logo" src="assets/images/logo.png" alt="Logo">
            <p class="pt-3">We provide the best Products For the most affordable prices</p>
        </div>
        <div class="footer one col-lg-3 col-md-6 col-sm-12">
           <h5 class="pb-2">Featured</h5>
           <ul class="text-uppercase">
            <li><a href="#">men</a></li>
            <li><a href="#">women</a></li>
            <li><a href="#">boys</a></li>
            <li><a href="#">girls</a></li>
            <li><a href="#">new arrivals</a></li>
            <li><a href="#">clothes</a></li>
           </ul>
        </div>
        <div class="footer one col-lg-3 col-md-6 col-sm-12">
            <h5 class="pb-2">contact Us</h5>
            <div>
                <h6 class="text-uppercase">Adresse</h6>
                <p>1234 street Name, City</p>
            </div>
            <div>
                <h6 class="text-uppercase">Phone</h6>
                <p>+216 66666666</p>
            </div>
            <div>
                <h6 class="text-uppercase">Email</h6>
                <p>info@gmail.com</p>
            </div>
        </div>
        <div class="footer one col-lg-3 col-md-6 col-sm-12">
            <h5 class="pb-2">Instagram</h5>
            <div class="row">
                <img src="assets/images/1.jpg" class="img-fluid w-25 h-100 m-2"/>
                <img src="assets/images/brand1.jpg" class="img-fluid w-25 h-100 m-2"/>
                <img src="assets/images/coats3.jpg" class="img-fluid w-25 h-100 m-2"/>
                <img src="assets/images/clothes.png" class="img-fluid w-25 h-100 m-2"/>
            </div>
        </div>
        <div class="copyright mt-5">
            <div class="row container mx-auto">
                <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
                    <img src="assets/images/payment.jpg"/>  
                </div>
                <div class="col-lg-3 col-md-5 col-sm-12 mb-4 text-nowrap mb-2">
                    <p>eCommerce@2023 All Right Reserved</p>
                </div>
                <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>
  





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>