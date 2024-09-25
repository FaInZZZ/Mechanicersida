<?php
include_once 'includes/header.php';
include_once 'includes/functions.php';
include_once 'includes/class.user.php';
include_once 'includes/search.php';
if (isset($_POST['submitnykund'])) {
    $submitnykund = nykund($pdo);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skapa</title>



</head>

<body>

    <div class="container text-center">
        <h2 class="pt-5 pb-5">Bil</h2>
        <div class="bilinputfalt">
            <form class="d-flex justify-content-between" action="" method="post">
                <label for="marke">Märke</label>
                <input type="text" name="marke" id="marke">
                <label for="model">Model</label>
                <input type="text" name="model" id="model">
                <label for="register">Reg</label>
                <input type="text" name="register" id="register">
            </form>
        </div>


        <h2 class="pt-5 pb-5">Kund</h2>

        <!-- Modal Trigger Button -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Skapa kund</button>

        <!-- Modal Form -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="namn" class="form-label">Namn</label>
                                    <input type="text" class="form-control" id="namn" name="namn" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="enamn" class="form-label">Efternamn</label>
                                    <input type="text" class="form-control" id="enamn" name="enamn" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="telefon" class="form-label">Telefon</label>
                                    <input type="text" class="form-control" id="telefon" name="telefon" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="epost" class="form-label">Epost</label>
                                    <input type="email" class="form-control" id="epost" name="epost" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="adress" class="form-label">Adress</label>
                                    <input type="text" class="form-control" id="adress" name="adress" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="postnummer" class="form-label">Postnummer</label>
                                    <input type="text" class="form-control" id="postnummer" name="postnummer" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="ort" class="form-label">Ort</label>
                                    <input type="text" class="form-control" id="ort" name="ort" required>
                                </div>
                            </div>
                            <!-- Modal Footer with Submit Button -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>


                                <button type="submit" name="submitnykund" class="btn btn-primary">Lägg till kund</button>
                            </div>
                    </div>
                </div>
            </div>
            </form>
        </div>




        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#secondModal">Lägg till kund</button>

        <div class="modal fade" id="secondModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Lägg till kund</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            <label for="fname">First name:</label>
                            <input type="text" id="fname" name="fname" onkeyup="showClassmates(this.value)">
                        </form>
                        <!-- Display search results inside the modal -->
                        <p><strong>Suggestions:</strong><br><br> <span id="class-list"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

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








        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

</html>