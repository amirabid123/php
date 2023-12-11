<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dynamic Table</title>
    <!-- Include your CSS and JavaScript libraries here -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Manage <b>Products</b></h2>
                        </div>
                        <div class="col-sm-6">
                            <button id="addProductButton" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Add Product</span></button>
                            <button id="updateProductButton" class="btn btn-success"><i class="material-icons">&#xE157;</i> <span>update Product</span></button>
                            <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="searchInput">Search by Product Name:</label>
                            <input type="text" class="form-control" id="searchInput" placeholder="Enter product name">
                        </div>
                    </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="selectAll">
                                    <label for="selectAll"></label>
                                </span>
                            </th>
                            <th>#</th>
                            <th>Name </th>
                            <th>Category</th>
                            <th>Description </th>
                            <th>Price </th>
                            <th>Special offer </th>
                            <th>Color</th>
                            <th>Images</th>
                            <th>Actions </th>

                        </tr>
                    </thead>
                    <tbody>
<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=php_project", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT * FROM products");
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach ($stmt->fetchAll() as $product) {
        echo '<tr>';
        echo '<td>
                <span class="custom-checkbox">
                    <input type="checkbox" id="checkbox1" name="options[]" value="1">
                    <label for="checkbox1"></label>
                </span>
            </td>';
            echo '<td>' . $product["product_id"] . '</td>';
            echo '<td>' . $product["product_name"] . '</td>';
            echo '<td>' . $product["product_category"] . '</td>';
            echo '<td>' . $product["product_description"] . '</td>';
            echo '<td>' . $product["product_price"] . '</td>';
            echo '<td>' . $product["product_special_offer"] . '</td>';
            echo '<td>' . $product["product_color"] . '</td>';

        // Concatenate the base path with the file name
        $imagePath = '../assets/images/' . $product["product_image"];
        echo '<td><img src="' . $imagePath . '" alt="Product Image" style="width:50px;height:50px;"></td>';
        echo '<td>
                <a href="#" class="delete" data-code="' . $product["product_id"] . '"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
            </td>';
        echo '</tr>';
        
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
                    </tbody>
                </table>
            <div class="clearfix">
                <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                <ul class="pagination">
                    <li class="page-item disabled"><a href="#">Previous</a></li>
                    <li class="page-item"><a href="#" class="page-link">1</a></li>
                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                    <li class="page-item active"><a href="#" class="page-link">3</a></li>
                    <li class="page-item"><a href="#" class="page-link">4</a></li>
                    <li class="page-item"><a href="#" class="page-link">5</a></li>
                    <li class="page-item"><a href="#" class="page-link">Next</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div id="addProductModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
            <form  action="inc/add.php" method="post">
    <div class="modal-header">
        <h4 class="modal-title">Add New Product</h4>
    </div>
    <div class="modal-body">
    <div class="form-group">
            <label for="product_id">Product code</label>
            <input type="text" class="form-control" id="product_id" name="product_id" >
        </div>
        <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" required>
        </div>
        <div class="form-group">
            <label for="product_category">Category</label>
            <input type="text" class="form-control" id="product_category" name="product_category" required>
        </div>
        <div class="form-group">
            <label for="product_price">Price</label>
            <input type="number" class="form-control" id="product_price" name="product_price" required>
        </div>
        <div class="form-group">
            <label for="product_description">Description</label>
            <input type="text" class="form-control" id="product_description" name="product_description" required>
        </div>
        <div class="form-group">
            <label for="product_special_offer">special offer</label>
            <input type="text" class="form-control" id="product_special_offer" name="product_special_offer" required>
        </div>
        <div class="form-group">
            <label for="product_color">color</label>
            <input type="text" class="form-control" id="product_color" name="product_color" required>
        </div>
        <div class="form-group">
                        <label for="product_Image">Image</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    Browse&hellip; <input type="file" name="product_Image" accept="image/*">
                                </span>
                            </span>
                        </div>
        </div>
        
        <div class="form-group">
                        <label for="product_Image2">Image2</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    Browse&hellip; <input type="file" name="product_Image2" accept="image/*">
                                </span>
                            </span>
                        </div>
        </div>
        <div class="form-group">
                        <label for="product_Image3">Image3</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    Browse&hellip; <input type="file" name="product_Image3" accept="image/*">
                                </span>
                            </span>
                        </div>
        </div>
        <div class="form-group">
                        <label for="product_Image4">Image4</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    Browse&hellip; <input type="file" name="product_Image4" accept="image/*">
                                </span>
                            </span>
                        </div>
        </div>
        
    </div>
    <input type="hidden" name="addProduct" value="1">
    <div class="modal-footer">
        <input type="submit" class="btn btn-default" data-dismiss="modal" value="Cancel">
        <input type="submit"  value="Add Product">
    </div>
</form>
</div>
    </div>
</div>
<div id="updateProductModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="inc/update.php" method="post">
    <div class="modal-header">
        <h4 class="modal-title">Update Product</h4>
    </div>
    <div class="modal-body">
    <div class="form-group">
            <label for="product_id">Product code</label>
            <input type="text" class="form-control" id="product_id" name="product_id"required >
        </div>
    <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" >
        </div>
        <div class="form-group">
            <label for="product_category">Category</label>
            <input type="text" class="form-control" id="product_category" name="product_category" >
        </div>
        <div class="form-group">
            <label for="product_price">Price</label>
            <input type="number" class="form-control" id="product_price" name="product_price" >
        </div>
        <div class="form-group">
            <label for="product_description">Description</label>
            <input type="text" class="form-control" id="product_description" name="product_description" >
        </div>
        <div class="form-group">
            <label for="product_special_offer">special offer</label>
            <input type="text" class="form-control" id="product_special_offer" name="product_special_offer" >
        </div>
        <div class="form-group">
            <label for="product_color">color</label>
            <input type="text" class="form-control" id="product_color" name="product_color" >
        </div>
        <div class="form-group">
                        <label for="product_Image">Image</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    Browse&hellip; <input type="file" name="product_Image" accept="image/*">
                                </span>
                            </span>
                        </div>
        </div>
        
        <div class="form-group">
                        <label for="product_Image2">Image2</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    Browse&hellip; <input type="file" name="product_Image2" accept="image/*">
                                </span>
                            </span>
                        </div>
        </div>
        <div class="form-group">
                        <label for="product_Image3">Image3</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    Browse&hellip; <input type="file" name="product_Image3" accept="image/*">
                                </span>
                            </span>
                        </div>
        </div>
        <div class="form-group">
                        <label for="product_Image4">Image4</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    Browse&hellip; <input type="file" name="product_Image4" accept="image/*">
                                </span>
                            </span>
                        </div>
        </div>
    <input type="hidden" name="updateProduct" value="1">
    <div class="modal-footer">
                    <input type="submit" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" value="Update Product">
                </div>
            </form>
        </div>
    </div>
</div>

<div id="deleteProductModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-body">
                    <p>Are you sure you want to delete this product?</p>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-success" id="submitProductButton" name="submitProductButton" value="Add Product">
                 </div>  
            </form>
        </div>
    </div>
</div>



<!-- Your existing script tags -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            // Handle "Delete" click
            $(".delete").click(function() {
                // Get the product code from the data-code attribute
                var productCode = $(this).data("code");

                // Perform AJAX request to delete the product
                $.ajax({
                    url: "crudProduits.php",
                    type: "GET",
                    data: { delete: productCode },
                    success: function(response) {
                        // Check the server response
                        if (response === "success") {
                            // Show a success message using SweetAlert2 (you can customize this part)
                            Swal.fire({
                                icon: 'success',
                                title: 'Product deleted successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            // Reload the page after successful deletion
                            location.reload();
                        } else {
                            // Show an error message using SweetAlert2
                            Swal.fire({
                                icon: 'error',
                                title: 'Error deleting product',
                                text: response
                            });
                        }
                    },
                    error: function(error) {
                        console.error("Error deleting product: ", error);

                        // Show an error message using SweetAlert2
                        Swal.fire({
                            icon: 'error',
                            title: 'Error deleting product',
                            text: 'An error occurred while deleting the product.'
                        });
                    }
                });
            });
  // Handle keyup event in the search input
  $('#searchInput').on('keyup', function () {
        var searchTerm = $(this).val().trim();

        // Perform an Ajax request to search.php only if there's a search term
        if (searchTerm !== '') {
            $.ajax({
                url: 'inc/search.php',
                type: 'POST',
                data: { searchTerm: searchTerm },
                success: function (response) {
                    // Parse the JSON response
                    var products = JSON.parse(response);

                    // Clear the table body
                    $('table tbody').empty();

                    // Add the searched products to the table
                    for (var i = 0; i < products.length; i++) {
                        addProductToTable(products[i]);
                    }
                },
                error: function (error) {
                    // Debugging statement for AJAX error
                    console.error("Error searching products: ", error);
                }
            });
        } else {
            // If no search term, fetch all products and add them to the table
            $.ajax({
                url: 'inc/search.php',
                type: 'POST',
                success: function (response) {
                    // Parse the JSON response
                    var products = JSON.parse(response);

                    // Clear the table body
                    $('table tbody').empty();

                    // Add all products to the table
                    for (var i = 0; i < products.length; i++) {
                        addProductToTable(products[i]);
                    }
                },
                error: function (error) {
                    // Debugging statement for AJAX error
                    console.error("Error fetching all products: ", error);
                }
            });
        }
    });

            // Show the modal for the new product form
            $("#addProductButton").click(function () {
                $("#addProductModal").modal("show");
            });

            // Close the modal when the "Add New Product" button in the modal is clicked
            $("#closeAddProductModal").click(function () {
                $("#addProductModal").modal("hide");
            });

            // Handle the form submission
            $("#submitProductButton").click(function () {
                // ...

                // Close the modal after successful addition
                $("#addProductModal").modal("hide");
            });

            // Show the modal for updating a product
            $("#updateProductButton").click(function () {
                // Populate the update modal with data if needed

                // Show the modal for updating the product
                $("#updateProductModal").modal("show");
            });

            // Close the modal when the "Cancel" button in the update modal is clicked
            $("#closeupdateProductModal").click(function () {
                $("#updateProductModal").modal("hide");
            });

            // Handle the form submission for updating the product
            $("#submitupdateProductButton").click(function () {
                // ...

                // Close the modal after successful update
                $("#updateProductModal").modal("hide");
            });

             // Function to add a new product to the table
        function addProductToTable(product) {
            var newRow =
                '<tr>' +
                '<td>' +
                '<span class="custom-checkbox">' +
                '<input type="checkbox" id="checkbox1" name="options[]" value="1">' +
                '<label for="checkbox1"></label>' +
                '</span>' +
                '</td>' +
                '<td>' + product.product_id + '</td>' +
                '<td>' + product.product_name + '</td>' +
                '<td>' + product.product_category + '</td>' +
                '<td>' + product.product_description + '</td>' +
                '<td>' + product.product_price + '</td>' +
                '<td>' + product.product_special_offer + '</td>' +
                '<td>' + product.product_color + '</td>' +
                '<td><img src="../assets/images/' + product.product_image + '" alt="Product Image" style="width:50px;height:50px;"></td>' +
                '<td>' +
                '<a href="#" class="delete" data-code="' + product.product_id + '"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>' +
                '</td>' +
                '</tr>';

            // Append the new row to the table
            $('table tbody').append(newRow);
        }
        });
    </script>
</body>
</html>