 
 <?php
require_once 'includes/class.user.php';
require_once 'includes/functions.php';
require_once 'includes/config.php';
$user = new User($pdo);

if(isset($_GET['logout'])){
	$user->logout();
}

$menuLinks = array(
  array(
    "title" => "Projects",
    "url" => "project.php"
  )

);

$faktMenuLinks = array(
    array(
        "title" => "Billables",
        "url" => "fakturering.php"
      )
);
$adminMenuLinks = array(
      array(
        "title" => "Admin Page",
        "url" => "admin.php"
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

</head>
<body>
<header class="container-fluid bg-dark">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="project.php">Powerol</a>
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
                        if($user->checkUserRole(50)){
                            foreach($faktMenuLinks as $menuItem){
                                echo "<li class='nav-item'>
                                    <a class='nav-link' href='{$menuItem['url']}'>{$menuItem['title']}</a>
                                </li>";
                            }
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
