<?php

include_once 'includes/header.php';
if($user->checkLoginStatus()){
	if(!$user->checkUserRole(200)){
		header("Location: home.php");
	}
}

$userInfoArray = $user->getUserInfo($_GET['uid']);


?>


<div class="container">
<h1>Edit user info</h1>
    <form method="post" class="mb-5">
		<label for="uname">Username</label><br>
        <input type="text" name="uname" id="uname" value="<?php echo $userInfoArray['u_name'] ?>" readonly><br>
		<label for="umail">Email</label><br>
        <input type="text" name="umail" id="umail" value="<?php echo $userInfoArray['u_email'] ?>"><br>
        <input type="hidden" name="opass" id="opass" value="asdf1234" readonly>
		<label for="upass">New password</label><br>
        <input type="password" name="npass" id="npass"><br>
		<label for="upassrepeat">Repeat new password</label><br>
        <input type="password" name="npassrepeat" id="npassrepeat"><br>
		<label for="role">User role</label><br>
		
        <input type="submit" name="admin-update-submit" value="Update" class="btn btn-success">
    </form>
	

	<a href="confirm-delete.php?uid=<?php echo $_GET['uid']?>" class="btn btn-danger">Delete this user</a>

</div>	
<?php 
include_once 'includes/footer.php';
?>