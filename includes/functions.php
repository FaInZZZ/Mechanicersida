<?php
include_once 'config.php';



if (isset($_GET['customerId'])) {
    $customerId = htmlspecialchars($_GET['customerId']);

    $stmt = $pdo->prepare("SELECT cust_fname FROM table_customer WHERE id_cust = :customerId");
    $stmt->bindParam(":customerId", $customerId, PDO::PARAM_INT);
    $stmt->execute();
    
    $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$customerData = []; 

function nykund($pdo) {
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

function nyprjkt($pdo) {
    if (!empty($customerData)) {
        echo "Yes";
    }

    if (!empty($_POST['produkter'])) {
       return;
    }


    
    $stmt_inserpjk = $pdo->prepare('INSERT INTO table_projekt 
                                    (customer_fk, pt_felbeskrivning, pt_arbetsbeskrivning, car_brand, car_model, car_reg, pt_status_fk, fk_produkter) 
                                    VALUES (:customer_fk, :pt_felbeskrivning, :pt_arbetsbeskrivning, :car_brand, :car_model, :car_reg, :pt_status_fk, :fk_produkter)');

    $stmt_inserpjk->bindParam(':customer_fk', $_GET['customerId'], PDO::PARAM_STR);
    $stmt_inserpjk->bindParam(':pt_felbeskrivning', $_POST['fbe'], PDO::PARAM_STR);
    $stmt_inserpjk->bindParam(':pt_arbetsbeskrivning', $_POST['abe'], PDO::PARAM_STR);
    $stmt_inserpjk->bindParam(':car_brand', $_POST['marke'], PDO::PARAM_STR);
    $stmt_inserpjk->bindParam(':car_model', $_POST['model'], PDO::PARAM_STR);
    $stmt_inserpjk->bindParam(':car_reg', $_POST['register'], PDO::PARAM_STR);
    $stmt_inserpjk->bindParam(':fk_produkter', $_POST['produkter'], PDO::PARAM_INT);

    $pt_status_fk = 1; 
    $stmt_inserpjk->bindParam(':pt_status_fk', $pt_status_fk, PDO::PARAM_INT);

    $stmt_inserpjk->execute();
}




function insertHours($pdo, $id_projekt) {
    $stmt = $pdo->prepare("INSERT INTO table_timmar (hours, date, project_fk) VALUES (:hours, :date, :id_projekt)");
    
    $stmt->bindParam(':hours', $_POST['hours'], PDO::PARAM_STR);
    $stmt->bindParam(':date', $_POST['date'], PDO::PARAM_STR);
    $stmt->bindParam(':id_projekt', $id_projekt, PDO::PARAM_INT);
    $stmt->execute();
    $last_id = $pdo->lastInsertId();
    return $last_id;
    
}



 
    












?>
