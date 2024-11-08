<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

if ($user->checkLoginStatus()) {
    if (!$user->checkUserRole(10)) {
        header("Location: home.php");
        exit;
    }
}

$CustInfo = false;
if (isset($_GET['uid'])) {
    $CustInfo = $user->getCustInfo($_GET['uid']);
}

$deleteFeedback = null;
if (isset($_POST['confirm-delete'])) {
    $deleteFeedback = $user->deleteCust($_GET['uid']);
}
?>

<div class="container p-5">
<?php 
if ($deleteFeedback === null) {
    if ($CustInfo && isset($CustInfo['cust_fname'])) {
        echo "<h2 class='text-center my-5'>Are you sure that you want to delete the user {$CustInfo['cust_fname']}?</h2>";
        
        echo "<div class='row justify-content-center'>
            <a href='edit_cust.php?uid={$_GET['uid']}' class='btn btn-warning' 
            style='display: block; max-width: 300px;'>Back</a>
            <form method='post' action='' style='display: block; max-width: 300px;'>
                <input type='submit' name='confirm-delete' class='btn btn-danger' value='Delete this user'>
            </form>
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
