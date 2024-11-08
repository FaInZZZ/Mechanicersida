<?php

include_once 'includes/functions.php';
include_once 'includes/header.php';

if ($user->checkLoginStatus()) {
    if (!$user->checkUserRole(300)) {
        header("Location: home.php");
    }
}

if (isset($_POST['Datesubmit'])) {
    getTimeOverview($pdo);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Overview</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Time Overview</h2>
        <form method="POST" action="timeoverview.php">
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date:</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
            <div class="text-center">
                <button type="submit" name="Datesubmit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
