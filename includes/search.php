<?php
include_once 'config.php';

if (isset($_GET['q'])) {
    $input = "%" . $_GET['q'] . "%";

    $stmt_searchClassmates = $pdo->prepare("SELECT * FROM table_customer WHERE cust_lname LIKE :lname OR cust_adress LIKE :cust_adress");
    $stmt_searchClassmates->bindParam(":lname", $input, PDO::PARAM_STR);
    $stmt_searchClassmates->bindParam(":cust_adress", $input, PDO::PARAM_STR);
    $stmt_searchClassmates->execute();

    foreach ($stmt_searchClassmates as $row) {
        echo "<strong> Efternamn: </strong> " . $row['cust_lname'] . "<br>" . "<strong> Adress: </strong>" . $row['cust_adress'] .  "<br><br>";
    }
} else {
}
?>
