<?php 

use Core\App;
use Core\Database;
use Core\Validator;
use Core\Authenticator;

$db = App::resolve('Core\Database');

$customer_name = $_POST['customer_name'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

$errors = [];

  if (! Validator::email($email)) {
    $errors['email'] = "Please provide a valid email.";
  }

  if (! Validator::string($password, 7 , 255)) {
    $errors['password'] = "Please provide a password of atleast 7 characters.";
  }

  if (! empty($errors)) {
    return view('registration/create.view.php', [
      'heading' => 'Register',
      'errors' => $errors,
    ]);
  }

  $user = $db->query("SELECT * FROM tbluser where email = :email", ['email' => $email])->find();


if ($user) {
  header('location: /');
  die();
  
} else {

  $db->query("INSERT INTO tbluser(customer_name, email, username, password) VALUES(:customer_name, :email, :username, :password)", [
    'customer_name'=> $customer_name,
    'email'=> $email,
    'username'=> $username,
    'password' => password_hash($password, PASSWORD_BCRYPT),
  ]);

  Authenticator::login($user);

  header('location: /register');
  die();
}

?>