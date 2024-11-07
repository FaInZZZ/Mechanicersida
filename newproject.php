<?php
include_once 'includes/header.php';
include_once 'includes/functions.php';
include_once 'includes/class.user.php';
include_once 'includes/search.php';

$status = isset($_GET['status']) ? $_GET['status'] : '';

if($user->checkLoginStatus()){
    if(!$user->checkUserRole(10)){
        header("Location: home.php");
    }
}

if (isset($_POST['submitnykund'])) {
    $submitnykund = nykund($pdo);
}

if (isset($_POST['ltp'])) {
    $submitpjk = nyprjkt($pdo);
}

$customerData = [];

if (isset($_GET['customerId'])) {
    $customerId = htmlspecialchars($_GET['customerId']);

    $stmt = $pdo->prepare("SELECT cust_fname FROM table_customer WHERE id_cust = :customerId");
    $stmt->bindParam(":customerId", $customerId, PDO::PARAM_INT);
    $stmt->execute();
    
    $customerData = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skapa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container my-5">

    <div class="container mt-4">
    <?php if ($status === 'nokund'): ?>
        <div class="alert alert-danger" role="alert">
           Choose a customer
        </div>
    <?php endif; ?>
</div>


        <h2 class="text-center mb-5">Customer</h2>
        <form action="" method="post">
        <input type="hidden" name="user_name" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
            <div class="d-flex justify-content-between mb-5">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCustomerModal">Create customer</button>
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">Add customer</button>
            </div>

            <?php foreach ($customerData as $row): ?>
                <input type="text" class="form-control mb-3" name="custname" value="<?= $row['cust_fname'] ?>" disabled>
            <?php endforeach; ?>

            <h2 class="text-center mb-5">Car</h2>
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label for="marke" class="form-label">Brand</label>
                    <input type="text" class="form-control" name="marke" id="marke" placeholder="brand" required>
                </div>
                <div class="col-md-4">
                    <label for="model" class="form-label">Model</label>
                    <input type="text" class="form-control" name="model" id="model" placeholder="model" required>
                </div>
                <div class="col-md-4">
                    <label for="register" class="form-label">Registrer</label>
                    <input type="text" class="form-control" name="register" id="register" placeholder="register" required>
                </div>
            </div>

            <h2 class="text-center mt-5 mb-4">Project</h2>

            <h3 class="mb-3">Error description</h3>
            <textarea name="fbe" class="form-control mb-4" rows="3" id="fel" placeholder="Error description"></textarea>

            <h3 class="mb-3">Work description</h3>
            <textarea name="abe" class="form-control mb-4" rows="3" id="Arbet" placeholder="Work description"></textarea>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success" name="ltp">Add project</button>
            </div>
        </form>
    </div>

    <div class="modal fade" id="createCustomerModal" tabindex="-1" aria-labelledby="createCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCustomerModalLabel">Create</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="namn" class="form-label">First name</label>
                                <input type="text" class="form-control" id="namn" name="namn" required>
                            </div>
                            <div class="col-md-6">
                                <label for="enamn" class="form-label">Last name</label>
                                <input type="text" class="form-control" id="enamn" name="enamn" required>
                            </div>
                            <div class="col-md-6">
                                <label for="telefon" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="telefon" name="telefon" required>
                            </div>
                            <div class="col-md-6">
                                <label for="epost" class="form-label">Email</label>
                                <input type="email" class="form-control" id="epost" name="epost" required>
                            </div>
                            <div class="col-md-6">
                                <label for="adress" class="form-label">Address</label>
                                <input type="text" class="form-control" id="adress" name="adress" required>
                            </div>
                            <div class="col-md-6">
                                <label for="postnummer" class="form-label">Postnumber</label>
                                <input type="text" class="form-control" id="postnummer" name="postnummer" required>
                            </div>
                            <div class="col-md-6">
                                <label for="ort" class="form-label">Region</label>
                                <input type="text" class="form-control" id="ort" name="ort" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submitnykund" class="btn btn-primary">Add customer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">Add customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="mb-3">
                            <label for="fname" class="form-label">Firstname</label>
                            <input type="text" class="form-control" id="fname" name="fname" onkeyup="showClassmates(this.value)">
                        </div>
                    </form>
                    <p><strong>Suggestions:</strong><br><br> <span id="class-list"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showClassmates(str) {
            if (str.length == 0) {
                document.getElementById("class-list").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("class-list").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "includes/search.php?q=" + encodeURIComponent(str), true);
                xmlhttp.send();
            }
        }
    </script>

</body>

</html>
