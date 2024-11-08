<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

if ($user->checkLoginStatus()) {
    if (!$user->checkUserRole(300)) {
        header("Location: home.php");
        exit;
    }
}


$userInfoArray = false;
if (isset($_GET['uid'])) {
    $userInfoArray = $user->getUserInfo($_GET['uid']);
}

$deleteFeedback = null;
if (isset($_POST['confirm-delete'])) {
    $deleteFeedback = $user->deleteUser($_GET['uid']);
}
?>

<div class="container p-5">
<?php 
if ($deleteFeedback === null) {
    if ($userInfoArray && isset($userInfoArray['u_name'])) { 
        echo "<h2 class='text-center my-5'>Are you sure that you want to delete the user {$userInfoArray['u_name']}?</h2>";
        

        echo "<div class='row justify-content-center'>
            <div class='d-flex justify-content-center gap-3'>
                <a href='edit_user.php?uid={$_GET['uid']}' class='btn btn-warning' style='width: 200px;'>Back</a>
                <form method='post' action=''>
                    <input type='submit' name='confirm-delete' class='btn btn-danger' value='Delete this user' style='width: 200px;'>
                </form>
            </div>
        </div>";
    } else {
        echo "<h2 class='text-center my-5'>User not found or invalid ID.</h2>";
    }
} else {
    echo "<h2 class='text-center my-5'>{$deleteFeedback}</h2>";
}
?>
</div>


<?php 
include_once 'includes/footer.php';
?>
