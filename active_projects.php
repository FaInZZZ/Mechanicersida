<?php
include_once 'includes/header.php';
include_once 'includes/config.php'; // DB connection

echo "<div class='container mt-5'>";
echo "<h1 class='mb-4'>Active Projects</h1>";

try {
    // Query to fetch customer name and car details directly from table_projekt
    $stmt = $pdo->query("
        SELECT 
            p.id_projekt, 
            CONCAT(c.cust_fname, ' ', c.cust_lname) AS customer_name, 
            p.pt_felbeskrivning, 
            p.pt_arbetsbeskrivning,
            p.car_brand, 
            p.car_model, 
            p.car_reg
        FROM table_projekt p
        JOIN table_customer c ON p.customer_fk = c.id_cust
        WHERE p.pt_status_fk = '1'
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
                    </tr>
                </thead>
                <tbody>";

        // Fetch each row and display it
        foreach ($stmt as $row) {
            echo "<tr>
                    <td>" . $row['customer_name'] . "</td>
                    <td>" . $row['car_brand'] . "</td>
                    <td>" . $row['car_model'] . "</td>
                    <td>" . $row['car_reg'] . "</td>
                    <td>" . $row['pt_felbeskrivning'] . "</td>
                    <td>" . $row['pt_arbetsbeskrivning'] . "</td>
                  </tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-info' role='alert'>No active projects found.</div>";
    }

} catch (PDOException $e) {
    echo "<div class='alert alert-danger' role='alert'>Error: " . $e->getMessage() . "</div>";
}

echo "</div>";

include_once 'includes/footer.php';
?>
