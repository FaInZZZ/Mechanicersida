<?php
include_once 'includes/header.php';

if($user->checkLoginStatus()){
	if(!$user->checkUserRole(300)){
		header("Location: home.php");
	}
}

if(isset($_POST['search-submit'])){
	$userArray = $user->searchCust($_POST['cust_fname']);

}
?>


<div class="container">
<h1>Edit Customer info</h1>
    <form method="post">
		<label for="unamemail">Förnamn eller Efternamn</label><br>
        <input type="text" name="cust_fname" id="cust_fname" value="" placeholder="Input"><br>
        <input type="submit" name="search-submit" value="Search">
    </form>
	
	<div class="row">
	<?php
	if(isset($userArray)){
		foreach($userArray as $userRow){
			echo "
			<div class='row'>
			<div class='col'>{$userRow["cust_fname"]}</div>
				<div class='col'>{$userRow["cust_lname"]}</div>
				<div class='col'>
					<a href='edit_cust.php?uid={$userRow["id_cust"]}'>Link</a>
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