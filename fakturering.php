    <?php

    include_once 'includes/header.php';
    if ($user->checkLoginStatus()) {
        if (!$user->checkUserRole(50)) {
            header("Location: home.php");
        }
    }

    echo "<div class='container mt-5'>";
    echo "<h1 class='mb-4'>Billable Projects</h1>";

    try {
        // Update SQL query to include the new status IDs 5 (obetald) and 6 (betald)
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
        WHERE p.pt_status_fk IN (3, 4, 5, 6)  -- Include new statuses (obetald, betald)
        ORDER BY p.pt_status_fk ASC
    ");
    

        if ($stmt->rowCount() > 0) {
            echo "<table class='table table-bordered table-hover'>
                    <thead class='thead-dark'>
                        <tr>
                            <th>Customer</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Registration</th>
                            <th>Error description</th>
                            <th>Work description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>";

            foreach ($stmt as $row) {
                // Assign different colors based on the status, only for the Status column
                $status_color_class = '';
                switch ($row['pt_status_fk']) {
                    case 3:
                        $status_color_class = 'table-warning'; // Fakturerbar
                        break;
                    case 4:
                        $status_color_class = 'table-info'; // Fakturerad
                        break;
                }

                $felbeskrivning = strlen($row['pt_felbeskrivning']) > 100 
                    ? substr($row['pt_felbeskrivning'], 0, 100) . '...' 
                    : $row['pt_felbeskrivning'];
                $arbetsbeskrivning = strlen($row['pt_arbetsbeskrivning']) > 100 
                    ? substr($row['pt_arbetsbeskrivning'], 0, 100) . '...' 
                    : $row['pt_arbetsbeskrivning'];

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

    } catch (PDOException $e) {
        echo "<div class='alert alert-danger' role='alert'>Error: " . $e->getMessage() . "</div>";
    }

    echo "</div>";

    include_once 'includes/footer.php';
    ?>
