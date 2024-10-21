<?php

include_once 'includes/header.php';
if($user->checkLoginStatus()){
}

if(isset($_POST['admin-update-submit'])){
    $user->editCustInfo($_POST);
}

$userInfoArray = $user->getCustInfo($_GET['uid']);

?>

<div class="container">
    <h1>Edit user info</h1>
    <form method="post" class="mb-5">
        <label for="cust_fname">First name</label><br>
        <input type="text" name="cust_fname" id="cust_fname" value="<?php echo $userInfoArray['cust_fname'] ?>" readonly><br>

        <label for="cust_lname">Last name</label><br>
        <input type="text" name="cust_lname" id="cust_lname" value="<?php echo $userInfoArray['cust_lname'] ?>" readonly><br>

        <label for="cust_tel">Phone</label><br>
        <input type="text" name="cust_tel" id="cust_tel" value="<?php echo $userInfoArray['cust_tel'] ?>"><br>

        <label for="cust_epost">Email</label><br>
        <input type="text" name="cust_epost" id="cust_epost" value="<?php echo $userInfoArray['cust_epost'] ?>"><br>

        <label for="cust_adress">Adress</label><br>
        <input type="text" name="cust_adress" id="cust_adress" value="<?php echo $userInfoArray['cust_adress'] ?>"><br>

        <label for="cust_postnummer">Postnumber</label><br>
        <input type="text" name="cust_postnummer" id="cust_postnummer" value="<?php echo $userInfoArray['cust_postnummer'] ?>"><br>

        <label for="cust_ort">Ort</label><br>
        <input type="text" name="cust_ort" id="cust_ort" value="<?php echo $userInfoArray['cust_ort'] ?>"><br>

        <input type="submit" name="admin-update-submit" value="Update" class="btn btn-success">
    </form>

    <a href="confirm-delete.php?uid=<?php echo $_GET['uid']?>" class="btn btn-danger">Delete this user</a>

</div>	

<?php 
include_once 'includes/footer.php';
?>
