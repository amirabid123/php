<?php
    include('layouts/header.php')
?>
     <!--Home-->
    <section id="home"> 
        <div class="container">
        <h1>NEW ARRIVALS</h1> <!-- Fix here: Change <hS> to <h1> -->
        <h1><span>Best Prices</span>This Season</h1>
        <p>Eshop offers the best products for the most affordable prices</p>
        <button>Shop Now</button>      
        </div>
    </section>


    <!-- Brand -->
    <section id="brand" class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <img class="img-fluid" src="assets/images/brand1.jpg" alt="Brand 1">
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <img class="img-fluid" src="assets/images/brand2.jpg" alt="Brand 2">
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <img class="img-fluid" src="assets/images/brand3.jpg" alt="Brand 3">
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <img class="img-fluid" src="assets/images/brand4.jpg" alt="Brand 4">
            </div>
        </div>
    </section>


    <!--New--> 
    <section id="new" class="w-100"> 
        <div class="row p-0 m-0">
            <!--ONE-->    
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0"> <!-- Fix: Change col-1g-4 to col-lg-4 -->
                <img class="img-fluid" src="assets/images/1.jpg"/> 
                <div class="details"> 
                    <h2>Extremely Awesome Shoes</h2> 
                    <button class="text-uppercase">Shop Now</button> 
                </div> 
            </div> 
            <!--TWO-->
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0"> <!-- Fix: Change col-1g-4 to col-lg-4 -->
                <img class="img-fluid" src="assets/images/2.jpg"/> 
                <div class="details"> 
                    <h2>Extremely Awesome Jacket</h2> 
                    <button class="text-uppercase">Shop Now</button> 
                </div> 
            </div> 
            <!--THREE-->
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0"> <!-- Fix: Change col-1g-4 to col-lg-4 -->
                <img class="img-fluid" src="assets/images/3.jpg"/> 
                <div class="details"> 
                    <h2>50% OFF Watches</h2> 
                    <button class="text-uppercase">Shop Now</button> 
                </div> 
            </div> 
        </div>
    </section>


    <!--Featured-->
    <section id="featured" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5"> 
            <h3>Our Featured</h3>
            <hr>
            <p>Here you can check out our featured productst</p>
        </div> 
        <div class="row mx-auto container-fluid">
        <?php include('server/get_featured_products.php');?>
        <?php while($row= $featured_products->fetch_assoc()){?>
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/images/<?php echo $row['product_image'];?>"/>
                <div class="star">
                    <i class="fas fa-star"></i> 
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i> 
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div> 
                <h5 class="p-name"><?php echo $row['product_name'];?></h5> 
                <h4 class="p-price"><?php echo $row['product_price'];?></h4>
                <a href="single_product.php?product_id=<?php echo $row['product_id'];?>"><button class="buy-btn">Buy Now</button></a>
            </div>
            <?php } ?>
        </div>
    </section> 

    <!--Banner-->
    <section id="banner" class="my=5 py-5">
        <div class="container">
            <h4>MID SEASON'S SALE</h4> 
            <h1>Autumn Collection <br> UP to 30% OFF</h1> 
            <button class="text-uppercase">shop now</button>
        </div>
    </section> 

    <!--CLOTHES-->
    <section id="featured" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5"> 
            <h3>Dresses & Coats</h3>
            <hr>
            <p>Here you can check out our amazing clothes</p>
        </div> 
        <div class="row mx-auto container-fluid">
        <?php include('server/get_coats.php');?>
        <?php while($row= $coats_products->fetch_assoc()){?>
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/images/<?php echo $row['product_image'];?>"/>
                <div class="star">
                    <i class="fas fa-star"></i> 
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i> 
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div> 
                <h5 class="p-name"><?php echo $row['product_name'];?></h5> 
                <h4 class="p-price"><?php echo $row['product_price'];?></h4>
                <button class="buy-btn">Buy Now</button>
            </div>
            <?php } ?>
        </div>
    </section> 


    <!--CLOTHES-->
    <section id="featured" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5"> 
            <h3>Shoes</h3>
            <hr>
            <p>Here you can check out our amazing Shoes</p>
        </div> 
        <div class="row mx-auto container-fluid">
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/images/shoes1.jpg"/>
                <div class="star">
                    <i class="fas fa-star"></i> 
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i> 
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div> 
                <h5 class="p-name">Sports Shoes</h5> 
                <h4 class="p-price">$199.8</h4>
                <button class="buy-btn">Buy Now</button>
            </div>
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/images/shoes2.jpg"/>
                <div class="star">
                    <i class="fas fa-star"></i> 
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i> 
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div> 
                <h5 class="p-name">Sports Shoes</h5> 
                <h4 class="p-price">$150.0</h4>
                <button class="buy-btn">Buy Now</button>
            </div>
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/images/shoes3.jpg"/>
                <div class="star">
                    <i class="fas fa-star"></i> 
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i> 
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div> 
                <h5 class="p-name">Sports Shoes</h5> 
                <h4 class="p-price">$199.9</h4>
                <button class="buy-btn">Buy Now</button>
            </div>

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


<?php
    include('layouts/footer.php')
?>
