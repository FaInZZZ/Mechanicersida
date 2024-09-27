<?php
include_once 'includes/header.php';
include_once 'includes/config.php'; // DB connection

echo "<h1>Active Projects</h1>";

try {
    // Assuming the table is called 'table_projects' and has a column 'status' to indicate active projects
    $stmt = $pdo->query("SELECT * FROM table_projekt WHERE pt_status_fk = '1'");

    if ($stmt->rowCount() > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Project ID</th>
                    <th>Customer name</th>
                    <th>Felbeskrivning</th>
                    <th>Arbetsbeskrivning</th>
                </tr>";

        // Fetch each row and display it
        foreach ($stmt as $row) {
            echo "<tr>
                    <td>" . $row['id_projekt'] . "</td>
                    <td>" . $row['customer_fk'] . "</td>
                    <td>" . $row['pt_felbeskrivning'] . "</td>
                    <td>" . $row['pt_arbetsbeskrivning'] . "</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No active projects found.</p>";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

include_once 'includes/footer.php';
?>
