<?php
include_once 'includes/header.php';

if ($user->checkLoginStatus()) {
    if (!$user->checkUserRole(10)) {
        header("Location: home.php");
    }
}

if (isset($_POST['search-submit'])) {
    $userArray = $user->searchCust($_POST['cust_fname']);
}
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Edit Customer Info</h1>

    <form method="post" class="mb-4">
        <div class="form-group">
            <label for="cust_fname">Förnamn eller Efternamn</label>
            <input type="text" name="cust_fname" id="cust_fname" class="form-control" placeholder="Input">
        </div>
        <button type="submit" name="search-submit" class="btn btn-primary btn-block">Search</button>
    </form>

    <?php if (isset($userArray) && count($userArray) > 0): ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Förnamn</th>
                    <th>Efternamn</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($userArray as $userRow) {
                    echo "
                    <tr>
                        <td>{$userRow['cust_fname']}</td>
                        <td>{$userRow['cust_lname']}</td>
                        <td>
                            <a href='edit_cust.php?uid={$userRow["id_cust"]}' class='btn btn-warning btn-sm'>Edit</a>
                        </td>
                    </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <p class="alert alert-info">No customer found. Please try another search.</p>
    <?php endif; ?>
</div>

<?php 
include_once 'includes/footer.php';
?>
