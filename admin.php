<?php
include_once 'includes/header.php';
$user->checkLoginStatus();
if(isset($_POST['search-submit'])){
	$userArray = $user->searchUsers($_POST['unamemail']);
	print_r($userArray);

}
?>


<div class="container">
<h1>Edit user info</h1>
    <form method="post">
		<label for="unamemail">Username or mail</label><br>
        <input type="text" name="unamemail" id="unamemail" value="" placeholder="Input user name or mail"><br>
        <input type="submit" name="search-submit" value="Search">
    </form>
	
	<div class="row">
	<?php
	if(isset($userArray)){
		foreach($userArray as $userRow){
			echo "
			<div class='row'>
				<div class='col'>{$userRow["u_name"]}</div>
				<div class='col'>
					<a href='admin-account.php?uid={$userRow["u_id"]}'>Link</a>
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