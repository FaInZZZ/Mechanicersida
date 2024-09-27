<?php
include_once 'includes/header.php';
include_once 'includes/functions.php';
include_once 'includes/class.user.php';
include_once 'includes/search.php';

if(isset($_POST['search-submit'])){
	$userArray = $user->searchUsers($_POST['unamemail']);
	print_r($userArray);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List</title>
    <script src="ajax.js"></script>
</head>
<body>


    <div class=" mt-3 container text-center">
    <h1>Customer List</h1>
    
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










    </div>

    

