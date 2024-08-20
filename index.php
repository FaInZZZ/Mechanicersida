<?php
include_once 'includes/config.php';
include_once 'includes/functions.php';
include_once 'includes/header.php';

if(isset($_POST['user-login'])){
	$errorMessage = $user->login($_POST['uname'], $_POST['upass']);
}

?>


<div class="container">
<?php 
	//Om du nyligen registrerat dig -> visa
	if(isset($_GET['newuser'])){
		echo "	<div class='alert alert-success text-center mt-2' role='alert'>
					You have successfully registered. Please log in using the form below.
				</div>";
	}
	//Om det finns ett errormessage -> visa
	if(isset($errorMessage)){
		echo "<div class='alert alert-danger text-center mt-2' role='alert'>";
					
		foreach($errorMessage as $item){
		echo $item;
	}
	echo "</div>";
	}
	
	
	
?>
    <div class="container mt-5">
        <h1 class="mb-4">Login form</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="uname">Username or email</label>
                <input type="text" name="uname" id="uname" class="form-control mb-3">
            </div>
            <div class="form-group">
                <label for="upass">Password</label>
                <input type="password" name="upass" id="upass" class="form-control mb-4">
            </div>
            <button type="submit" name="user-login" class="btn btn-warning btn-block">Next</button>
        </form>
</div>	
<?php 
include_once 'includes/footer.php';
?>