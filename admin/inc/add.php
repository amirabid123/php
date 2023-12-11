<?php
$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];
$product_description = $_POST['product_description'];
$product_Image = $_POST['product_Image'];
$product_Image2 = $_POST['product_Image2'];
$product_Image3 = $_POST['product_Image3'];
$product_Image4 = $_POST['product_Image4']; // Fixed variable name
$product_category = $_POST['product_category'];
$product_special_offer = $_POST['product_special_offer']; // Fixed variable name
$product_color = $_POST['product_color'];

// Check if any of the form fields are empty
if (empty($product_name) || empty($product_price) || empty($product_Image) || empty($product_category)) {
    echo "Error: All fields must be filled.";
    exit;
}

$host = "localhost";
$dbname = "php_project";
$username = "root";
$password = "";

// Create a mysqli connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

// Use prepared statements to prevent SQL injection
$sql = "INSERT INTO products (product_name, product_category, product_description, product_image, product_image2, product_image3, product_image4, product_price, product_special_offer, product_color)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("ssssssssss", $product_name, $product_category, $product_description, $product_Image, $product_Image2, $product_Image3, $product_Image4, $product_price, $product_special_offer, $product_color);

// Execute the statement
if ($stmt->execute()) {
    echo "New record is inserted successfully";

    // Wait for 2 seconds
    sleep(2);

    // Redirect to crudProduits.php
    header('Location: ../crudProduits.php');
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>

