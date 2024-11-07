<?php
if($user->checkLoginStatus()){
    if(!$user->checkUserRole(300)){
        header("Location: home.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    
    <?php include_once 'includes/header.php'; ?>

    <main class="container mt-4">
        <div class="row justify-content-center">
        <h1>Admin page</h1>
            <div class="col-lg-4 col-md-6">
                <a href="edit-account.php" class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Edit Current Account</h5>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="redigera_user_search.php" class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Edit Account</h5>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="register.php" class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Register</h5>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="customer.php" class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">View All Customers</h5>
                    </div>
                </a>
            </div>
        </div>
    </main>
    
</body>
</html>
