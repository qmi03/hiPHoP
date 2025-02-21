<?php
require_once 'config/config.php';
require_once 'config/Database.php';
require_once 'models/Product.php';
require_once 'controllers/ProductController.php';

$database = new Database();
$db = $database->connect();

$productController = new ProductController($db);

$action = $_GET['action'] ?? 'index';

switch($action) {
    case 'create':
        $productController->create();
        break;
    default:
        $productController->index();
        break;
}
