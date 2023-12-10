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




<?php
    include('layouts/header.php')
?>



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




<?php
    include('layouts/footer.php')
?>
