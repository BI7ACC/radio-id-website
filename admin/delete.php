<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $stmt = $pdo->prepare("DELETE FROM radio_ids WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: index.php");
    exit;
}
?>