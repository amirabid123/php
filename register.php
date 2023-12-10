<?php
session_start();
include('server/connection.php');

   // if user has already registered, then take user to account page
 if(isset($_SESSION['logged_in'])){
    header('location:account.php');
    exit;
}

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Adjusted to match the form field name
    $confirmPassword = $_POST['confirmpassword']; // Adjusted variable name

    // If passwords don't match
    if ($password !== $confirmPassword) {
        header('location: register.php?error=passwords dont match');
    }
    // If password is less than 6 characters
    else if (strlen($password) < 6) {
        header('location: register.php?error=password must be at least 6 characters');
    } else {
        // Check whether there is a user with this email or not
        $stmt = $conn->prepare("SELECT count(*) FROM userss WHERE user_email=?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($num_rows);
        $stmt->store_result();
        $stmt->fetch();

        // If there is a user already registered with this email
        if ($num_rows != 0) {
            header('location: register.php?error=user with this email already exists');
        } else {
            // Create a new user
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO userss(user_name, user_email, user_password) VALUES(?,?,?)");
            $stmt->bind_param('sss', $name, $email, md5($password),); // Use hashed password
            if ($stmt->execute()) {
                $user_id = $stmt->insert_id;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $name;
                $_SESSION['logged_in'] = true;
                header('location: account.php?register_success=You registered successfully');
            } else {
                header('location: register.php?error=could not create an account at the moment');
            }
        }
    }
}
 
?>




<!DOCTYPE html> 
<html lang="en"> 
<head>
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Register</title> 
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
                    <a href="account.php"><i class="fas fa-user"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>



<!--Register-->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="forn-weight-bold">Register</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container">
        <form id="register-form" method="POST" action="register.php">
            <p style="color: red;"><?php if(isset($_GET['error'])){echo $_GET['error'];}?></p>
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" id="register-name" name="name" placeholder="Name" required/>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" id="register-email" name="email" placeholder="Email" required/>
            </div>
            <div class="form-group">
                <label>Password</label>
                    <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required/>
                    <button type="button" class="btn btn-outline-secondary" id="toggle-password">
                        <i class="fas fa-eye" id="eye-icon"></i>
                    </button>
                
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" class="form-control" id="register-confirm-password" name="confirmpassword" placeholder="Confirm Password" required/>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" id="register-btn" name="register" value="Register"/>
            </div>
            <div class="form-group">
                <a id="login-url" class="btn" href="login.php">Already have an account? Login</a>
            </div>
        </form>
    </div>
</section>

<script>
    var passwordInput = document.getElementById('register-password');
    var eyeIcon = document.getElementById('eye-icon');
    document.getElementById('toggle-password').addEventListener('click', function () {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });
</script>





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