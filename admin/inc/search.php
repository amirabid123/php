<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=php_project", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['searchTerm'])) {
        $searchTerm = '%' . $_POST['searchTerm'] . '%';

        $stmt = $conn->prepare("SELECT * FROM products WHERE product_name LIKE :searchTerm");
        $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($result);
    } else {
        // If no search term is provided, fetch all products
        $stmt = $conn->query("SELECT * FROM products");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($result);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
