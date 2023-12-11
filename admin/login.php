<?php
session_start();

include('server/connection.php');

if (isset($_SESSION['admin_login_btn'])) {
    header('location: index.php');
    exit;
}

if (isset($_POST['login_btn'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Consider using bcrypt or Argon2 for secure password hashing.

    $stmt = $conn->prepare("SELECT admin_id, admin_name, admin_email,admin_password FROM admin WHERE admin_email = ? AND admin_password = ? LIMIT 1 ");

    $stmt->bind_param('ss', $email, $password);

    if ($stmt->execute()) {
        $stmt->bind_result($admin_id, $admin_name, $admin_email,$admin_password);

        if ($stmt->fetch()) {
            $_SESSION['admin_id'] = $user_id;
            $_SESSION['admin_name'] = $user_name;
            $_SESSION['admin_email'] = $user_email;
            $_SESSION['admin_logged_in'] = true;

            header('location: index.php'); // Redirect to the user's account page upon successful login.
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
        }

        .login-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>
        <form class="login-form" action="login.php" method="POST">
            <input type="text" name="email" placeholder="email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>
