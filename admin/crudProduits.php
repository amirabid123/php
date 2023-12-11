<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['admin_email'])) {
    // If not logged in, redirect to the login page
    header('Location: inc/login.php');
    exit;
}

// Get the logged-in username
$username = $_SESSION['admin_email'];

if (isset($_GET['logout'])) {
    // Logout the user by destroying the session
    session_destroy();
    header('Location: inc/login.php');
    exit;
}

// Database connection
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "php_project";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username_db, $password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to retrieve products
    $stmt = $conn->query("SELECT * FROM products");
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    // Fetch the results into an associative array
    $_produits = $stmt->fetchAll();

    // Handle product deletion
    if (isset($_GET['delete'])) {
        $productIDToDelete = $_GET['delete'];

        try {
            // Perform the deletion from the database
            $stmt = $conn->prepare("DELETE FROM products WHERE product_id = :product_id");
            $stmt->bindParam(':product_id', $productIDToDelete);
            $stmt->execute();

            // Output a success message to be used by AJAX response
            echo "success";
            exit();
        } catch (PDOException $e) {
            // Output an error message to be used by AJAX response
            echo "Error deleting product: " . $e->getMessage();
            exit();
        }
    }
} catch (PDOException $e) {
    // Output an error message for database connection failure
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
<head>
    <!-- Include your header content here -->
</head>
<body>
    <div class="navbar">
        <a href="#" style="float: right;"><i class="fa fa-fw fa-user"></i> Logged in as <?php echo $username; ?></a>
        <a href="?logout=1" style="float: right;">Logout</a> <!-- Add a Logout link -->
    </div>
    
    <main>
        <?php include('inc/tableau.php'); ?>
    </main>
 
    <?php include('inc/footer.php'); ?>
</body>
</html>
