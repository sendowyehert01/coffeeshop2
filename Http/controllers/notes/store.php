<?php 

use Core\Database;
use Core\Validator;

require base_path('Core/Validator.php');

$config = require(base_path("config.php"));
$db = new Core\Database($config['database'], $config['account']['username'], $config['account']['password']);

$errors = [];

  if (! Validator::string($_POST['body'], 1 , 50)) {
    $errors['body'] = "A body of no more than 50 characters is required.";
  }

  if (! empty($errors)) {
    return view('notes/create.view.php', [
      'heading' => 'Create Notes',
      'errors' => $errors,
    ]);
  }

  if (empty($errors)) {
    $db->query("INSERT INTO notes(body, user_id) VALUES(:body, :user_id)", ['body'=> $_POST['body'],'user_id' => 2]);
  }

  header('location: /notes');
  die();

?>