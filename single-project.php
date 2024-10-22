<?php
include_once 'includes/header.php';
include_once 'includes/config.php'; // DB connection

if (isset($_GET['id'])) {
    $id_projekt = $_GET['id'];

    echo "<div class='container mt-5'>";
    echo "<h1 class='mb-4'>Project Details</h1>";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
        $status_id = $_POST['status'];
        $car_brand = $_POST['car_brand'];
        $car_model = $_POST['car_model'];
        $car_reg = $_POST['car_reg'];
        $felbeskrivning = $_POST['felbeskrivning'];
        $arbetsbeskrivning = $_POST['arbetsbeskrivning'];

        // Update the project details in the database
        $update_stmt = $pdo->prepare("
            UPDATE table_projekt 
            SET pt_status_fk = ?, car_brand = ?, car_model = ?, car_reg = ?, pt_felbeskrivning = ?, pt_arbetsbeskrivning = ? 
            WHERE id_projekt = ?
        ");
        $update_stmt->execute([$status_id, $car_brand, $car_model, $car_reg, $felbeskrivning, $arbetsbeskrivning, $id_projekt]);
        header("Location: active_projects.php");

        exit();

        echo "<div class='alert alert-success'>Project details updated successfully.</div>";
    }

    try {
        // Fetch the specific project details
        $stmt = $pdo->prepare("
            SELECT 
                CONCAT(c.cust_fname, ' ', c.cust_lname) AS customer_name, 
                p.pt_felbeskrivning, 
                p.pt_arbetsbeskrivning,
                p.car_brand, 
                p.car_model, 
                p.car_reg,
                p.pt_status_fk
            FROM table_projekt p
            JOIN table_customer c ON p.customer_fk = c.id_cust
            WHERE p.id_projekt = ?
        ");
        $stmt->execute([$id_projekt]);

        if ($stmt->rowCount() > 0) {
            $project = $stmt->fetch();

            // Fetch all possible statuses from table_status
            $status_stmt = $pdo->query("SELECT id_status, status_name FROM table_status");
            $statuses = $status_stmt->fetchAll();

            echo "<div class='card'>
                    <div class='card-body'>
                        <h3>Customer: " . $project['customer_name'] . "</h3>
                        <form method='POST'>
                            <div class='form-group'>
                                <label for='car_brand'>Brand</label>
                                <input type='text' id='car_brand' name='car_brand' class='form-control' value='" . $project['car_brand'] . "'>
                            </div>
                            <div class='form-group'>
                                <label for='car_model'>Model</label>
                                <input type='text' id='car_model' name='car_model' class='form-control' value='" . $project['car_model'] . "'>
                            </div>
                            <div class='form-group'>
                                <label for='car_reg'>Registration</label>
                                <input type='text' id='car_reg' name='car_reg' class='form-control' value='" . $project['car_reg'] . "'>
                            </div>
                            <div class='form-group'>
                                <label for='felbeskrivning'>Felbeskrivning</label>
                                <textarea id='felbeskrivning' name='felbeskrivning' class='form-control'>" . $project['pt_felbeskrivning'] . "</textarea>
                            </div>
                            <div class='form-group'>
                                <label for='arbetsbeskrivning'>Arbetsbeskrivning</label>
                                <textarea id='arbetsbeskrivning' name='arbetsbeskrivning' class='form-control'>" . $project['pt_arbetsbeskrivning'] . "</textarea>
                            </div>
                            <div class='form-group'>
                                <label for='status'>Change Project Status</label>
                                <select id='status' name='status' class='form-control'>";
            
            // Populate dropdown with statuses
            foreach ($statuses as $status) {
                $selected = ($status['id_status'] == $project['pt_status_fk']) ? 'selected' : '';
                echo "<option value='" . $status['id_status'] . "' $selected>" . $status['status_name'] . "</option>";
            }

            echo "            </select>
                            </div>
                            <button type='submit' class='btn btn-primary'>Update Details</button>
                        </form>
                    </div>
                  </div>";
        } else {
            echo "<div class='alert alert-info' role='alert'>Project not found.</div>";
        }

    } catch (PDOException $e) {
        echo "<div class='alert alert-danger' role='alert'>Error: " . $e->getMessage() . "</div>";
    }

    echo "</div>";
} else {
    echo "<div class='alert alert-danger' role='alert'>No project ID specified.</div>";
}

include_once 'includes/footer.php';
?>
