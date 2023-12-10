<?php

include('server/connection.php');

$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->get_result();

?>

<!DOCTYPE html> 
<html lang="en"> 
<head>
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Shop</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
<style>
    .product img{
        width: 100%;
        height: auto;
        box-sizing: border-box;
        object-fit: cover;
    }
    .pagination a {
        color:coral ;
    }
    .pagination li:hover a{
        color: white;
        background-color: coral;
    }
</style>

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

<!--Search--> 

<section id="search" class="my-5 py-5 ms-2"> 
    <div class="container mt-5 py-5"> 
        <p>Search Products</p> 
        <hr> 
    </div> 
    
        <form> 
            <div class="row mx-auto container"> 
                <div class="col-lg-12 col-md-12 col-sm-12"> 
                    <p>Category</p>
                    <div class="form-check"> 
                        <input class="form-check-input" type="radio" name="category" id="category_one"> 
                        <label class="form-check-label" for="flexRadioDefault1"> 
                            Shoes 
                        </label> 
                    </div>
                    <div class="form-check"> 
                        <input class="form-check-input" type="radio" name="category" id="category_two" checked> 
                        <label class="form-check-label" for="flexRadioDefault2"> 
                        Coats 
                        </label> 
                    </div>

                    <div class="form-check"> 
                        <input class="form-check-input" type="radio" name="category" id="category_two" checked> 
                        <label class="form-check-label" for="flexRadioDefault2"> 
                        Watches 
                        </label> 
                    </div>  

                    <div class="form-check"> 
                        <input class="form-check-input" type="radio" name="category" id="category_two" checked>
                        <label class="form-check-label" for="flexRadioDefault2"> 
                        Bags 
                        </label> 
                    </div> 
                </div> 
            </div> 
            
            <div class="row mx-auto container mt-5"> 
                <div class="col-lg-12 col-md-12 col-sm-12"> 

                <p>Price</py>
                <input type="range" class="form-range w-50" min="1" max="1000" id="customRange2"> 
                <div class="w-50"> 
                    <span style="float: left;">1</span> 
                    <span style="float:right;">1000</span> 
                </div> 
            </div> 
        </div> 

        <div class="form-group my-3 mx-3">
            <input type="submit" name="search" value="Search" class="btn btn-primary"> 
        </div> 
    <form> 
</section> 


<!--SHOP-->
<section id="featured" class="my-5 py-5">
    <div class="container text-center mt-5 py-5"> 
        <h3>Our Products</h3>
        <hr>
        <p>Here you can check out our  products</p>
    </div> 
    <div class="row mx-auto container">

    <?php while($row = $products->fetch_assoc()){?>

        <div onclick="window.location.href='single_product.html';" class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/images/<?php echo $row['product_image']?>"/>
            <div class="star">
                <i class="fas fa-star"></i> 
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i> 
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div> 
            <h5 class="p-name"><?php echo $row['product_name']?></h5> 
            <h4 class="p-price"><?php echo $row['product_price']?></h4>
            <button class="buy-btn"><a href="<?php echo "single_product.php?product_id=".$row['product_id']?>">Buy Now</button>
        </div>

        <?php }?>

        <nav aria-label="Page navigation example">
            <ul class="pagination mt-5"> 
                <li Class="page-item"><a class="page-link" href="#">Previous</a><li>
                <li Class="page-item"><a class="page-link" href="#">1</a><li>
                <li Class="page-item"><a class="page-link" href="#">2</a><li>
                <li Class="page-item"><a class="page-link" href="#">3</a><li>                
                <li Class="page-item"><a class="page-link" href="#">Next</a><li>

            </ul> 
        </nav>
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