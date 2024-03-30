<?php 

use Core\Database;

$config = require(base_path("config.php"));
$db = new Database($config['database'], $config['account']['username'], $config['account']['password']);

$notes = $db->query('SELECT * FROM notes WHERE user_id = :id', ['id' => 2])->fetch();

view('notes/index.view.php', [
  'heading' => 'My Notes',
  'notes' => $notes,
]);