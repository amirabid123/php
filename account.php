<?php
session_start();

include('server/connection.php');


// Check if user is not logged in, redirect to login.php
if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

if (isset($_SESSION['login_btn'])) {
    header('location: account.php');
    exit;
}

if (isset($_GET['logout'])) {
    if (isset($_SESSION['logged_in'])) {
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        header('location: login.php');
        exit;
    }
}

if (isset($_POST['change_password'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmpassword'];

    if ($password !== $confirm_password) {
        header('location: account.php?error=passwords dont match');
    } else if (strlen($password) < 6) {
        header('location: account.php?error=password must be at least 6 characters');
    } else {
        $stmt = $conn->prepare("UPDATE userss SET user_password = ? WHERE user_email = ?");
        $stmt->bind_param('ss', md5($password), $_SESSION['user_email']);
        
        if ($stmt->execute()) {
            header('location: account.php?message=password has been updated successfully');
        } else {
            header('location: account.php?error=could not update password');
        }
    }
}



// get orders
if (isset($_SESSION['logged_in'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=? ");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();

    // Check if the query execution was successful
    if ($stmt->error) {
        header('location: account.php?error=' . urlencode($stmt->error));
        exit;
    }

    $orders = $stmt->get_result();
}
?>



<?php
    include('layouts/header.php')
?>

<!--Account-->
<t-—Account—>
<section class="my-5 py-5">
    <div class="row container mx-auto">
        <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
        <p class="text-center" style="color:green"><?php if(isset($_GET['register_success'])){echo $_GET['register_success'];}?></p>    
        <h3 class=" font-weight-bold">Account info</h3>
            <hr class=mx-auto”>
            <div classs="account-info">  
                <p>Name: <span><?php if(isset($_SESSION['user_name'])) {echo $_SESSION['user_name'];}?></span></p>
                <p>Email: <span><?php if(isset($_SESSION['user_email'])) {echo $_SESSION['user_email'];}?></span></p>
                <p><a href="#orders" id="orders-btn">Your orders</a></p>
                <p><a href="account.php?logout=1" id="logout-btn">Logout</a></p>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <form id="account-form" method="POST" action="account.php"> 
            <p class="text-center" style="color:red"><?php if(isset($_GET['error'])){echo $_GET['error'];}?></p>
            <p class="text-center" style="color:green"><?php if(isset($_GET['message'])){echo $_GET['message'];}?></p>   
   
            <h3>Change Password</h3> 
                <hr class="mx-auto"> 
                <div class="form-group"> 
                    <label>Password</label> 
                    <input type="password" class="form-control" id="account-password" name="password" placeholder="password" required/>
                </div> 
                <div class="form-group"> 
                    <label>confirm Password</label> 
                    <input type="password" class="form-control" id="account-password-confirm" name="confirmpassword" placeholder="password" required/>
                </div>
                <div class="form-group"> 
                    <input type="submit" value="Change Password" name="change_password" class="btn" id="change-pass-btn">
                </div>    
            </form>    
        </div>
</section>

<!--Orders-->
<section id="orders" class="orders container my-5 py-3">
    <div class="container mt-2">
        <h2 class="font-weight-bolde text-center">Your Orders</h2>
        <hr class="mx-auto">
    </div>
    <table class="mt-5 pt-5 text-center" >
        <tr>
            <th class>Order ID</th>
            <th>Order Cost</th>
            <th>Order Status</th>
            <th>Order Date</th>
            <th>Order details</th>

        </tr>
        <?php while($row = $orders->fetch_assoc()){?>
            <tr>
                <td>
                    <span><?php echo $row['order_id'];?></span>
                </td>
                <td class="order-date">
                    <span><?php echo $row['order_cost'];?></span>
                </td>
                <td class="order-date">
                    <span><?php echo $row['order_status'];?></span>
                </td>
                <td class="order-date">
                    <span><?php echo $row['order_date'];?></span>
                </td>
                <td>
                <form method="POST" action="order_details.php">
                    <input type="hidden" value="<?php echo $row['order_status'];?>" name="order_status"/>
                    <input type="hidden" value="<?php echo $row['order_id'];?>" name="order_id"/>
                    <input class="btn order-details-btn" name="order_details_btn" type="submit" value="details"/>
                </form>
                </td>
            </tr>
        <?php }?>
    </table>
</section>


<?php
    include('layouts/footer.php')
?>
