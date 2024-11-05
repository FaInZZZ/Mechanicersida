<?php
require_once 'includes/class.user.php';
require_once 'includes/functions.php';
require_once 'includes/config.php';
$user = new User($pdo);

if(isset($_GET['logout'])){
	$user->logout();
}
//Menylänkar synliga för inloggade oberoende av roll
$menuLinks = array(
    array(
      "title" => "New",
      "url" => "newproject.php"
    ),
    array(
      "title" => "Projects",
      "url" => "all_projects.php"
    ),
  array(
    "title" => "Active",
    "url" => "active_projects.php"
  )

);
// Menylänkar synliga enbart för admins
$adminMenuLinks = array(
    array(
        "title" => "Redigera konton",
        "url" => "redigera_user_search.php"
    ),
    array(
        "title" => "Account",
        "url" => "edit-account.php"
      ),
      array(
        "title" => "Redigera Kund",
        "url" => "redigera_kund_search.php"
      )
);


?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Powerol</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="assets/css/style.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<style>
    .navbar-brand {
        font-weight: bold;
        font-size: 1.5rem;
        color: #fff !important;
    }
    .navbar-nav .nav-item .nav-link {
        margin-right: 10px;
        color: #ddd;
        font-size: 1rem;
        transition: color 0.3s, background-color 0.3s;
    }
    .navbar-nav .nav-item .nav-link:hover {
        color: #fff;
        background-color: #495057;
        border-radius: 5px;
    }
    .navbar-nav .nav-item .nav-link.active {
        color: #fff;
        background-color: #343a40;
        border-radius: 5px;
    }
    .navbar-toggler {
        border-color: #fff;
    }
    .navbar-toggler-icon {
        background-image: url('data:image/svg+xml;utf8,<svg viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg"><path stroke="rgba(255, 255, 255, 0.7)" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"/></svg>');
    }
    .navbar {
        padding: 0.8rem 1rem;
    }
</style>
</head>
<body>
<header class="container-fluid bg-dark">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="active_projects.php">Powerol</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <?php
                    if(isset($_SESSION['user_id'])){
                        foreach($menuLinks as $menuItem){
                            $activeClass = ($_SERVER['PHP_SELF'] === '/' . $menuItem['url']) ? 'active' : '';
                            echo "<li class='nav-item'>
                                <a class='nav-link $activeClass' href='{$menuItem['url']}'>{$menuItem['title']}</a>
                            </li>";
                        }
                    }
                    if(isset($_SESSION['user_id'])){
                        if($user->checkUserRole(300)){
                            foreach($adminMenuLinks as $menuItem){
                                echo "<li class='nav-item'>
                                    <a class='nav-link' href='{$menuItem['url']}'>{$menuItem['title']}</a>
                                </li>";
                            }
                        }
                        echo "<li class='nav-item'>
                            <a class='nav-link' href='?logout=1'>Log out</a>
                        </li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
</body>
</html>
