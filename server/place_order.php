<?php
session_start();
include('connection.php');

if(!isset($_SESSION['logged_in'])){ 
    header (' location: ../checkout.php?message=Please login/register to place an order'); 
    exit;
    }else{

            if(isset($_POST['place_order'])){

                //get user info and store it in database
                $name = $_POST['name'];
                $email = $_POST['email'];
                $phone = $_POST['phone']; 
                $city = $_POST['city']; 
                $adress = $_POST['adress'];
                $order_cost = $_SESSION['total'];
                $order_status = "not paid";
                $user_id = $_SESSION['user_id'];
                $order_date = date('Y-m-d H:i;s'); 
                $stmt = $conn->prepare("INSERT INTO orders(order_cost, order_status, user_id, user_phone, user_city, user_address, order_date)
                            VALUES(?,?,?,?,?,?,?);");
                $stmt->bind_param('isissss', $order_cost, $order_status, $user_id, $phone, $city, $adress, $order_date);
                $stmt_status = $stmt->execute();
                if (!$stmt_status){ 
                    header ('location: index.php'); 
                    exit; 
                }


                //get products from cart(from session)
                foreach($_SESSION['cart'] as $key => $value){
                    $product = $_SESSION['cart'][$key]; 
                    $product_id = $product['product_id'];
                    $product_name = $product['product_name'];
                    $product_image = $product['product_image'];
                    $product_price = $product['product_price'];
                    $product_quantity = $product['product_quantity'];

                    $stmt1 = $conn->prepare("INSERT INTO order_items(order_id, product_id, product_name, product_image, product_price, product_quantity, order_date)
                                    VALUES(?,?,?,?,?,?,?)");
                    $stmt1->bind_param('iissiii', $order_id, $product_id, $product_name, $product_image, $product_price, $product_quantity, $order_date);
                    $stmt1->execute();                

                }
                //issue new order and store order info in database
                $order_id = $stmt->insert_id;
                //store each single item in order_items database

                //remove everything from the cart
                //unset($_SESSION['cart']);

                // inform user wether everything is fine or there is a problem
                header('location: ../payment.php?order_status="order placed successfull"');


            }else{}





    }




?>