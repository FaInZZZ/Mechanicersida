<?php
include_once 'includes/header.php';
include_once 'includes/config.php'; // DB connection
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php
if (isset($_GET['id'])) {
    $id_projekt = $_GET['id'];

    echo "<div class='container mt-5'>";
    echo "<h1 class='mb-4'>Project Details</h1>";

    // Process hours insertion if form submitted
    if (isset($_POST['inserthour'])) {
        $lastHoursId = insertHours($pdo, $id_projekt);
        header('location: active_projects.php');
    }

    if (isset($_POST['insertpart'])) {
        $lastHoursId = insertParts($pdo, $id_projekt);
        header('location: active_projects.php');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
        $status_id = $_POST['status'];
        $car_brand = $_POST['car_brand'];
        $car_model = $_POST['car_model'];
        $car_reg = $_POST['car_reg'];
        $felbeskrivning = $_POST['felbeskrivning'];
        $arbetsbeskrivning = $_POST['arbetsbeskrivning'];

        $update_stmt = $pdo->prepare("
            UPDATE table_projekt 
            SET pt_status_fk = ?, car_brand = ?, car_model = ?, car_reg = ?, pt_felbeskrivning = ?, pt_arbetsbeskrivning = ? 
            WHERE id_projekt = ?
        ");
        $update_stmt->execute([$status_id, $car_brand, $car_model, $car_reg, $felbeskrivning, $arbetsbeskrivning, $id_projekt]);
        header("Location: active_projects.php");

        exit();
    }

    try {
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

            $status_stmt = $pdo->query("SELECT id_status, status_name FROM table_status");
            $statuses = $status_stmt->fetchAll();
            ?>

            <div class="card">
                <div class="card-body">
                    <h3>Customer: <?= htmlspecialchars($project['customer_name']) ?></h3>
                    <form method="POST">
                        <div class="form-group">
                            <label for="car_brand">Brand</label>
                            <input type="text" id="car_brand" name="car_brand" class="form-control" value="<?= htmlspecialchars($project['car_brand']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="car_model">Model</label>
                            <input type="text" id="car_model" name="car_model" class="form-control" value="<?= htmlspecialchars($project['car_model']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="car_reg">Registration</label>
                            <input type="text" id="car_reg" name="car_reg" class="form-control" value="<?= htmlspecialchars($project['car_reg']) ?>">
                        </div>

                        <div class="form-group">
                            <label for="felbeskrivning">Felbeskrivning</label>
                            <textarea id="felbeskrivning" name="felbeskrivning" class="form-control"><?= htmlspecialchars($project['pt_felbeskrivning']) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="arbetsbeskrivning">Arbetsbeskrivning</label>
                            <textarea id="arbetsbeskrivning" name="arbetsbeskrivning" class="form-control"><?= htmlspecialchars($project['pt_arbetsbeskrivning']) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Change Project Status</label>
                            <select id="status" name="status" class="form-control">
                                <?php foreach ($statuses as $status): 
                                    $selected = ($status['id_status'] == $project['pt_status_fk']) ? 'selected' : ''; ?>
                                    <option value="<?= $status['id_status'] ?>" <?= $selected ?>><?= htmlspecialchars($status['status_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Details</button>
                    </form>
                    
                   

                    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Add Hours
                    </button>

                    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#part">
                        Add Parts
                    </button>

                    <button type="button" class="btn btn-primary mt-3" onclick="window.location.href='active_projects.php'">Back</button>
                    
                    
                    <form method="POST" action="delete_project.php?id=<?= $id_projekt ?>" class="mt-3">
                        <input type="hidden" name="id_projekt" value="<?= $id_projekt ?>">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this project?');">Delete Project</button>
                    </form>
                </div>
            </div>

            <!-- Add Hours Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Hours</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="edit-single-project.php?id=<?= $id_projekt ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="hours">Hours</label>
                                    <input type="text" id="hours" name="hours" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" id="date" name="date" class="form-control" value="">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="inserthour" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>




            <div class="modal fade" id="part" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Add parts</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="edit-single-project.php?id=<?= $id_projekt ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="part">Parts</label>
                                    <input type="text" id="part" name="part" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label for="pris">Pris</label>
                                    <input type="text" id="pris" name="pris" class="form-control" value="">
                                </div>  
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="insertpart" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>









            <?php
        } else {
            echo "<div class='alert alert-info' role='alert'>Project not found.</div>";
        }

    } catch (PDOException $e) {
        echo "<div class='alert alert-danger' role='alert'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }

    echo "</div>";
} else {
    echo "<div class='alert alert-danger' role='alert'>No project ID specified.</div>";
}

include_once 'includes/footer.php';
?>
