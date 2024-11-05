<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';
if($user->checkLoginStatus()){
	if(!$user->checkUserRole(300)){
		header("Location: home.php");
	}
}
$userInfoArray = $user->getUserInfo($_GET['uid']);

if(isset($_POST['confirm-delete'])){
	$deleteFeedback = $user->deleteUser($_GET['uid']);
}

?>


<div class="container p-5">
<?php 
	if(!isset($deleteFeedback)){
		echo "<h2 class='text-center my-5'>Are you sure that you want to delete the user {$userInfoArray['u_name']}</h2>";
		
		echo "<div class='row justify-content-center'>
			<a href='admin-account.php?uid={$_GET['uid']}' class='btn btn-warning' 
			style='display: block; max-width: 300px;'>No, get me out of here!!!</a>
			<form method='post' action='' style='display: block; max-width: 300px;'>
				<input type='submit' name='confirm-delete' class='btn btn-danger' value='Delete this user'>
			</form>";
	}
	else {
		echo "<h2 class='text-center my-5'>{$deleteFeedback}</h2>";
	}
?>
	
	</div>
</div>	
<?php 
include_once 'includes/footer.php';
?>