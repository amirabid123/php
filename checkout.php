<?php
session_start(); 
if( !empty($_SESSION['cart'])  ){ 
//let user in 
//send user to home page 
}else {
header('location:index.php' );
}
?>


<?php
    include('layouts/header.php')
?>










    <!--checkout-->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="forn-weight-bold">Check Out</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container">
        <form id="checkout-form" method="POST" action="server/place_order.php">
            <p class="text-center" style="color: red"><?php if(isset($_GET['message'])){echo $_GET['message'];}?></p>
            <?php if(isset($_GET['message'])){?>
                <a href="login.php" class="btn btn-primary">Login</a>
                <?php }?>
                
            <div class="form-group checkout-small-elemnt">
                <label>Name</label>
                <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Name" required/>
            </div>
            <div class="form-group checkout-small-elemnt">
                <label>Email</label>
                <input type="text" class="form-control" id="checkout-email" name="email" placeholder="Email" required/>
            </div>
            <div class="form-group checkout-small-elemnt">
                <label>Phone</label>
                <input type="text" class="form-control" id="checkout-phone" name="phone" placeholder="Phone" required/>
            </div>
            <div class="form-group checkout-small-elemnt">
                <label>City</label>
                <input type="text" class="form-control" id="checkout-city" name="city" placeholder="city" required/>
            </div>
            <div class="form-group checkout-small-elemnt">
                <label>Adress</label>
                <input type="text" class="form-control" id="checkout-adress" name="adress" placeholder="adress" required/>
            </div>
            <div class="form-group checkout-small-elemnt">
                <p>Total amount: $<?php echo isset($_SESSION['total']) ? $_SESSION['total'] : 0; ?></p>
                <input type="submit" class="btn" id="checkout-btn" name="place_order" value="Place Order"/>
            </div>
            
        </form>

</section>



<?php
    include('layouts/footer.php')
?>
