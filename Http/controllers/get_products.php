<?php 
use Core\App;
use Core\Database;
$db = App::resolve('Core\Database');

$sql = "SELECT product_name, product_description, price, image FROM tblproducts";

$result = $db->query($sql)->get();

$products = [];

foreach ($result as $product) {
    $products[] = $product;
}

// Return the product data as JSON
header('Content-Type: application/json');
echo json_encode($products);
exit();