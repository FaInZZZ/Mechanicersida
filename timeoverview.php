<?php

include_once 'includes/functions.php';
include_once 'includes/header.php';


if($user->checkLoginStatus()){
	if(!$user->checkUserRole(300)){
		header("Location: home.php");
	}
}



if (isset($_POST['Datesubmit'])) {
    getTimeOverview($pdo);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Time Overview</title>
</head>
<body>
    <form method="POST" action="timeoverview.php">
        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" required>
        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" required>
        <button type="submit" name="Datesubmit">Submit</button>
    </form>
</body>
</html>
