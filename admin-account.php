<?php
include_once 'includes/class.user.php';
include_once 'includes/header.php';

if($user->checkLoginStatus()){
	if(!$user->checkUserRole(300)){
		header("Location: home.php");
	}
}

if ($user->checkLoginStatus()) {
    if (isset($_POST['admin-update-submit'])) {
        $user->editCustInfo(
            $_POST['cust_uid'],  $_POST['cust_fname'], $_POST['cust_lname'],  $_POST['cust_tel'],  $_POST['cust_epost'], $_POST['cust_adress'],  $_POST['cust_postnummer'],  $_POST['cust_ort'] 
        );
    }
}


$uid = $_GET['uid']; 
$CustInfo = $user->getCustInfo($uid);
?>

<div class="container">
    <h1>Edit user info</h1>
    <form method="post" class="mb-5">
        
        <label for="cust_uid">User ID</label><br>
        <input type="text" name="cust_uid_display" id="cust_uid_display" value="<?php echo $uid; ?>" readonly><br>
        <input type="hidden" name="cust_uid" value="<?php echo $uid; ?>"><br>

        <label for="cust_fname">First name</label><br>
        <input type="text" name="cust_fname" id="cust_fname" value="<?php echo htmlspecialchars($CustInfo['cust_fname']); ?>"><br>

        <label for="cust_lname">Last name</label><br>
        <input type="text" name="cust_lname" id="cust_lname" value="<?php echo htmlspecialchars($CustInfo['cust_lname']); ?>"><br>

        <label for="cust_tel">Phone</label><br>
        <input type="text" name="cust_tel" id="cust_tel" value="<?php echo htmlspecialchars($CustInfo['cust_tel']); ?>"><br>

        <label for="cust_epost">Email</label><br>
        <input type="text" name="cust_epost" id="cust_epost" value="<?php echo htmlspecialchars($CustInfo['cust_epost']); ?>"><br>

        <label for="cust_adress">Address</label><br>
        <input type="text" name="cust_adress" id="cust_adress" value="<?php echo htmlspecialchars($CustInfo['cust_adress']); ?>"><br>

        <label for="cust_postnummer">Postnumber</label><br>
        <input type="text" name="cust_postnummer" id="cust_postnummer" value="<?php echo htmlspecialchars($CustInfo['cust_postnummer']); ?>"><br>

        <label for="cust_ort">City</label><br>
        <input type="text" name="cust_ort" id="cust_ort" value="<?php echo htmlspecialchars($CustInfo['cust_ort']); ?>"><br>

        <input type="submit" name="admin-update-submit" value="Update" class="btn btn-success">
    </form>

    <a href="confirm-delete-kund.php?uid=<?php echo $uid; ?>" class="btn btn-danger">Delete this user</a>
</div>

<?php 
include_once 'includes/footer.php';
?>
