<?php

if($user->checkLoginStatus()){
	if(!$user->checkUserRole(300)){
		header("Location: home.php");
	}
}

include_once 'includes/header.php';
$user->checkLoginStatus();
if(isset($_POST['update-submit'])){
	$feedback = $user->checkUserRegisterInput($_SESSION['user_name'], $_POST['umail'], $_POST['npass'], $_POST['npassrepeat']);
	
	if($feedback === 1){
		$user->editUserInfo($_POST['umail'], $_POST['opass'], $_POST['npass'], $_SESSION['user_id'], $_SESSION['user_role'], 1);
	}
	else{
		foreach($feedback as $item){
			echo $item;
		}
	}
}
?>


<div class="container">
<h1>Edit user info</h1>
    <form method="post">
		<label for="uname">Username</label><br>
        <input type="text" name="uname" id="uname" value="<?php echo $_SESSION['user_name'] ?>" disabled><br>
		<label for="umail">Email</label><br>
        <input type="text" name="umail" id="umail" value="<?php echo $_SESSION['user_mail'] ?>"><br>
		<label for="upass">Old password</label><br>
        <input type="password" name="opass" id="opass"><br>
		<label for="upass">New password</label><br>
        <input type="password" name="npass" id="npass"><br>
		<label for="upassrepeat">Repeat new password</label><br>
        <input type="password" name="npassrepeat" id="npassrepeat"><br>
        <input type="submit" name="update-submit" value="Register">
    </form>
</div>	
<?php 
include_once 'includes/footer.php';
?>