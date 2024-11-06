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

<?php
echo "<div class='container mt-5'>";
echo "<h1 class='mb-4'>Active Projects</h1>";

$stmt = $pdo->query("
    SELECT 
        p.id_projekt, 
        CONCAT(c.cust_fname, ' ', c.cust_lname) AS customer_name, 
        p.pt_felbeskrivning, 
        p.pt_arbetsbeskrivning,
        p.car_brand, 
        p.car_model, 
        p.car_reg,
        s.status_name,
        p.pt_status_fk
    FROM table_projekt p
    JOIN table_customer c ON p.customer_fk = c.id_cust
    JOIN table_status s ON p.pt_status_fk = s.id_status
    WHERE p.pt_status_fk = 1
");

if ($stmt->rowCount() > 0) {
    echo "<table class='table table-bordered table-hover'>
            <thead class='thead-dark'>
                <tr>
                    <th>Customer</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Registration</th>
                    <th>Felbeskrivning</th>
                    <th>Arbetsbeskrivning</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>";

    foreach ($stmt as $row) {
        $color_class = 'table-success';

        $felbeskrivning = strlen($row['pt_felbeskrivning']) > 100 
            ? substr($row['pt_felbeskrivning'], 0, 100) . '...' 
            : $row['pt_felbeskrivning'];
        $arbetsbeskrivning = strlen($row['pt_arbetsbeskrivning']) > 100 
            ? substr($row['pt_arbetsbeskrivning'], 0, 100) . '...' 
            : $row['pt_arbetsbeskrivning'];

        echo "<tr class='$color_class'>
                <td>" . $row['customer_name'] . "</td>
                <td>" . $row['car_brand'] . "</td>
                <td>" . $row['car_model'] . "</td>
                <td>" . $row['car_reg'] . "</td>
                <td>" . $felbeskrivning . "</td>
                <td>" . $arbetsbeskrivning . "</td>
                <td>" . $row['status_name'] . "</td>
                <td>
                    <a href='single-project.php?id=" . $row['id_projekt'] . "' class='btn btn-primary'>View Project</a>
                </td>
                <td>
                    <a href='edit-single-project.php?id=" . $row['id_projekt'] . "' class='btn btn-primary'>Edit Project</a>
                </td>
              </tr>";
    }

    echo "</tbody></table>";
} else {
    echo "<div class='alert alert-info' role='alert'>No active projects found.</div>";
}

echo "</div>";

include_once 'includes/footer.php';
?>

</body>
</html>
