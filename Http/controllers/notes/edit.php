<?php 

use Core\App;
use Core\Database;
use Core\Response;

$db = App::resolve('Core\Database');

$currentUser = 2;

$note = $db->query("SELECT * FROM notes WHERE id = :id", ['id' => $_GET['id']])->findOrFail();

authorize($note['user_id'] === $currentUser);

view('notes/edit.view.php', [
  'heading' => 'Edit Notes',
  'notes' => $note
]);