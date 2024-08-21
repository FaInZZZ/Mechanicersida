<?php
include_once 'config.php';

function nykund($pdo) {
    // Ensure that the 'ort' field is not empty
    if (empty($_POST['ort'])) {
        throw new Exception("Ort field cannot be empty");
    }

    $stmt_inserCust = $pdo->prepare('INSERT INTO table_customer (cust_fname, cust_lname, cust_tel, cust_epost, cust_adress, cust_postnummer, cust_ort) 
                                      VALUES (:cust_fname, :cust_lname, :cust_tel, :cust_epost, :cust_adress, :cust_postnummer, :cust_ort)');

    $stmt_inserCust->bindParam(':cust_fname', $_POST['namn'], PDO::PARAM_STR);
    $stmt_inserCust->bindParam(':cust_lname', $_POST['enamn'], PDO::PARAM_STR);
    $stmt_inserCust->bindParam(':cust_tel', $_POST['telefon'], PDO::PARAM_STR);
    $stmt_inserCust->bindParam(':cust_epost', $_POST['epost'], PDO::PARAM_STR);
    $stmt_inserCust->bindParam(':cust_adress', $_POST['adress'], PDO::PARAM_STR);
    $stmt_inserCust->bindParam(':cust_postnummer', $_POST['postnummer'], PDO::PARAM_STR);
    $stmt_inserCust->bindParam(':cust_ort', $_POST['ort'], PDO::PARAM_STR);

    $stmt_inserCust->execute();
}
?>
