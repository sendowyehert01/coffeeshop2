<?php 

use Core\App;
use Core\Database;
use Core\Validator;
$db = App::resolve('Core\Database');

$errors = [];

  // if (! Validator::checkbox($_POST['category'])) {
  //   $errors['body'] = "Category is required";
  // }

  // if (! Validator::string($_POST['feedback_desc'], 1 , 50)) {
  //   $errors['body'] = "A body of no more than 50 characters is required.";
  // }

  // if (! empty($errors)) {
  //   return view('menu.view.php', [
  //     'errors' => $errors,
  //   ]);
  // }

  // dd($_POST);

  if (empty($errors)) {
      $db->query("INSERT INTO tblorders(order_type, customer_id) VALUES(:order_type, :customer_id)", ['order_type'=> $_POST['order_type'],'customer_id' => $_SESSION['user']['id']]);
  }

  header('location: /menu');
  die();
