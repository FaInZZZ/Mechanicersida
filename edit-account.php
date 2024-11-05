<?php
include_once 'includes/header.php';

if ($user->checkLoginStatus()) {
    if (!$user->checkUserRole(300)) {
        header("Location: home.php");
    }
}

$user->checkLoginStatus();

if (isset($_POST['update-submit'])) {
    $feedback = $user->checkUserRegisterInput($_SESSION['user_name'], $_POST['umail'], $_POST['npass'], $_POST['npassrepeat']);

    if ($feedback === 1) {
        $user->editUserInfo($_POST['umail'], $_POST['opass'], $_POST['npass'], $_SESSION['user_id'], $_SESSION['user_role'], 1);
        echo '<div class="alert alert-success">User information updated successfully!</div>';
    } else {
        foreach ($feedback as $item) {
            echo "<div class='alert alert-danger'>{$item}</div>";
        }
    }
}
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Edit User Info</h1>

    <form method="post">
        <div class="form-group">
            <label for="uname">Username</label>
            <input type="text" name="uname" id="uname" class="form-control" value="<?php echo $_SESSION['user_name']; ?>" disabled>
        </div>

        <div class="form-group">
            <label for="umail">Email</label>
            <input type="email" name="umail" id="umail" class="form-control" value="<?php echo $_SESSION['user_mail']; ?>">
        </div>

        <div class="form-group">
            <label for="opass">Old Password</label>
            <input type="password" name="opass" id="opass" class="form-control">
        </div>

        <div class="form-group">
            <label for="npass">New Password</label>
            <input type="password" name="npass" id="npass" class="form-control">
        </div>

        <div class="form-group">
            <label for="npassrepeat">Repeat New Password</label>
            <input type="password" name="npassrepeat" id="npassrepeat" class="form-control">
        </div>

        <button type="submit" name="update-submit" class="btn btn-primary btn-block">Update Info</button>
    </form>
</div>

<?php 
include_once 'includes/footer.php';
?>
