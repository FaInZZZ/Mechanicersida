<?php
include_once 'includes/header.php';

if ($user->checkLoginStatus()) {
    if (!$user->checkUserRole(300)) {
        header("Location: home.php");
    }
}

if (isset($_POST['search-submit'])) {
    $userArray = $user->searchUsers($_POST['u_name']);
  
}
?>

<div class="container">
    <h1>Edit User Info</h1>
    <form method="post">
        <label for="u_name">Name or Address</label><br>
        <input type="text" name="u_name" id="u_name" placeholder="Enter name or address"><br>
        <input type="submit" name="search-submit" value="Search">
    </form>
    
    <div class="row">
        <?php
        if (isset($userArray)) {
            foreach ($userArray as $userRow) {
                echo "
                <div class='row'>
                    <div class='col'>{$userRow["u_name"]}</div>
                    <div class='col'>{$userRow["u_email"]}</div>
                    <div class='col'>
                        <a href='edit_user.php?uid={$userRow["u_id"]}'>Edit</a>
                    </div> 
                </div>
                ";
            }
        }
        ?>
    </div>
</div>

<?php 
include_once 'includes/footer.php';
?>
