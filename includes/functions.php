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
                                    (customer_fk, pt_felbeskrivning, pt_arbetsbeskrivning, car_brand, car_model, car_reg, pt_status_fk, created_by_user_fk) 
                                    VALUES (:customer_fk, :pt_felbeskrivning, :pt_arbetsbeskrivning, :car_brand, :car_model, :car_reg, :pt_status_fk, :created_by_user_fk)');

    $stmt_inserpjk->bindParam(':customer_fk', $_GET['customerId'], PDO::PARAM_STR);
    $stmt_inserpjk->bindParam(':pt_felbeskrivning', $_POST['fbe'], PDO::PARAM_STR);
    $stmt_inserpjk->bindParam(':pt_arbetsbeskrivning', $_POST['abe'], PDO::PARAM_STR);
    $stmt_inserpjk->bindParam(':car_brand', $_POST['marke'], PDO::PARAM_STR);
    $stmt_inserpjk->bindParam(':car_model', $_POST['model'], PDO::PARAM_STR);
    $stmt_inserpjk->bindParam(':car_reg', $_POST['register'], PDO::PARAM_STR);
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
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th style='padding-right: 20px;'>User Name</th><th style='padding-left: 20px;'>Total Hours</th></tr>";
        foreach ($results as $row) {
            echo "<tr>
                    <td style='padding-right: 20px;'>" . htmlspecialchars($row['u_name']) . "</td>
                    <td style='padding-left: 20px;'>" . htmlspecialchars($row['total_hours']) . "</td>
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



function getActiveProjects($pdo) {
    $output = "";

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
        WHERE p.pt_status_fk = 1 OR p.pt_status_fk = 2
        ORDER BY p.pt_status_fk ASC
    ");

    if ($stmt->rowCount() > 0) {
        $output .= "<div class='table-responsive'>";
        $output .= "<table class='table table-bordered table-hover'>
                <thead class='thead-dark'>
                    <tr>
                        <th>Customer</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Registration</th>
                        <th>Felbeskrivning</th>
                        <th>Arbetsbeskrivning</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>";

        foreach ($stmt as $row) {
            // Apply color class based on the project status for Status column only
            $status_color_class = ($row['pt_status_fk'] == 1) ? 'table-success' : 'table-danger';

            $felbeskrivning = strlen($row['pt_felbeskrivning']) > 100 
                ? substr($row['pt_felbeskrivning'], 0, 100) . '...' 
                : $row['pt_felbeskrivning'];
            $arbetsbeskrivning = strlen($row['pt_arbetsbeskrivning']) > 100 
                ? substr($row['pt_arbetsbeskrivning'], 0, 100) . '...' 
                : $row['pt_arbetsbeskrivning'];

            $output .= "<tr>
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

        $output .= "</tbody></table>";
    } else {
        $output .= "<div class='alert alert-info' role='alert'>No active projects found.</div>";
    }

    return $output;
}
?>

<?php
function getBillableProjects($pdo) {
    try {
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
        
        return $stmt;
    } catch (PDOException $e) {
        return false;
    }
}


function getStatusColorClass($status_id) {
    switch ($status_id) {
        case 3:
            return 'table-warning'; 
        case 4:
            return 'table-info';
        default:
            return ''; 
    }
}

function truncateText($text, $max_length = 100) {
    return strlen($text) > $max_length ? substr($text, 0, $max_length) . '...' : $text;
}
?>

<?php

function getAllProjects($pdo) {
    try {
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
        ");
        return $stmt;
    } catch (PDOException $e) {
        throw new Exception("Error retrieving active projects: " . $e->getMessage());
    }
}






function getProjectDetails($pdo, $id_projekt) {
    try {
        $stmt = $pdo->prepare("
            SELECT 
                CONCAT(c.cust_fname, ' ', c.cust_lname) AS customer_name, 
                p.pt_felbeskrivning, 
                p.pt_arbetsbeskrivning,
                p.car_brand, 
                p.car_model, 
                p.car_reg,
                p.pt_status_fk,
                u.u_name AS user_name  
            FROM table_projekt p
            JOIN table_customer c ON p.customer_fk = c.id_cust
            JOIN table_users u ON p.created_by_user_fk = u.u_id
            WHERE p.id_projekt = ?
        ");
        $stmt->execute([$id_projekt]);

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch();
        } else {
            return null; 
        }
    } catch (PDOException $e) {
        return ['error' => 'Error: ' . htmlspecialchars($e->getMessage())];
    }
}
?>







 
    












