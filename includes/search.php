<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once 'config.php'; // Database configuration
    include_once 'functions.php'; // Any helper functions

    // Sanitize and validate input data
    $marke = filter_input(INPUT_POST, 'marke', FILTER_SANITIZE_STRING);
    $model = filter_input(INPUT_POST, 'model', FILTER_SANITIZE_STRING);
    $register = filter_input(INPUT_POST, 'register', FILTER_SANITIZE_STRING);

    // Database query example (adjust as necessary)
    $query = $pdo->prepare("INSERT INTO customers (marke, model, register) VALUES (?, ?, ?)");
    $query->execute([$marke, $model, $register]);

    if ($query) {
        echo json_encode(["status" => "success", "message" => "Customer added successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add customer"]);
    }
}
?>
