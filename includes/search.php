<?php
include_once 'config.php';
$input = "%".$_GET['q']."%";

$stmt_searchClassmates = $pdo->prepare("SELECT * FROM namn WHERE fname LIKE :fname OR lname LIKE :lname");
$stmt_searchClassmates->bindParam(":fname", $input, PDO::PARAM_STR);
$stmt_searchClassmates->bindParam(":lname", $input, PDO::PARAM_STR);
$stmt_searchClassmates->execute();

foreach($stmt_searchClassmates as $row) {
    echo $row['fname']." ".$row['lname']."<br>";
   
}
?>