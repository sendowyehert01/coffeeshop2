<?php 

// return [
//   '/' => 'controllers/index.php',
//   '/about' => 'controllers/about.php',
//   '/notes' => 'controllers/notes/index.php',
//   '/note' => 'controllers/notes/show.php',
//   '/contact' => 'controllers/contact.php',
//   '/notes/create' => 'controllers/notes/create.php',
// ];

$router->get('/', 'index.php');
$router->get('/about', 'about.php');
$router->get('/service', 'service.php');
$router->get('/menu', 'menu.php');
$router->get('/reservation', 'reservation.php');
$router->get('/testimonial', 'testimonial.php');
$router->get('/contact', 'contact.php');
// $router->get('/notes', 'notes/index.php')->only('auth');
// $router->get('/note', 'notes/show.php');
// $router->delete('/note', 'notes/destroy.php');


$router->get('/notes/create', 'notes/create.php');
$router->post('/notes/store', 'notes/store.php');

$router->get('/notes/edit', 'notes/edit.php');
$router->patch('/notes', 'notes/update.php');

$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');

$router->get('/login', 'sessions/create.php')->only('guest');
$router->post('/sessions', 'sessions/store.php')->only('guest');
$router->delete('/sessions', 'sessions/destroy.php')->only('auth');

?>  