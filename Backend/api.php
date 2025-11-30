<?php
require_once 'config.php';

// Simple routing
$request_uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// API endpoints mapping
if (strpos($request_uri, '/api/login') !== false && $method == 'POST') {
    require_once 'auth.php';
} 
elseif (strpos($request_uri, '/api/results') !== false) {
    require_once 'results.php';
} 
elseif (strpos($request_uri, '/api/admissions') !== false) {
    require_once 'admissions.php';
} 
elseif (strpos($request_uri, '/api/students') !== false) {
    require_once 'students.php';
} 
else {
    // Serve the main frontend
    if (file_exists('index.html')) {
        readfile('index.html');
    } else {
        echo json_encode(array("status" => "error", "message" => "Endpoint not found"));
    }
}
?>