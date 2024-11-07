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
    if (empty($_GET['customerId'])) {
        header("Location: newproject.php?status=nokund");
        exit();
    }

    if (!empty($customerData)) {
        echo "Yes";
    }

    if (!empty($_POST['produkter'])) {
       return;
    }

    $stmt_inserpjk = $pdo->prepare('INSERT INTO table_projekt 
                                    (customer_fk, pt_felbeskrivning, pt_arbetsbeskrivning, car_brand, car_model, car_reg, pt_status_fk, fk_produkter, created_by_user_fk) 
                                    VALUES (:customer_fk, :pt_felbeskrivning, :pt_arbetsbeskrivning, :car_brand, :car_model, :car_reg, :pt_status_fk, :fk_produkter, :created_by_user_fk)');

    $stmt_inserpjk->bindParam(':customer_fk', $_GET['customerId'], PDO::PARAM_STR);
    $stmt_inserpjk->bindParam(':pt_felbeskrivning', $_POST['fbe'], PDO::PARAM_STR);
    $stmt_inserpjk->bindParam(':pt_arbetsbeskrivning', $_POST['abe'], PDO::PARAM_STR);
    $stmt_inserpjk->bindParam(':car_brand', $_POST['marke'], PDO::PARAM_STR);
    $stmt_inserpjk->bindParam(':car_model', $_POST['model'], PDO::PARAM_STR);
    $stmt_inserpjk->bindParam(':car_reg', $_POST['register'], PDO::PARAM_STR);
    $stmt_inserpjk->bindParam(':fk_produkter', $_POST['produkter'], PDO::PARAM_INT);
    $stmt_inserpjk->bindParam(':created_by_user_fk', $_SESSION['user_id'], PDO::PARAM_INT);

    $pt_status_fk = 2; 
    $stmt_inserpjk->bindParam(':pt_status_fk', $pt_status_fk, PDO::PARAM_INT);

    $stmt_inserpjk->execute();

    $newProjectId = $pdo->lastInsertId();
    header("Location: edit-single-project.php?id=" . $newProjectId);
    exit();
}


function insertHours($pdo, $id_projekt) {
    $stmt = $pdo->prepare("SELECT u_id FROM table_users WHERE u_name = :user_name");
    $stmt->bindParam(':user_name', $_SESSION['user_name'], PDO::PARAM_STR);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $user_fk = $user['u_id']; 

    $stmt = $pdo->prepare("INSERT INTO table_timmar (hours, date, project_fk, user_fk) VALUES (:hours, :date, :id_projekt, :user_fk)");
    
    $stmt->bindParam(':hours', $_POST['hours'], PDO::PARAM_STR);
    $stmt->bindParam(':date', $_POST['date'], PDO::PARAM_STR);
    $stmt->bindParam(':id_projekt', $id_projekt, PDO::PARAM_INT);
    $stmt->bindParam(':user_fk', $user_fk, PDO::PARAM_INT); 

    if ($stmt->execute()) {
        header("Location: active_projects.php?status=successedithours");
        exit();
    } else {
        header("Location: active_projects.php?status=failedithours");
        exit();
    }
    
    
    $last_id = $pdo->lastInsertId();
    return $last_id;
}

function insertParts($pdo, $id_projekt) {
    $stmt = $pdo->prepare("INSERT INTO table_parts (produkt_namn, produkt_pris, project_fk) VALUES (:part, :pris, :id_projekt)");
    
    $stmt->bindParam(':part', $_POST['part'], PDO::PARAM_STR);
    $stmt->bindParam(':pris', $_POST['pris'], PDO::PARAM_STR);
    $stmt->bindParam(':id_projekt', $id_projekt, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        header("Location: active_projects.php?status=successeditpart");
        exit();
    } else {
        header("Location: active_projects.php?status=faileditpart");
        exit();
    }

    $last_id = $pdo->lastInsertId();
    return $last_id;
}
    
function getTimeOverview($pdo) {
    $stmt = $pdo->prepare("
        SELECT table_users.u_name, SUM(table_timmar.hours) as total_hours 
        FROM table_timmar 
        INNER JOIN table_users ON table_timmar.user_fk = table_users.u_id
        WHERE table_timmar.date BETWEEN :start_date AND :end_date 
        GROUP BY table_users.u_name
    ");

    $stmt->bindParam(':start_date', $_POST['start_date'], PDO::PARAM_STR);
    $stmt->bindParam(':end_date', $_POST['end_date'], PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>User Name</th><th>Total Hours</th></tr>";
        foreach ($results as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['u_name']) . "</td>
                    <td>" . htmlspecialchars($row['total_hours']) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No records found for the selected date range.</p>";
    }
}



function GetPrjParts($pdo, $id_projekt) {
    $stmt = $pdo->prepare('
    SELECT * FROM table_parts 
    WHERE project_fk = :id');
    $stmt->bindParam(':id', $id_projekt, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll();


}





 
    












?>
