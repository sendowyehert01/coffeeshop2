<?php

use Core\App;
use Core\Database;
$db = App::resolve('Core\Database');

$products = $db->query("SELECT product_id, 
                                product_name,
                                product_description, 
                                price, 
                                CONCAT(UCASE(SUBSTRING(category, 1, 1)), LOWER(SUBSTRING(category, 2))) AS category, 
                                image 
                                FROM tblproducts
                                ")->get();

// $_SESSION['user'] = [
//     'id' => $user['id'],
//     'email' => $user['email'],
//     'role' => $user['role'],
//   ];

view('menu.view.php', [
    'products' => $products
]);