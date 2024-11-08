<?php
include_once 'includes/header.php';

if($user->checkLoginStatus()){
    if(!$user->checkUserRole(10)){
        header("Location: home.php");
    }
}



$status = isset($_GET['status']) ? $_GET['status'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<div class="container mt-4">
    <?php if ($status === 'successeditpart'): ?>
        <div class="alert alert-success" role="alert">
            Successfully Added Parts!
        </div>
    <?php elseif ($status === 'faileditpart'): ?>
        <div class="alert alert-danger" role="alert">
            Failed to Add Parts.
        </div>
    <?php endif; ?>

    <div class="container mt-4">
    <?php if ($status === 'successedithours'): ?>
        <div class="alert alert-success" role="alert">
            Successfully Added Hours!
        </div>
    <?php elseif ($status === 'failedithours'): ?>
        <div class="alert alert-danger" role="alert">
            Failed to Add hours.
        </div>
    <?php endif; ?>

    <div class="container mt-4">
    <?php if ($status === 'successeditcust'): ?>
        <div class="alert alert-success" role="alert">
            Successfully edited customer!
        </div>
    <?php elseif ($status === 'faileditcus'): ?>
        <div class="alert alert-danger" role="alert">
            Failed to edit customer.
        </div>
    <?php endif; ?>

    <div class="container mt-4">
    <?php if ($status === 'successeditproject'): ?>
        <div class="alert alert-success" role="alert">
            Successfully edited Project!
        </div>
    <?php elseif ($status === 'faileditproject'): ?>
        <div class="alert alert-danger" role="alert">
            Failed to edit Project.
        </div>
    <?php endif; ?>


    <div class='container mt-5'>
        <h1 class='mb-4'>Active Projects</h1>
        <?php
        echo getActiveProjects($pdo);
        ?>
    </div>

<?php
include_once 'includes/footer.php';
?>

</body>
</html>
