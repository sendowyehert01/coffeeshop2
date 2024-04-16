<?php 

use Core\App;
use Core\Database;
$db = App::resolve('Core\Database');

$feedback = $db->query("SELECT * FROM tblfeedback JOIN tbluser ON id = customerid")->get();

view('testimonial.view.php', [
  'feedback' => $feedback,
]);