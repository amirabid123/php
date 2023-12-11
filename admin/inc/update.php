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
$product_color = $_POST['product_color']; // Assuming there is a product code in your form

$host = "localhost";
$dbname = "php_project";
$username = "root";
$password = "";
$conn = new mysqli($host, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    die("Connection error: " . mysqli_connect_error());
} else {
    // Check if the product code already exists
    $checkSql = "SELECT * FROM products WHERE product_id = '$product_id'";
    $result = $conn->query($checkSql);

    if ($result->num_rows > 0) {
        // Product code already exists, update the record

        // Build the update query dynamically based on the fields that are filled
        $updateSql = "UPDATE products SET";

        if (!empty($product_name)) {
            $updateSql .= " product_name='$product_name',";
        }

        if (!empty($product_price)) {
            $updateSql .= " product_price='$product_price',";
        }

        if (!empty($product_description)) {
            $updateSql .= " product_description='$product_description',";
        }

        if (!empty($product_Image)) {
            $updateSql .= " product_Image='$product_Image',";
        }

        if (!empty($product_category)) {
            $updateSql .= " product_category='$product_category',";
        }
        if (!empty($product_Image2)) {
            $updateSql .= " product_image2='$product_Image2',";
        }
        if (!empty($product_Image3)) {
            $updateSql .= " product_image3='$product_Image3',";
        }
        if (!empty($product_Image2)) {
            $updateSql .= " product_image4='$product_Image4',";
        }
        if (!empty($product_special_offer)) {
            $updateSql .= " product_special_offer='$product_special_offer',";
        }
        if (!empty($product_color)) {
            $updateSql .= " product_color='$product_color',";
        }
        

        // Remove the trailing comma
        $updateSql = rtrim($updateSql, ',');

        $updateSql .= " WHERE product_id='$product_id'";

        if ($conn->query($updateSql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }

        // Wait for 2 seconds
        sleep(2);

        // Redirect to crudProduits.php
        header('Location: ../crudProduits.php');
        exit;
    }
}

$conn->close();
?>
