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
    if(isset($_POST['is-disabled'])){
        $uStatus=0;
    }
    else{
        $uStatus=1;
    }
    $feedback = $user->checkUserRegisterInput($_POST['uname'], $_POST['umail'], $_POST['npass'], $_POST['npassrepeat']);
    
    if($feedback === 1){
        $editFeedback = $user->editUserInfo($_POST['umail'], $_POST['opass'], $_POST['npass'], $_GET['uid'], $_POST['urole'],$uStatus);
    }
    else{
        foreach($feedback as $item){
            echo $item;
        }
    }
}
?>

<div class="container">
<h1>Edit user info</h1>
    <form method="post" class="mb-5">
        <label for="uname">Username</label><br>
        <input type="text" name="uname" id="uname" value="<?php echo $userInfoArray['u_name'] ?>" readonly><br>
        <label for="umail">Email</label><br>
        <input type="text" name="umail" id="umail" value="<?php echo $userInfoArray['u_email'] ?>"><br>
        <input type="hidden" name="opass" id="opass" value="asdf1234" readonly>
        <label for="upass">New password</label><br>
        <input type="password" name="npass" id="npass"><br>
        <label for="upassrepeat">Repeat new password</label><br>
        <input type="password" name="npassrepeat" id="npassrepeat"><br>
        <label for="role">User role</label><br>
        <select name="urole" id="role">
        <?php 
            foreach($roleArray as $role){
                if($role["r_id"] === $userInfoArray['u_role_fk']){
                    $selected = " selected";
                }
                else{
                    $selected = "";
                }
                echo "<option{$selected} value='{$role["r_id"]}'>{$role["r_name"]}</option>";
            }
        ?>
        </select><br>
        <label for="is-disabled"> Disable account</label>
        <input type="checkbox" id="is-disabled" name="is-disabled" value="1" <?php if($userInfoArray['u_status'] === 0){echo "checked";} ?>>
        <br>
        <input type="submit" name="admin-update-submit" value="Update" class="btn btn-success">
    </form>
    

    <a href="confirm-delete.php?uid=<?php echo $_GET['uid']?>" class="btn btn-danger">Delete this user</a>

</div>  
<?php 
include_once 'includes/footer.php';
?>
