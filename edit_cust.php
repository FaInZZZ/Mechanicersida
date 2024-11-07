<?php
include_once 'includes/class.user.php';
include_once 'includes/header.php';

if($user->checkLoginStatus()){
    if(!$user->checkUserRole(10)){
        header("Location: home.php");
        exit;
    }
}

if ($user->checkLoginStatus()) {
    if (isset($_POST['admin-update-submit'])) {
        // Input sanitization should be added here to ensure safe data update
        $user->editCustInfo(
            $_POST['cust_uid'], 
            $_POST['cust_fname'], 
            $_POST['cust_lname'], 
            $_POST['cust_tel'], 
            $_POST['cust_epost'], 
            $_POST['cust_adress'], 
            $_POST['cust_postnummer'], 
            $_POST['cust_ort']
        );
    }
}

$uid = $_GET['uid']; 
$CustInfo = $user->getCustInfo($uid);
?>

<div class="container mt-4">
    <h1>Edit User Information</h1>

    <!-- Display success or error message -->
    <?php if(isset($updateStatus) && $updateStatus == 'success'): ?>
        <div class="alert alert-success">User information updated successfully!</div>
    <?php elseif(isset($updateStatus) && $updateStatus == 'error'): ?>
        <div class="alert alert-danger">An error occurred while updating the information. Please try again.</div>
    <?php endif; ?>

    <form method="post" class="mb-5">
        
        <div class="form-group">
            <label for="cust_uid">User ID</label>
            <input type="text" name="cust_uid_display" id="cust_uid_display" class="form-control" value="<?php echo $uid; ?>" readonly>
            <input type="hidden" name="cust_uid" value="<?php echo $uid; ?>">
        </div>

        <div class="form-group">
            <label for="cust_fname">First Name</label>
            <input type="text" name="cust_fname" id="cust_fname" class="form-control" value="<?php echo htmlspecialchars($CustInfo['cust_fname']); ?>">
        </div>

        <div class="form-group">
            <label for="cust_lname">Last Name</label>
            <input type="text" name="cust_lname" id="cust_lname" class="form-control" value="<?php echo htmlspecialchars($CustInfo['cust_lname']); ?>">
        </div>

        <div class="form-group">
            <label for="cust_tel">Phone</label>
            <input type="text" name="cust_tel" id="cust_tel" class="form-control" value="<?php echo htmlspecialchars($CustInfo['cust_tel']); ?>">
        </div>

        <div class="form-group">
            <label for="cust_epost">Email</label>
            <input type="email" name="cust_epost" id="cust_epost" class="form-control" value="<?php echo htmlspecialchars($CustInfo['cust_epost']); ?>">
        </div>

        <div class="form-group">
            <label for="cust_adress">Address</label>
            <input type="text" name="cust_adress" id="cust_adress" class="form-control" value="<?php echo htmlspecialchars($CustInfo['cust_adress']); ?>">
        </div>

        <div class="form-group">
            <label for="cust_postnummer">Post Number</label>
            <input type="text" name="cust_postnummer" id="cust_postnummer" class="form-control" value="<?php echo htmlspecialchars($CustInfo['cust_postnummer']); ?>">
        </div>

        <div class="form-group">
            <label for="cust_ort">City</label>
            <input type="text" name="cust_ort" id="cust_ort" class="form-control" value="<?php echo htmlspecialchars($CustInfo['cust_ort']); ?>">
        </div>

        <button type="submit" name="admin-update-submit" class="btn btn-success">Update</button>
    </form>

    <a href="confirm-delete-kund.php?uid=<?php echo $uid; ?>" class="btn btn-danger">Delete This User</a>
</div>

<?php 
include_once 'includes/footer.php';
?>
