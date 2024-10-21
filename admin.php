<?php
include_once 'includes/header.php';
$user->checkLoginStatus();
if(isset($_POST['search-submit'])){
	$userArray = $user->searchCust($_POST['cust_fname']);
	print_r($userArray);

}
?>


<div class="container">
<h1>Edit user info</h1>
    <form method="post">
		<label for="unamemail">Username or mail</label><br>
        <input type="text" name="cust_fname" id="cust_fname" value="" placeholder="Input"><br>
        <input type="submit" name="search-submit" value="Search">
    </form>
	
	<div class="row">
	<?php
	if(isset($userArray)){
		foreach($userArray as $userRow){
			echo "
			<div class='row'>
				<div class='col'>{$userRow["cust_lname"]}</div>
				<div class='col'>
					<a href='admin-account.php?uid={$userRow["id_cust"]}'>Link</a>
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