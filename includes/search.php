<?php
include_once 'config.php';

if (isset($_GET['q'])) {
    $input = "%" . $_GET['q'] . "%";

    $stmt_searchClassmates = $pdo->prepare("SELECT * FROM table_customer WHERE cust_lname LIKE :lname OR cust_adress LIKE :cust_adress");
    $stmt_searchClassmates->bindParam(":lname", $input, PDO::PARAM_STR);
    $stmt_searchClassmates->bindParam(":cust_adress", $input, PDO::PARAM_STR);
    $stmt_searchClassmates->execute();

    foreach ($stmt_searchClassmates as $row) {
        echo $row['cust_lname'] . " " . $row['cust_adress'] . "<br>";
    }
} else {
}
?>
