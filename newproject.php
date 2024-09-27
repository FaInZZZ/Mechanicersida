<?php
include_once 'includes/header.php';
include_once 'includes/functions.php';
include_once 'includes/class.user.php';
include_once 'includes/search.php';

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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container my-5">

        <!-- Customer Section -->
        <h2 class="text-center mb-5">Kund Information</h2>
        <form action="" method="post">
            <!-- Buttons to add or create customer -->
            <div class="d-flex justify-content-between mb-5">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCustomerModal">Skapa kund</button>
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">Lägg till kund</button>
            </div>

            <?php foreach ($customerData as $row): ?>
                <input type="text" class="form-control mb-3" name="custname" value="<?= $row['cust_fname'] ?>" disabled>
            <?php endforeach; ?>

            <!-- Car Information Section -->
            <h2 class="text-center mb-5">Bil Information</h2>
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label for="marke" class="form-label">Märke</label>
                    <input type="text" class="form-control" name="marke" id="marke" placeholder="Ange märke" required>
                </div>
                <div class="col-md-4">
                    <label for="model" class="form-label">Model</label>
                    <input type="text" class="form-control" name="model" id="model" placeholder="Ange model" required>
                </div>
                <div class="col-md-4">
                    <label for="register" class="form-label">Registreringsnummer</label>
                    <input type="text" class="form-control" name="register" id="register" placeholder="Ange reg.nr" required>
                </div>
            </div>

            <!-- Project Information Section -->
            <h2 class="text-center mt-5 mb-4">Projekt Information</h2>

            <h3 class="mb-3">Felbeskrivning</h3>
            <textarea name="fbe" class="form-control mb-4" rows="3" id="fel" placeholder="Ange felbeskrivning"></textarea>

            <h3 class="mb-3">Arbetsbeskrivning</h3>
            <textarea name="abe" class="form-control mb-4" rows="3" id="Arbet" placeholder="Ange arbetsbeskrivning"></textarea>

            <!-- Submit Button -->
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success" name="ltp">Lägg till projekt</button>
            </div>
        </form>
    </div>

    <!-- Modal: Create Customer -->
    <div class="modal fade" id="createCustomerModal" tabindex="-1" aria-labelledby="createCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCustomerModalLabel">Skapa kund</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="namn" class="form-label">Förnamn</label>
                                <input type="text" class="form-control" id="namn" name="namn" required>
                            </div>
                            <div class="col-md-6">
                                <label for="enamn" class="form-label">Efternamn</label>
                                <input type="text" class="form-control" id="enamn" name="enamn" required>
                            </div>
                            <div class="col-md-6">
                                <label for="telefon" class="form-label">Telefon</label>
                                <input type="text" class="form-control" id="telefon" name="telefon" required>
                            </div>
                            <div class="col-md-6">
                                <label for="epost" class="form-label">E-post</label>
                                <input type="email" class="form-control" id="epost" name="epost" required>
                            </div>
                            <div class="col-md-6">
                                <label for="adress" class="form-label">Adress</label>
                                <input type="text" class="form-control" id="adress" name="adress" required>
                            </div>
                            <div class="col-md-6">
                                <label for="postnummer" class="form-label">Postnummer</label>
                                <input type="text" class="form-control" id="postnummer" name="postnummer" required>
                            </div>
                            <div class="col-md-6">
                                <label for="ort" class="form-label">Ort</label>
                                <input type="text" class="form-control" id="ort" name="ort" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Stäng</button>
                        <button type="submit" name="submitnykund" class="btn btn-primary">Lägg till kund</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Add Customer -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">Lägg till kund</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="mb-3">
                            <label for="fname" class="form-label">Förnamn</label>
                            <input type="text" class="form-control" id="fname" name="fname" onkeyup="showClassmates(this.value)">
                        </div>
                    </form>
                    <p><strong>Förslag:</strong><br><br> <span id="class-list"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Stäng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Dependencies -->
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
