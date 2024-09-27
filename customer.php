<?php
include_once 'includes/header.php';
include_once 'includes/functions.php';
include_once 'includes/class.user.php';
include_once 'includes/search.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List</title>
    <script src="ajax.js"></script>
</head>
<body>
    <h1>Customer List</h1>

    <!-- Search Form -->
    <input type="text" id="search-box" placeholder="Search for customers...">
    <div id="result"></div>

    <h2>All Customers</h2>
    <div id="customer-list">
        <?php
        // Fetch and display all customers initially
        $stmt = $pdo->query("SELECT * FROM table_customer");
        foreach ($stmt as $row) {
            echo "<div><strong>Förnamn:</strong> " . $row['cust_fname'] . "<br>" .
                 "<strong>Efternamn:</strong> " . $row['cust_lname'] . "<br>" .
                 "<strong>Adress:</strong> " . $row['cust_adress'] . "<br><br>" .
                 "<a href='newproject.php?customerId=" . $row['id_cust'] . "'>Välj</a></div><hr>";
        }
        ?>
    </div>
</body>
</html>
