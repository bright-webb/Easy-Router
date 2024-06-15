<?php
use EasyAPI\Lib\Router;
header("Content-Type: application/json");
require_once(__DIR__ . '/bootstrap.php');
use EasyAPI\Controller\ApiController;

// Get request method and URI
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];
$router = new Router();

$router->add('GET', '/', [ApiController::class, 'index']);

$router->run($requestMethod, $requestUri);