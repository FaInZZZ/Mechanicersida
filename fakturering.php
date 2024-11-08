<?php

include_once 'includes/header.php';

if ($user->checkLoginStatus()) {
    if (!$user->checkUserRole(50)) {
        header("Location: home.php");
        exit;
    }
}

echo "<div class='container mt-5'>";
echo "<h1 class='mb-4'>Billable Projects</h1>";

$stmt = getBillableProjects($pdo);

if ($stmt && $stmt->rowCount() > 0) {
    echo "<div class='table-responsive'>";
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
        $status_color_class = getStatusColorClass($row['pt_status_fk']);
        $felbeskrivning = truncateText($row['pt_felbeskrivning']);
        $arbetsbeskrivning = truncateText($row['pt_arbetsbeskrivning']);

        echo "<tr>
                <td>" . $row['customer_name'] . "</td>
                <td>" . $row['car_brand'] . "</td>
                <td>" . $row['car_model'] . "</td>
                <td>" . $row['car_reg'] . "</td>
                <td>" . $felbeskrivning . "</td>
                <td>" . $arbetsbeskrivning . "</td>
                <td class='$status_color_class'>" . $row['status_name'] . "</td>
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
    echo "<div class='alert alert-info' role='alert'>No projects found with the selected statuses.</div>";
}

echo "</div>";

include_once 'includes/footer.php';
?>
