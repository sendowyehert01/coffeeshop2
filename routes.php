<?php 

$router->get('/', 'index.php');
$router->get('/about', 'about.php');
$router->get('/service', 'service.php');
$router->get('/menu', 'menu.php');
$router->get('/get_products', 'get_products.php');
$router->get('/show_product', 'product_page.php');

$router->get('/reservation', 'reservation.php')->only('auth');
$router->get('/testimonial', 'feedback/testimonial.php')->only('auth');
$router->post('/feedback', 'feedback/store.php')->only('auth');
$router->get('/contact', 'contact.php');
// $router->get('/notes', 'notes/index.php')->only('auth');
// $router->get('/note', 'notes/show.php');
// $router->delete('/note', 'notes/destroy.php');

$router->get('/admin_dashboard', 'dashboard/index.php')->only('auth');
$router->get('/admin_dashboard/info', 'dashboard/coffee_info.php')->only('auth');
$router->get('/admin_dashboard/accounts', 'dashboard/accounts.php')->only('auth');
$router->get('/admin_dashboard/orders', 'dashboard/orders.php')->only('auth');
$router->get('/admin_dashboard/inventory', 'dashboard/inventory.php')->only('auth');
$router->get('/admin_dashboard/products', 'dashboard/products.php')->only('auth');
$router->post('/admin_dashboard/products', 'dashboard/products.php')->only('auth');
$router->get('/admin_dashboard/staffs', 'dashboard/staffs.php')->only('auth');
$router->get('/admin_dashboard/reports', 'dashboard/reports.php')->only('auth');

$router->get('/admin_dashboard/reports?get_sales_data', 'dashboard/sales_data.php')->only('auth');
$router->get('/admin_dashboard/reports?get_inventory_data', 'dashboard/inventory_data.php')->only('auth');

$router->get('/pos_frontend', 'pos/index.php')->only('auth');
$router->get('/pos_frontend/frappe', 'pos/frappe.php')->only('auth');
$router->get('/pos_frontend/americano', 'pos/americano.php')->only('auth');
$router->get('/pos_frontend/expresso', 'pos/expresso.php')->only('auth');
$router->get('/pos_frontend/latte', 'pos/latte.php')->only('auth');
$router->get('/pos_frontend/capuccino', 'pos/capuccino.php')->only('auth');

$router->get('/pos_frontend/pos_connect', 'pos/pos_connect.php')->only('auth');

// $router->get('/notes/create', 'notes/create.php');
// $router->post('/notes/store', 'notes/store.php');

// $router->get('/notes/edit', 'notes/edit.php');
// $router->patch('/notes', 'notes/update.php');

$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');

$router->get('/login', 'sessions/create.php')->only('guest');
$router->post('/sessions', 'sessions/store.php')->only('guest');
$router->delete('/sessions', 'sessions/destroy.php')->only('auth');

$router->get('/test', 'test.php');

?>  