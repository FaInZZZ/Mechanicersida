<?php
include_once 'config.php';

if (isset($_GET['q'])) {
    $input = "%" . $_GET['q'] . "%";

    $stmt_searchClassmates = $pdo->prepare("SELECT * FROM table_customer WHERE cust_lname LIKE :lname OR cust_adress LIKE :cust_adress  OR cust_fname LIKE :fname");
    $stmt_searchClassmates->bindParam(":lname", $input, PDO::PARAM_STR);
    $stmt_searchClassmates->bindParam(":cust_adress", $input, PDO::PARAM_STR);
    $stmt_searchClassmates->bindParam(":fname", $input, PDO::PARAM_STR);
    $stmt_searchClassmates->execute();

    foreach ($stmt_searchClassmates as $row) {
        echo "<div><strong> Firstname: </strong> " . $row['cust_fname'] . "<br>" . "<strong> Lastname: </strong> " . $row['cust_lname'] . "<br>" . "<strong> Address: </strong>" . $row['cust_adress'] .  "<br><br>
        <a href='newproject.php?customerId=" . $row['id_cust'] . "'>Choose</a>
        </div>";
    }
} else {
}
?>
