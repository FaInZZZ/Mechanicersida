<?php
include_once 'includes/header.php';

if ($user->checkLoginStatus()) {
    if (!$user->checkUserRole(300)) {
        header("Location: home.php");
    }
}

if (isset($_POST['search-submit'])) {
    $userArray = $user->searchUsers($_POST['u_name']);
}
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Edit User Info</h1>

    <form method="post" class="mb-4">
        <div class="form-group">
            <label for="u_name">Name or Address</label>
            <input type="text" name="u_name" id="u_name" class="form-control" placeholder="Enter name or address">
        </div>
        <button type="submit" name="search-submit" class="btn btn-primary btn-block">Search</button>
    </form>

    <?php if (isset($userArray) && count($userArray) > 0): ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($userArray as $userRow) {
                    echo "
                    <tr>
                        <td>{$userRow['u_name']}</td>
                        <td>{$userRow['u_email']}</td>
                        <td>
                            <a href='edit_user.php?uid={$userRow["u_id"]}' class='btn btn-warning btn-sm'>Edit</a>
                        </td>
                    </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <p class="alert alert-info">No user found. Please try another search.</p>
    <?php endif; ?>
</div>

<?php 
include_once 'includes/footer.php';
?>
