<?php
include_once 'includes/config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_projekt'])) {
    $id_projekt = $_POST['id_projekt'];

    try {

        $delete_stmt = $pdo->prepare("DELETE FROM table_projekt WHERE id_projekt = ?");
        $delete_stmt->execute([$id_projekt]);
        header('location: active_projects.php');
        exit();
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger' role='alert'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
} else {
    echo "<div class='alert alert-danger' role='alert'>No project ID specified for deletion.</div>";
}
?>
