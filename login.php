<?php
session_start();

include('server/connection.php');

if (isset($_SESSION['login_btn'])) {
    header('location: account.php');
    exit;
}

if (isset($_POST['login_btn'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Consider using bcrypt or Argon2 for secure password hashing.

    $stmt = $conn->prepare("SELECT user_id, user_name, user_email FROM userss WHERE user_email = ? AND user_password = ? LIMIT 1 ");

    $stmt->bind_param('ss', $email, $password);

    if ($stmt->execute()) {
        $stmt->bind_result($user_id, $user_name, $user_email);

        if ($stmt->fetch()) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            $_SESSION['user_email'] = $user_email;
            $_SESSION['logged_in'] = true;

            header('location: account.php'); // Redirect to the user's account page upon successful login.
            exit;
        } else {
            $_SESSION['error'] = 'Could not verify your account';
        }
    } else {
        // Check for SQL errors.
        $_SESSION['error'] = 'Something went wrong :/';
    }

    header('location: login.php'); // Redirect back to the login page.
    exit;
}
?>

<!DOCTYPE html> 
<html lang="en"> 
<head>
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Login</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/style.css"/>

</head> 
<body> 

<?php
    include('layouts/header.php')
?>

<!--Login-->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="font-weight-bold">Login</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container">
    <form id="login-form" method="POST" action="">
            <p style="color:red" class="text-center"><?php if(isset($_GET['error'])){ echo $_GET['error'];}?></p>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" id="login-email" name="email" placeholder="Email" required/>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required/>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login"/>
            </div>
            <div class="form-group">
                <a id="register-url" class="btn" href="register.php">Don't have an account? Register</a>
            </div>
        </form>
    </div>
</section>




<?php
    include('layouts/footer.php')
?>
