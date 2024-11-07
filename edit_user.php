<?php

include_once 'includes/header.php';
if($user->checkLoginStatus()){
    if(!$user->checkUserRole(300)){
        header("Location: home.php");
    }
}

$userInfoArray = $user->getUserInfo($_GET['uid']);
$roleArray = $pdo->query("SELECT * FROM table_roles")->fetchAll();

if(isset($_POST['admin-update-submit'])){
    $uStatus = isset($_POST['is-disabled']) ? 0 : 1;
    $feedback = $user->checkUserRegisterInput($_POST['uname'], $_POST['umail'], $_POST['npass'], $_POST['npassrepeat']);
    
    if($feedback === 1){
        $editFeedback = $user->editUserInfo($_POST['umail'], $_POST['opass'], $_POST['npass'], $_GET['uid'], $_POST['urole'], $uStatus);
    } else {
        foreach($feedback as $item){
            echo $item;
        }
    }
}
?>

<div class="container mt-5">
    <h1>Edit User Info</h1>
    <form method="post" class="mb-5">
        <div class="form-group">
            <label for="uname">Username</label>
            <input type="text" class="form-control" name="uname" id="uname" value="<?php echo $userInfoArray['u_name'] ?>" readonly>
        </div>
        
        <div class="form-group">
            <label for="umail">Email</label>
            <input type="email" class="form-control" name="umail" id="umail" value="<?php echo $userInfoArray['u_email'] ?>">
        </div>

        <input type="hidden" name="opass" id="opass" value="asdf1234" readonly>

        <div class="form-group">
            <label for="npass">New Password</label>
            <input type="password" class="form-control" name="npass" id="npass">
        </div>

        <div class="form-group">
            <label for="npassrepeat">Repeat New Password</label>
            <input type="password" class="form-control" name="npassrepeat" id="npassrepeat">
        </div>

        <div class="form-group">
            <label for="role">User Role</label>
            <select name="urole" id="role" class="form-control">
                <?php 
                    foreach($roleArray as $role){
                        $selected = ($role["r_id"] === $userInfoArray['u_role_fk']) ? "selected" : "";
                        echo "<option{$selected} value='{$role["r_id"]}'>{$role["r_name"]}</option>";
                    }
                ?>
            </select>
        </div>

        <button type="submit" name="admin-update-submit" class="btn btn-success mt-3">Update</button>
    </form>

    <a href="confirm-delete.php?uid=<?php echo $_GET['uid']?>" class="btn btn-danger">Delete this user</a>
</div>

<?php 
include_once 'includes/footer.php';
?>
