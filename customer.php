<?php
include_once 'includes/header.php';
include_once 'includes/functions.php';
include_once 'includes/class.user.php';

// Check user login status
if($user->checkLoginStatus()){
    if(!$user->checkUserRole(10)){
        header("Location: home.php");
        exit();
    }
}

$userArray = $user->getAllCustomers();
$customers = $user->getAllCustomers();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List</title>
</head>
<body>

<div class="mt-3 container text-center">
    <h1>Customer List</h1>

<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?php echo htmlspecialchars($customer['cust_fname']); ?></td>
                    <td><?php echo htmlspecialchars($customer['cust_lname']); ?></td>
                    <td>
                        <a href="edit_cust.php?uid=<?php echo $customer['id_cust']; ?>" class="btn btn-warning">Edit</a>
                        <a href="confirm-delete-kund.php?uid=<?php echo $customer['id_cust']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
