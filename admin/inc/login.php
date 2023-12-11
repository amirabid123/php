<?php
// Establish a database connection
$servername = ""; // Update with your actual database server name
$username = "root";
$password = "";
$dbname = "php_project";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Execute an SQL query to retrieve user data
$sql = "SELECT * FROM  admin";
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    // Fetch the result as an associative array
    $_admins = $result->fetch_all(MYSQLI_ASSOC);

    // Use var_dump to understand the structure of the retrieved data
    // var_dump($_users);  // Commented out this line
} else {
    echo "Error retrieving user data: " . $conn->error;
}

// Close the database connection
$conn->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_email = $_POST['admin_email'];
    $admin_password = $_POST['password'];

    // Check if the entered username exists and the password is correct
    $adminFound = false;
    foreach ($_admins as $admin) {
        if ($admin['admin_email'] === $admin_email && $admin['admin_password'] === $admin_password) {
            $adminFound = true;
            break;
        }
    }

    if ($adminFound) {
        session_start();

         // Check if "Remember Me" is checked
        if (isset($_POST['remember_me'])) {
            // Set cookies to remember the username and password
            setcookie('remember_email', $admin_email, time() + 60 * 60 * 24 * 30); // Remember for 30 days
            setcookie('remember_password', $admin_password, time() + 60 * 60 * 24 * 30); // Remember for 30 days
        } else {
            // If "Remember Me" is not checked, delete the cookies
            setcookie('remember_email', '', time() - 3600);
            setcookie('remember_password', '', time() - 3600);
        }

        $_SESSION['admin_email'] = $admin_email; // Store the username in the session
        header('Location: ../crudProduits.php');
        exit;
    } else {
        $error = "Invalid username or password. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-bottom: 8px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: #ff0000;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)) : ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <label for="admin_email">Email:</label>
            <input type="text" id="admin_email" name="admin_email" required value="<?php echo isset($_COOKIE['remember_email']) ? $_COOKIE['remember_email'] : ''; ?>">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required value="<?php echo isset($_COOKIE['remember_password']) ? $_COOKIE['remember_password'] : ''; ?>">

            <label for="remember_me">
                <input type="checkbox" id="remember_me" name="remember_me"> Remember Me
            </label>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
